<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY', '');
        Config::$clientKey = config('midtrans.client_key') ?: env('MIDTRANS_CLIENT_KEY', '');
        Config::$isProduction = (bool) config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
    }

    /**
     * Buat Snap Token Midtrans untuk pesanan
     */
    public function createSnapToken(Order $order, array $cartItems = []): ?string
    {
        try {
            $itemDetails = [];

            if (!empty($cartItems)) {
                $itemsSum = 0;
                foreach ($cartItems as $id => $item) {
                    $price = (int) ($item['price'] ?? 0);
                    $qty = (int) ($item['quantity'] ?? 1);
                    $itemTotal = $price * $qty;
                    $itemsSum += $itemTotal;

                    $itemDetails[] = [
                        'id'       => (string) $id,
                        'price'    => $price,
                        'quantity' => $qty,
                        'name'     => mb_substr($item['name'] ?? 'Produk Skincare', 0, 50),
                    ];
                }

                // Jika ada selisih total amount dengan itemDetails (misal ongkir/diskon)
                if ((int)$order->total_amount > $itemsSum) {
                    $itemDetails[] = [
                        'id'       => 'SHIPPING_OR_OTHER',
                        'price'    => (int)$order->total_amount - $itemsSum,
                        'quantity' => 1,
                        'name'     => 'Biaya Pengiriman / Lainnya',
                    ];
                }
            } else {
                $productName = $order->product ? $order->product->name : 'Produk Gitania Skincare';
                $itemDetails[] = [
                    'id'       => (string) ($order->product_id ?? 'GS-01'),
                    'price'    => (int) ($order->total_amount / max(1, $order->quantity)),
                    'quantity' => (int) $order->quantity,
                    'name'     => mb_substr($productName, 0, 50),
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id'     => $order->invoice_number,
                    'gross_amount' => (int) $order->total_amount,
                ],
                'customer_details' => [
                    'first_name' => $order->customer_name,
                    'email'      => $order->customer_email ?? '',
                    'phone'      => $order->customer_phone,
                    'shipping_address' => [
                        'first_name' => $order->customer_name,
                        'phone'      => $order->customer_phone,
                        'address'    => $order->shipping_address,
                    ],
                ],
                'item_details' => $itemDetails,
            ];

            $snapToken = Snap::getSnapToken($params);

            return $snapToken;

        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage(), [
                'order_id' => $order->invoice_number,
                'trace'    => $e->getTraceAsString(),
            ]);
            return null;
        }
    }
}
