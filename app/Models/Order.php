<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_number',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_address',
        'product_id',
        'quantity',
        'total_amount',
        'status',
        'tracking_number',
        'marketplace_source',
        'snap_token',
        'payment_type',
        'payment_status',
        'midtrans_transaction_id',
    ];

    /**
     * Relasi ke akun User / Pelanggan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke produk utama (jika single product)
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
