<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Menangani proses checkout pesanan dari keranjang / halaman produk.
     */
    public function store(Request $request)
    {
        // Wajib login untuk melakukan pemesanan dan pembayaran
        if (!auth()->check()) {
            session(['url.intended' => route('cart.index')]);
            return redirect()->route('login')->with('warning', 'Silakan masuk (login) atau daftar akun terlebih dahulu untuk melanjutkan proses pembelian pesanan Anda.');
        }

        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:50',
            'customer_email'   => 'nullable|email|max:255',
            'shipping_address' => 'required|string',
            'product_id'       => 'nullable|exists:products,id',
            'quantity'         => 'nullable|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);

        // Jika tidak ada di request form dan tidak ada cart session
        if (!$productId && empty($cart)) {
            return back()->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        DB::beginTransaction();

        try {
            $totalAmount = 0;
            $cartItemsForSnap = [];
            $mainProductId = null;
            $totalQty = 0;

            // Kasus 1: Checkout dari session cart (bisa banyak item)
            if (!empty($cart)) {
                foreach ($cart as $id => $item) {
                    $product = Product::lockForUpdate()->find($id);
                    if (!$product) {
                        continue;
                    }

                    $itemQty = (int) ($item['quantity'] ?? 1);
                    if ($product->stock < $itemQty) {
                        DB::rollBack();
                        return back()->with('error', "Stok untuk produk '{$product->name}' tidak mencukupi! Sisa stok: {$product->stock}");
                    }

                    // Kurangi stok
                    $product->decrement('stock', $itemQty);

                    $subtotal = $product->price * $itemQty;
                    $totalAmount += $subtotal;
                    $totalQty += $itemQty;

                    if (!$mainProductId) {
                        $mainProductId = $product->id;
                    }

                    $cartItemsForSnap[$id] = [
                        'name'     => $product->name,
                        'price'    => (int) $product->price,
                        'quantity' => $itemQty,
                    ];
                }
            } 
            // Kasus 2: Checkout langsung per 1 produk
            elseif ($productId) {
                $product = Product::lockForUpdate()->findOrFail($productId);

                if ($product->stock < $quantity) {
                    DB::rollBack();
                    return back()->with('error', "Stok untuk produk '{$product->name}' tidak mencukupi! Sisa stok: {$product->stock}");
                }

                $product->decrement('stock', $quantity);
                $totalAmount = $product->price * $quantity;
                $totalQty = $quantity;
                $mainProductId = $product->id;

                $cartItemsForSnap[$productId] = [
                    'name'     => $product->name,
                    'price'    => (int) $product->price,
                    'quantity' => $quantity,
                ];
            }

            if ($totalAmount <= 0) {
                DB::rollBack();
                return back()->with('error', 'Total pembayaran tidak valid.');
            }

            $invoiceNumber = 'GS-' . date('Ymd') . '-' . rand(1000, 9999);

            // Buat Data Pesanan
            $order = Order::create([
                'user_id'            => auth()->id(),
                'invoice_number'     => $invoiceNumber,
                'customer_name'      => $request->customer_name ?? auth()->user()->name,
                'customer_phone'     => $request->customer_phone,
                'customer_email'     => $request->customer_email ?? auth()->user()->email,
                'shipping_address'   => $request->shipping_address,
                'product_id'         => $mainProductId,
                'quantity'           => $totalQty,
                'total_amount'       => $totalAmount,
                'status'             => 'menunggu pembayaran',
                'marketplace_source' => 'website',
            ]);

            // Generate Midtrans Snap Token
            $midtransService = new MidtransService();
            $snapToken = $midtransService->createSnapToken($order, $cartItemsForSnap);

            if ($snapToken) {
                $order->snap_token = $snapToken;
                $order->save();
            }

            DB::commit();

            // Kosongkan keranjang belanja
            session()->forget('cart');

            // Kirim WhatsApp tagihan awal
            $mainProduct = Product::find($mainProductId);
            $this->sendWhatsAppNotification($order, $mainProduct);

            // Redirect ke halaman pembayaran Midtrans
            return redirect()->route('orders.payment', $order->invoice_number);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Store Exception: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kendala sistem: ' . $e->getMessage());
        }
    }

    /**
     * Halaman Pembayaran Midtrans Snap Popup & Rincian Pesanan
     */
    public function payment($invoice_number)
    {
        $order = Order::with('product')->where('invoice_number', $invoice_number)->firstOrFail();

        // Jika sudah lunas, langsung arahkan ke halaman sukses
        if (in_array($order->status, ['paid', 'completed', 'dikirim'])) {
            return redirect()->route('orders.success', $order->invoice_number);
        }

        // Jika belum ada snap token, generate ulang
        if (!$order->snap_token) {
            $midtransService = new MidtransService();
            $snapToken = $midtransService->createSnapToken($order);
            if ($snapToken) {
                $order->snap_token = $snapToken;
                $order->save();
            }
        }

        $clientKey = config('midtrans.client_key') ?: env('MIDTRANS_CLIENT_KEY', '');
        $isProduction = (bool) config('midtrans.is_production', false);

        $snapJsUrl = $isProduction 
            ? 'https://app.midtrans.com/snap/snap.js' 
            : 'https://app.sandbox.midtrans.com/snap/snap.js';

        return view('orders.payment', compact('order', 'clientKey', 'snapJsUrl'));
    }

    /**
     * Halaman Sukses Pembayaran / Invoice Pesanan
     */
    public function success($invoice_number)
    {
        $order = Order::with('product')->where('invoice_number', $invoice_number)->firstOrFail();
        return view('orders.success', compact('order'));
    }

    /**
     * Endpoint Cek Status Pembayaran Pesanan via AJAX
     */
    public function checkStatus($invoice_number)
    {
        $order = Order::where('invoice_number', $invoice_number)->first();
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return response()->json([
            'invoice_number' => $order->invoice_number,
            'status'         => $order->status,
            'payment_status' => $order->payment_status,
            'is_paid'        => in_array($order->status, ['paid', 'completed', 'dikirim']),
        ]);
    }

    /**
     * Menangani aksi admin saat meng-ACC pesanan dan memasukkan nomor resi pengiriman.
     */
    public function updateTracking(Request $request, $id)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:255',
        ]);

        $order = Order::findOrFail($id);
        $product = Product::find($order->product_id);

        $order->tracking_number = $request->tracking_number;
        $order->status = 'dikirim';
        $order->save();

        // Kirim WhatsApp pemberitahuan resi ke pelanggan
        $this->sendShippingNotification($order, $product);

        return back()->with('success', 'Nomor resi berhasil disimpan & notifikasi WA pengiriman telah dikirim ke pelanggan.');
    }

    /**
     * Kirim invoice & info pembayaran ke Fonnte WhatsApp
     */
    private function sendWhatsAppNotification($order, $product)
    {
        $token = env('FONNTE_TOKEN');
        if (!$token || !$order->customer_phone) {
            return;
        }

        $productName = $product ? $product->name : 'Produk Gitania Skincare';

        $paymentUrl = route('orders.payment', $order->invoice_number);

        $message = "Halo *{$order->customer_name}*,\n\n" .
                   "Terima kasih telah berbelanja di *Gitania Skincare*! 🌸\n" .
                   "Pesanan Anda berhasil dibuat dengan detail berikut:\n\n" .
                   "📄 No. Invoice: *{$order->invoice_number}*\n" .
                   "📦 Produk: {$productName}\n" .
                   "🔢 Jumlah: {$order->quantity} pcs\n" .
                   "💰 Total Pembayaran: *Rp " . number_format($order->total_amount, 0, ',', '.') . "*\n" .
                   "📍 Alamat Kirim: {$order->shipping_address}\n\n" .
                   "💳 *Silakan lakukan pembayaran online instan (QRIS, GoPay, Transfer Bank, ShopeePay, CC) melalui link berikut:*\n" .
                   "🔗 {$paymentUrl}\n\n" .
                   "⚠️ *Status Pesanan:* Menunggu Pembayaran\n\n" .
                   "Setelah pembayaran selesai, status pesanan Anda akan otomatis terverifikasi. Terima kasih! ✨";

        try {
            Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target'      => $order->customer_phone,
                'message'     => $message,
                'countryCode' => '62',
            ]);
        } catch (\Exception $e) {
            Log::error('Fonnte WhatsApp Error: ' . $e->getMessage());
        }
    }

    /**
     * Notifikasi resi pengiriman ke WhatsApp saat paket dikirim
     */
    private function sendShippingNotification($order, $product)
    {
        $token = env('FONNTE_TOKEN');
        if (!$token || !$order->customer_phone) {
            return;
        }

        $productName = $product ? $product->name : 'Produk Gitania Skincare';

        $message = "Halo *{$order->customer_name}*,\n\n" .
                   "Kabar baik! Pesanan Anda di *Gitania Skincare* sedang dalam proses pengiriman. 📦✨\n\n" .
                   "📄 No. Invoice: *{$order->invoice_number}*\n" .
                   "📦 Produk: {$productName}\n" .
                   "🔢 Jumlah: {$order->quantity} pcs\n" .
                   "🚚 Ekspedisi: JNE / J&T Regular\n" .
                   "🔍 No. Resi: *{$order->tracking_number}*\n" .
                   "📍 Alamat Tujuan: {$order->shipping_address}\n\n" .
                   "Anda dapat melacak paket menggunakan nomor resi di atas. Terima kasih telah mempercayakan perawatan kulit Anda bersama Gitania Skincare! 🌸";

        try {
            Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target'      => $order->customer_phone,
                'message'     => $message,
                'countryCode' => '62',
            ]);
        } catch (\Exception $e) {
            Log::error('Fonnte Shipping WhatsApp Error: ' . $e->getMessage());
        }
    }
}
