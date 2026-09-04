@extends('layouts.app')

@section('title', 'Pembayaran Pesanan #' . $order->invoice_number . ' — Gitania Skincare')

@section('content')
<style>
    .payment-container {
        max-width: 780px;
        margin: 40px auto 80px auto;
        padding: 0 20px;
    }
    .payment-card {
        background: white;
        border-radius: 20px;
        border: 1.5px solid #DDD6FE;
        box-shadow: 0 12px 35px rgba(107, 33, 168, 0.08);
        overflow: hidden;
    }
    .payment-header {
        background: linear-gradient(135deg, #6B21A8 0%, #7C3AED 60%, #8B5CF6 100%);
        color: white;
        padding: 30px;
        text-align: center;
        position: relative;
    }
    .payment-title {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        font-weight: 700;
        margin: 0 0 6px 0;
    }
    .payment-subtitle {
        font-size: 13px;
        color: #E9D5FF;
        margin: 0;
    }
    .payment-body {
        padding: 32px;
    }
    .invoice-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        padding: 4px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-top: 10px;
    }
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1.5px dashed #EDE9FE;
    }
    .info-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: #1e1b4b;
    }
    .total-box {
        background: #FAF8FF;
        border: 1.5px solid #DDD6FE;
        border-radius: 14px;
        padding: 18px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 26px;
    }
    .total-amount {
        font-size: 24px;
        font-weight: 800;
        color: #6B21A8;
    }
    .btn-pay-midtrans {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #7C3AED, #6B21A8);
        color: white;
        border: none;
        border-radius: 14px;
        font-size: 16px;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 8px 25px rgba(107, 33, 168, 0.3);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-pay-midtrans:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(107, 33, 168, 0.4);
    }
    .payment-methods-icons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        margin-top: 18px;
        flex-wrap: wrap;
    }
    .payment-method-pill {
        background: #F5F3FF;
        border: 1px solid #DDD6FE;
        color: #6B21A8;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
    }
    @media (max-width: 600px) {
        .info-grid { grid-template-columns: 1fr; }
        .payment-body { padding: 22px; }
    }
</style>

<div class="payment-container">
    <div class="payment-card">
        
        <!-- Header -->
        <div class="payment-header">
            <h1 class="payment-title">Selesaikan Pembayaran</h1>
            <p class="payment-subtitle">Pesanan Anda telah dicatat dalam sistem Gitania Skincare.</p>
            <div class="invoice-badge">No. Invoice: {{ $order->invoice_number }}</div>
        </div>

        <!-- Body -->
        <div class="payment-body">
            
            <!-- Detail Penerima & Pengiriman -->
            <div class="info-grid">
                <div>
                    <div class="info-label">Nama Penerima</div>
                    <div class="info-value">{{ $order->customer_name }}</div>
                </div>
                <div>
                    <div class="info-label">Nomor WhatsApp</div>
                    <div class="info-value">{{ $order->customer_phone }}</div>
                </div>
                <div style="grid-column: 1 / -1;">
                    <div class="info-label">Alamat Pengiriman</div>
                    <div class="info-value" style="font-weight: 500; line-height: 1.5;">{{ $order->shipping_address }}</div>
                </div>
            </div>

            <!-- Detail Produk -->
            <div style="margin-bottom: 22px;">
                <div class="info-label" style="margin-bottom: 10px;">Produk Dipesan</div>
                <div style="display: flex; justify-content: space-between; align-items: center; background: #FAF8FF; padding: 12px 16px; border-radius: 10px; border: 1px solid #EDE9FE;">
                    <div style="font-weight: 600; color: #1e1b4b; font-size: 14px;">
                        {{ $order->product ? $order->product->name : 'Produk Gitania Skincare' }}
                    </div>
                    <div style="font-size: 13px; color: #64748b;">
                        {{ $order->quantity }} pcs
                    </div>
                </div>
            </div>

            <!-- Total Pembayaran -->
            <div class="total-box">
                <div>
                    <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Tagihan</div>
                    <div style="font-size: 11px; color: #16A34A; font-weight: 600;">Status: Menunggu Pembayaran</div>
                </div>
                <div class="total-amount">
                    Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                </div>
            </div>

            <!-- Tombol Bayar Midtrans -->
            @if($order->snap_token)
                <button type="button" id="pay-button" class="btn-pay-midtrans" onclick="openMidtransSnap()">
                    <span>💳</span> Bayar Sekarang via Midtrans
                </button>
            @else
                <div style="background: #FEF2F2; color: #DC2626; padding: 14px; border-radius: 10px; text-align: center; font-size: 13px;">
                    ⚠️ Token pembayaran belum tersedia. Silakan muat ulang halaman.
                </div>
            @endif

            <!-- Metode Pembayaran yang Didukung -->
            <div style="text-align: center; margin-top: 20px;">
                <div style="font-size: 11.5px; color: #64748b; margin-bottom: 8px;">Metode Pembayaran Tersedia:</div>
                <div class="payment-methods-icons">
                    <span class="payment-method-pill">⚡ QRIS</span>
                    <span class="payment-method-pill">🟢 GoPay</span>
                    <span class="payment-method-pill">🟠 ShopeePay</span>
                    <span class="payment-method-pill">🏦 Transfer BCA</span>
                    <span class="payment-method-pill">🏦 Transfer Mandiri</span>
                    <span class="payment-method-pill">🏦 Transfer BNI/BRI</span>
                    <span class="payment-method-pill">💳 Kartu Kredit</span>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- Load Midtrans Snap JS -->
<script src="{{ $snapJsUrl }}" data-client-key="{{ $clientKey }}"></script>

<script>
    const snapToken = "{{ $order->snap_token }}";
    const invoiceNumber = "{{ $order->invoice_number }}";
    const successUrl = "{{ route('orders.success', $order->invoice_number) }}";

    function openMidtransSnap() {
        if (!snapToken) {
            alert('Token pembayaran tidak ditemukan. Silakan refresh halaman.');
            return;
        }

        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                console.log('Payment Success:', result);
                window.location.href = successUrl;
            },
            onPending: function(result) {
                console.log('Payment Pending:', result);
                alert('Silakan selesaikan pembayaran sesuai petunjuk yang tertera.');
                startStatusPolling();
            },
            onError: function(result) {
                console.error('Payment Error:', result);
                alert('Pembayaran gagal atau dibatalkan. Anda dapat mengklik tombol "Bayar Sekarang" untuk mencoba lagi.');
            },
            onClose: function() {
                console.log('Customer closed the payment popup without finishing.');
            }
        });
    }

    // Auto-open Midtrans Snap popup saat pertama kali halaman terbuka
    document.addEventListener('DOMContentLoaded', function() {
        // Beri jeda 400ms agar halaman ter-render sempurna
        setTimeout(function() {
            openMidtransSnap();
        }, 400);

        // Jalankan polling otomatis untuk mengecek apakah pembayaran sudah lunas via webhook
        startStatusPolling();
    });

    let pollingInterval = null;
    function startStatusPolling() {
        if (pollingInterval) return;

        pollingInterval = setInterval(function() {
            fetch("{{ route('orders.status', $order->invoice_number) }}")
                .then(r => r.json())
                .then(data => {
                    if (data.is_paid) {
                        clearInterval(pollingInterval);
                        window.location.href = successUrl;
                    }
                })
                .catch(err => console.error('Status check error:', err));
        }, 4000);
    }
</script>
@endsection
