<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    // Menampilkan daftar pesanan masuk dengan fitur pencarian & paginasi
    public function index(Request $request)
    {
        $search = $request->input('search');

        $orders = Order::when($search, function ($query, $search) {
                    return $query->where('invoice_number', 'like', "%{$search}%")
                                 ->orWhere('customer_name', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate(10)
                ->withQueryString();

        return view('admin.orders.index', compact('orders', 'search'));
    }

    // Memperbarui status pesanan, nomor resi, dan mengirim notifikasi WhatsApp otomatis
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,packed,shipping,completed,cancelled',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $order->update([
            'status' => $request->status,
            'tracking_number' => $request->input('tracking_number'),
        ]);

        // Kirim WhatsApp otomatis ke pelanggan saat status diperbarui
        $this->sendAdminStatusNotification($order);

        return redirect()->back()->with('success', 'Status pesanan dan nomor resi berhasil diperbarui & notifikasi WA terkirim!');
    }

    // Fungsi privat untuk mengirim pesan WhatsApp dari admin via Fonnte
    private function sendAdminStatusNotification($order)
    {
        $token = env('FONNTE_TOKEN');
        if (!$token) {
            return;
        }

        $product = Product::find($order->product_id);
        $productName = $product ? $product->name : 'Produk Skincare';

        $message = "Halo *{$order->customer_name}*,\n\n" .
                   "Status pesanan Anda di *Gitania Skincare* telah diperbarui!\n\n" .
                   "📄 No. Invoice: *{$order->invoice_number}*\n" .
                   "📦 Produk: {$productName}\n" .
                   "🔄 Status Terbaru: *".ucwords($order->status)."*\n";

        if (!empty($order->tracking_number)) {
            $message .= "🔍 No. Resi: *{$order->tracking_number}*\n";
        }

        $message .= "\nTerima kasih telah berbelanja di Gitania Skincare! 🌸";

        Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target' => $order->customer_phone,
            'message' => $message,
            'countryCode' => '62',
        ]);
    }
}
