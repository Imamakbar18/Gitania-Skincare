@extends('layouts.app')

@section('title', 'Keranjang Belanja — Gitania Skincare')

@section('content')
<style>
    /* ===== CART LAYOUT ===== */
    .cart-wrapper {
        max-width: 1100px;
        margin: 40px auto 80px auto;
        padding: 0 24px;
    }
    .cart-breadcrumb {
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 28px;
    }
    .cart-breadcrumb a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }
    .cart-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 28px;
        align-items: start;
    }
    .cart-left { display: flex; flex-direction: column; gap: 22px; }
    .cart-right { display: flex; flex-direction: column; gap: 20px; }

    /* ===== BOX CARD ===== */
    .cart-box {
        background: white;
        border: 1px solid var(--primary-soft);
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 4px 18px rgba(107,33,168,0.05);
    }
    .cart-box-title {
        font-weight: 700;
        color: var(--primary);
        font-size: 15px;
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--primary-soft);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* ===== FORM INPUTS ===== */
    .form-group { margin-bottom: 16px; }
    .form-label {
        font-size: 12px;
        font-weight: 700;
        color: var(--text-dark);
        display: block;
        margin-bottom: 7px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .form-input {
        width: 100%;
        padding: 12px 15px;
        border: 1.5px solid #E5E7EB;
        border-radius: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
        color: var(--text-dark);
    }
    .form-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(107,33,168,0.08);
    }
    textarea.form-input { resize: vertical; font-family: 'Poppins', sans-serif; }
    select.form-input { cursor: pointer; background: white; }

    /* ===== PRODUK ITEM ===== */
    .cart-item {
        display: flex;
        gap: 16px;
        align-items: center;
        padding-bottom: 18px;
        margin-bottom: 18px;
        border-bottom: 1px solid #F5F3FF;
    }
    .cart-item:last-child { border-bottom: none; padding-bottom: 0; margin-bottom: 0; }
    .cart-item-img {
        width: 80px; height: 80px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid var(--primary-soft);
        flex-shrink: 0;
    }
    .cart-item-name {
        font-size: 14px; font-weight: 600;
        color: var(--text-dark); margin: 0 0 4px 0; line-height: 1.4;
    }
    .cart-item-price {
        color: var(--primary); font-size: 14px; font-weight: 700; margin-bottom: 8px;
    }
    .qty-control {
        display: inline-flex;
        align-items: center;
        border: 1.5px solid var(--primary-border);
        border-radius: 9px;
        overflow: hidden;
    }
    .qty-btn {
        padding: 5px 13px;
        background: none;
        border: none;
        cursor: pointer;
        font-weight: 700;
        color: var(--primary);
        font-size: 17px;
        transition: background 0.15s;
    }
    .qty-btn:hover { background: var(--primary-pale); }
    .qty-val {
        padding: 5px 10px;
        font-size: 13px;
        font-weight: 600;
        min-width: 22px;
        text-align: center;
        color: var(--text-dark);
    }

    /* ===== ORDER SUMMARY ===== */
    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        color: var(--text-muted);
        margin-bottom: 10px;
    }
    .summary-row span:last-child { font-weight: 600; color: var(--text-dark); }
    .summary-total {
        display: flex;
        justify-content: space-between;
        font-weight: 800;
        font-size: 18px;
        color: var(--text-dark);
        padding-top: 14px;
        margin-top: 10px;
        border-top: 2px solid var(--primary-soft);
    }
    .summary-total span:last-child { color: var(--primary); }

    /* ===== BUTTON ===== */
    .btn-checkout {
        width: 100%;
        padding: 15px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        margin-top: 16px;
    }
    .btn-checkout:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    /* ===== ALERT ===== */
    .alert-success {
        background: #ECFDF5; color: #065F46;
        padding: 14px 18px; border-radius: 12px;
        margin-bottom: 22px; font-size: 14px;
        font-weight: 500; border: 1px solid #A7F3D0;
    }
    .alert-error {
        background: #FEF2F2; color: #991B1B;
        padding: 14px 18px; border-radius: 12px;
        margin-bottom: 22px; font-size: 14px;
        font-weight: 500; border: 1px solid #FECACA;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .cart-wrapper { padding: 0 16px; margin-top: 28px; }
        .cart-grid { grid-template-columns: 1fr; }
        .cart-right { order: -1; } /* Summary muncul di atas di mobile */
    }
</style>

<div class="cart-wrapper">

    <!-- Breadcrumb -->
    <div class="cart-breadcrumb">
        <a href="{{ route('home') }}">Home</a> &rsaquo;
        <span style="font-weight: 600; color: var(--text-dark);">Keranjang Belanja</span>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">⚠️ {{ session('error') }}</div>
    @endif
    @if(session('warning'))
        <div style="background: #FFFBEB; border: 1.5px solid #FDE68A; color: #92400E; padding: 14px 20px; border-radius: 14px; margin-bottom: 22px; font-weight: 600; font-size: 13.5px; display: flex; align-items: center; gap: 10px;">
            <span>⚠️</span> {{ session('warning') }}
        </div>
    @endif

    @guest
        <div style="background: linear-gradient(135deg, #FAF5FF 0%, #F3E8FF 100%); border: 1.5px solid #DDD6FE; border-radius: 18px; padding: 18px 24px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; box-shadow: 0 4px 15px rgba(107, 33, 168, 0.05);">
            <div style="display: flex; align-items: center; gap: 14px;">
                <span style="font-size: 28px;">🔒</span>
                <div>
                    <strong style="color: #6B21A8; font-size: 15px; display: block; margin-bottom: 2px;">Anda Belum Masuk (Login)</strong>
                    <span style="font-size: 13px; color: #64748B;">Silakan masuk atau buat akun baru terlebih dahulu untuk melanjutkan pembayaran pesanan.</span>
                </div>
            </div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <a href="{{ route('login') }}" style="padding: 10px 20px; background: linear-gradient(135deg, #7C3AED, #6B21A8); color: white; border-radius: 10px; font-size: 13.5px; font-weight: 700; text-decoration: none; box-shadow: 0 4px 12px rgba(107, 33, 168, 0.25);">
                    🔑 Masuk (Login)
                </a>
                <a href="{{ route('register') }}" style="padding: 9px 18px; background: white; color: #6B21A8; border: 1.5px solid #6B21A8; border-radius: 10px; font-size: 13.5px; font-weight: 700; text-decoration: none;">
                    ✨ Daftar Akun
                </a>
            </div>
        </div>
    @endguest

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="cart-grid">

            <!-- ===== KOLOM KIRI ===== -->
            <div class="cart-left">

                <!-- Data Pengiriman -->
                <div class="cart-box">
                    <div class="cart-box-title">📍 Informasi Pengiriman</div>
                    <div class="form-group">
                        <label class="form-label">Nama Penerima *</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->name ?? '') }}" required placeholder="Masukkan nama lengkap" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor WhatsApp (Aktif) *</label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required placeholder="Contoh: 081234567890" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email *</label>
                        <input type="email" name="customer_email" value="{{ old('customer_email', auth()->user()->email ?? '') }}" required placeholder="Contoh: nama@email.com" class="form-input">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Alamat Lengkap *</label>
                        <textarea name="shipping_address" required rows="3" placeholder="Nama jalan, nomor rumah, kecamatan, kota..." class="form-input">{{ old('shipping_address') }}</textarea>
                    </div>
                </div>

                <!-- Ringkasan Produk -->
                <div class="cart-box">
                    <div class="cart-box-title">🛍️ Produk dalam Keranjang</div>

                    @php
                        $subtotal = 0;
                        $firstProductId = null;
                        $firstQuantity = 1;
                    @endphp

                    @forelse($cart as $id => $item)
                        @php
                            if (!$firstProductId) {
                                $firstProductId = $id;
                                $firstQuantity = $item['quantity'];
                            }
                            $itemTotal = $item['price'] * $item['quantity'];
                            $subtotal += $itemTotal;
                        @endphp
                        <div class="cart-item">
                            <img src="{{ $item['image'] }}" class="cart-item-img" alt="{{ $item['name'] }}">
                            <div style="flex: 1; min-width: 0;">
                                <h4 class="cart-item-name">{{ $item['name'] }}</h4>
                                <div class="cart-item-price">Rp{{ number_format($item['price'], 0, ',', '.') }}</div>
                                <div class="qty-control">
                                    <button type="button" onclick="updateCartPageQty('{{ $id }}', -1)" class="qty-btn">−</button>
                                    <span class="qty-val">{{ $item['quantity'] }}</span>
                                    <button type="button" onclick="updateCartPageQty('{{ $id }}', 1)" class="qty-btn">+</button>
                                </div>
                            </div>
                            <div style="text-align: right; flex-shrink: 0;">
                                <div style="font-size: 13px; font-weight: 700; color: var(--text-dark); margin-bottom: 10px;">
                                    Rp{{ number_format($itemTotal, 0, ',', '.') }}
                                </div>
                                <button type="button" onclick="removeCartPageItem('{{ $id }}')"
                                    style="background: #FEF2F2; border: none; color: #DC2626; padding: 6px 10px; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 600;">
                                    🗑️ Hapus
                                </button>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 50px 0;">
                            <div style="font-size: 48px; margin-bottom: 12px;">🛒</div>
                            <p style="color: var(--text-muted); font-size: 15px; margin: 0 0 16px 0;">Keranjang belanja masih kosong.</p>
                            <a href="{{ route('shop.index') }}" class="btn-primary" style="display: inline-flex; padding: 10px 24px; border-radius: 10px; font-size: 13px;">Mulai Belanja →</a>
                        </div>
                    @endforelse
                </div>

            </div>

            <!-- ===== KOLOM KANAN ===== -->
            <div class="cart-right">

                @if($firstProductId)
                    <input type="hidden" name="product_id" value="{{ $firstProductId }}">
                    <input type="hidden" name="quantity" value="{{ $firstQuantity }}">
                @endif

                <!-- Pilih Pengiriman -->
                <div class="cart-box">
                    <div class="cart-box-title">📦 Metode Pengiriman</div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <select name="courier" class="form-input">
                            <option value="jne">🚚 JNE Regular</option>
                            <option value="jnt">🚚 J&T Express</option>
                            <option value="sicepat">🚚 SiCepat HALU</option>
                            <option value="gosend">🛵 GoSend Same Day</option>
                        </select>
                    </div>
                </div>

                <!-- Rincian Pembayaran -->
                <div class="cart-box">
                    <div class="cart-box-title">💳 Ringkasan Pembayaran</div>

                    <div class="summary-row">
                        <span>Subtotal ({{ count($cart) }} produk)</span>
                        <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Diskon</span>
                        <span style="color: #16A34A;">-Rp0</span>
                    </div>
                    <div class="summary-row">
                        <span>Biaya Pengiriman</span>
                        <span>Rp0</span>
                    </div>

                    <div class="summary-total">
                        <span>Total</span>
                        <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    @if(count($cart) > 0)
                        @guest
                            <a href="{{ route('login') }}" class="btn-checkout" style="background: linear-gradient(135deg, #7C3AED, #6B21A8); display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; color: white;">
                                <span>🔒</span> Masuk / Buat Akun untuk Membayar
                            </a>
                            <p style="font-size: 11.5px; color: var(--text-muted); text-align: center; margin-top: 10px; margin-bottom: 0;">
                                Masuk ke akun Anda agar pesanan tersimpan dan terverifikasi secara aman.
                            </p>
                        @else
                            <button type="submit" class="btn-checkout" style="background: linear-gradient(135deg, #7C3AED, #6B21A8); display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <span>💳</span> Lanjut ke Pembayaran Midtrans
                            </button>
                            <p style="font-size: 11.5px; color: var(--text-muted); text-align: center; margin-top: 10px; margin-bottom: 0;">
                                🔒 Bayar mudah & instan via QRIS, GoPay, Transfer Bank, ShopeePay & Kartu Kredit.
                            </p>
                        @endguest
                    @endif
                </div>

            </div>

        </div>
    </form>
</div>

<script>
    function updateCartPageQty(productId, change) {
        const fd = new FormData();
        fd.append('product_id', productId);
        fd.append('change', change);
        fd.append('_token', '{{ csrf_token() }}');
        fetch("{{ route('cart.update') }}", { method: 'POST', body: fd })
            .then(r => r.json())
            .then(data => { if (data.success) location.reload(); });
    }

    function removeCartPageItem(productId) {
        const fd = new FormData();
        fd.append('product_id', productId);
        fd.append('_token', '{{ csrf_token() }}');
        fetch("{{ route('cart.ajax.remove') }}", { method: 'POST', body: fd })
            .then(r => r.json())
            .then(data => { if (data.success) location.reload(); });
    }
</script>
@endsection
