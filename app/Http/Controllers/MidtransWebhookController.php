<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class MidtransWebhookController extends Controller
{
    /**
     * Handle webhook / HTTP notification dari Midtrans
     */
    public function handle(Request $request)
    {
        $payload = $request->all();
        Log::info('Midtrans Webhook Received:', $payload);

        $orderId           = $payload['order_id'] ?? null;
        $statusCode        = $payload['status_code'] ?? null;
        $grossAmount       = $payload['gross_amount'] ?? null;
        $signatureKey      = $payload['signature_key'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus       = $payload['fraud_status'] ?? null;
        $paymentType       = $payload['payment_type'] ?? null;
        $transactionId     = $payload['transaction_id'] ?? null;

        if (!$orderId || !$statusCode || !$grossAmount || !$signatureKey) {
            Log::warning('Midtrans Webhook: Payload tidak lengkap');
            return response()->json(['message' => 'Payload tidak lengkap'], 400);
        }

        // 1. Verifikasi Signature Key Midtrans
        $serverKey = config('midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY', '');
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey !== $expectedSignature) {
            Log::error("Midtrans Webhook: Signature mismatch! Order: {$orderId}");
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 2. Cari Data Order di Database
        $order = Order::where('invoice_number', $orderId)->first();

        if (!$order) {
            Log::warning("Midtrans Webhook: Order {$orderId} tidak ditemukan di database");
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Simpan info pembayaran
        $order->payment_type = $paymentType;
        $order->midtrans_transaction_id = $transactionId;

        $previousStatus = $order->status;

        // 3. Update Status Pesanan Berdasarkan Status Transaksi Midtrans
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $order->payment_status = 'challenge';
                $order->status = 'menunggu pembayaran';
            } elseif ($fraudStatus == 'accept') {
                $order->payment_status = 'settlement';
                $order->status = 'paid';
            }
        } elseif ($transactionStatus == 'settlement') {
            $order->payment_status = 'settlement';
            $order->status = 'paid';
        } elseif ($transactionStatus == 'pending') {
            $order->payment_status = 'pending';
            $order->status = 'menunggu pembayaran';
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $order->payment_status = $transactionStatus;
            $order->status = 'cancelled';

            // Jika sebelumnya stok sudah berkurang dan sekarang dibatalkan/expired, kembalikan stok
            if ($previousStatus !== 'cancelled' && $order->product_id && $order->quantity) {
                $product = Product::find($order->product_id);
                if ($product) {
                    $product->increment('stock', $order->quantity);
                    Log::info("Midtrans Webhook: Stok dikembalikan {$order->quantity} pcs untuk produk {$product->name} (Order {$orderId} {$transactionStatus})");
                }
            }
        }

        $order->save();

        Log::info("Midtrans Webhook: Order {$orderId} status diupdate ke: {$order->status} (Payment Status: {$order->payment_status})");

        // 4. Jika Pembayaran Berhasil (Paid/Settlement) dan sebelumnya belum lunas, kirim notifikasi WA
        if ($order->status === 'paid' && $previousStatus !== 'paid') {
            $this->sendPaymentSuccessWhatsApp($order);
        }

        return response()->json(['status' => 'success', 'message' => 'Notification processed successfully'], 200);
    }

    /**
     * Kirim pesan WhatsApp konfirmasi pembayaran berhasil via Fonnte
     */
    private function sendPaymentSuccessWhatsApp(Order $order)
    {
        $token = env('FONNTE_TOKEN');
        if (!$token || !$order->customer_phone) {
            return;
        }

        $productName = $order->product ? $order->product->name : 'Produk Gitania Skincare';
        $paymentMethod = strtoupper(str_replace('_', ' ', $order->payment_type ?? 'Midtrans'));

        $message = "Halo *{$order->customer_name}*,\n\n" .
                   "🎉 *PEMBAYARAN ANDA BERHASIL DIVERIFIKASI!* ✨\n\n" .
                   "Terima kasih telah melakukan pembayaran di *Gitania Skincare*.\n" .
                   "📄 No. Invoice: *{$order->invoice_number}*\n" .
                   "💳 Metode Pembayaran: *{$paymentMethod}*\n" .
                   "💰 Total Dibayar: *Rp " . number_format($order->total_amount, 0, ',', '.') . "*\n" .
                   "📦 Detail Produk: {$productName} ({$order->quantity} pcs)\n" .
                   "📍 Alamat Pengiriman: {$order->shipping_address}\n\n" .
                   "✅ *Status Pesanan:* Siap Diproses & Dikemas\n\n" .
                   "Pesanan Anda sedang kami siapkan untuk pengiriman. Kami akan menginfokan nomor resi begitu paket diserahkan ke kurir. Terima kasih telah mempercayakan perawatan kulit Anda bersama Gitania Skincare! 🌸";

        try {
            Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target'      => $order->customer_phone,
                'message'     => $message,
                'countryCode' => '62',
            ]);
        } catch (\Exception $e) {
            Log::error('Fonnte Payment WhatsApp Error: ' . $e->getMessage());
        }
    }
}
