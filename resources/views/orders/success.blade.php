@extends('layouts.app')

@section('title', 'Pesanan Berhasil #' . $order->invoice_number . ' — Gitania Skincare')

@section('content')
<style>
    .success-container {
        max-width: 680px;
        margin: 50px auto 90px auto;
        padding: 0 20px;
    }
    .success-card {
        background: white;
        border-radius: 24px;
        border: 1.5px solid #DDD6FE;
        box-shadow: 0 16px 45px rgba(107, 33, 168, 0.08);
        overflow: hidden;
        text-align: center;
        padding: 40px 32px;
    }
    .success-icon-wrap {
        width: 80px;
        height: 80px;
        background: #F0FDF4;
        border: 2px solid #BBF7D0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 38px;
        margin: 0 auto 20px auto;
        box-shadow: 0 8px 20px rgba(22, 163, 74, 0.15);
    }
    .success-title {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 700;
        color: #1e1b4b;
        margin: 0 0 8px 0;
    }
    .success-desc {
        font-size: 14px;
        color: #64748b;
        margin: 0 0 24px 0;
        line-height: 1.6;
    }
    .order-summary-box {
        background: #FAF8FF;
        border: 1.5px solid #DDD6FE;
        border-radius: 16px;
        padding: 20px 24px;
        text-align: left;
        margin-bottom: 28px;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 13.5px;
        padding: 8px 0;
        border-bottom: 1px solid #EDE9FE;
        color: #475569;
    }
    .summary-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .summary-row-bold {
        font-weight: 700;
        color: #1e1b4b;
    }
    .action-buttons {
        display: flex;
        gap: 14px;
        justify-content: center;
        flex-wrap: wrap;
    }
    .btn-action-primary {
        padding: 13px 26px;
        background: linear-gradient(135deg, #8B5CF6, #7C3AED);
        color: white;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(124, 58, 237, 0.25);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-action-outline {
        padding: 13px 24px;
        background: #F5F3FF;
        color: #7C3AED;
        border: 1.5px solid #DDD6FE;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
</style>

<div class="success-container">
    <div class="success-card">
        
        <!-- Icon -->
        <div class="success-icon-wrap">
            ✨
        </div>

        <!-- Judul -->
        <h1 class="success-title">Terima Kasih atas Pesanan Anda!</h1>
        <p class="success-desc">
            Pesanan Anda telah berhasil dibuat. Notifikasi konfirmasi dan rincian transaksi telah dikirim ke WhatsApp Anda.
        </p>

        <!-- Ringkasan Pesanan -->
        <div class="order-summary-box">
            <div class="summary-row">
                <span>No. Invoice</span>
                <span class="summary-row-bold" style="color: #7C3AED; font-family: monospace;">{{ $order->invoice_number }}</span>
            </div>
            <div class="summary-row">
                <span>Status Pembayaran</span>
                <span>
                    @if(in_array($order->status, ['paid', 'completed', 'dikirim']))
                        <strong style="color: #16A34A;">● Lunas / Terverifikasi</strong>
                    @else
                        <strong style="color: #D97706;">● Menunggu Pembayaran</strong>
                    @endif
                </span>
            </div>
            <div class="summary-row">
                <span>Nama Pelanggan</span>
                <span class="summary-row-bold">{{ $order->customer_name }}</span>
            </div>
            <div class="summary-row">
                <span>No. WhatsApp</span>
                <span>{{ $order->customer_phone }}</span>
            </div>
            <div class="summary-row">
                <span>Produk</span>
                <span>{{ $order->product ? $order->product->name : 'Produk Gitania Skincare' }} ({{ $order->quantity }} pcs)</span>
            </div>
            <div class="summary-row" style="font-size: 15px; margin-top: 4px; padding-top: 10px; border-top: 2px solid #DDD6FE;">
                <span style="font-weight: 700; color: #1e1b4b;">Total Pembayaran</span>
                <span style="font-weight: 800; color: #6B21A8; font-size: 16px;">
                    Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="action-buttons">
            <a href="{{ route('home') }}" class="btn-action-outline">
                🏠 Kembali ke Home
            </a>
            <a href="{{ route('shop.index') }}" class="btn-action-primary">
                🛍️ Belanja Lagi →
            </a>
        </div>

    </div>
</div>
@endsection
