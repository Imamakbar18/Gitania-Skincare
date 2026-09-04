@extends('layouts.app')

@section('title', 'Checkout - Gitania Skincare')

@section('content')
<div style="max-width: 800px; margin: 40px auto; padding: 0 20px;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h2 style="color: var(--purple-deep); font-weight: 700;">🛍️ Checkout Pesanan Gitania Skincare</h2>
        <a href="{{ route('cart.index') }}" style="background: #e2e8f0; color: #334155; padding: 8px 15px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 500;">
            &larr; Kembali ke Keranjang
        </a>
    </div>

    @if(session('error'))
        <div style="background: #FCE8E6; color: #C5221F; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; font-weight: 500;">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    @php $cart = session()->get('cart', []); @endphp

    @if(count($cart) > 0)
    <div style="background: var(--white); padding: 35px; border-radius: 16px; border: 1px solid var(--lilac-soft); box-shadow: 0 4px 20px rgba(74, 46, 122, 0.04);">
        <form action="{{ url('/api/orders') }}" method="POST">
            @csrf

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">Nama Lengkap Penerima</label>
                <input type="text" name="customer_name" required placeholder="Contoh: Sinta Bella" style="width: 100%; padding: 12px; border: 1px solid #e2dcf5; border-radius: 8px; font-size: 14px; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">Nomor WhatsApp</label>
                <input type="text" name="customer_phone" required placeholder="Contoh: 081234567890" style="width: 100%; padding: 12px; border: 1px solid #e2dcf5; border-radius: 8px; font-size: 14px; outline: none;">
            </div>

            <!-- Pilih Varian otomatis dari item di keranjang atau list produk -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">Pilih Produk dari Keranjang</label>
                <select name="variant_id" required style="width: 100%; padding: 12px; border: 1px solid #e2dcf5; border-radius: 8px; font-size: 14px; background: white; outline: none;">
                    @foreach($cart as $item)
                        <option value="{{ $item['variant_id'] }}">
                            {{ $item['product_name'] }} — {{ $item['variant_name'] }} (Qty: {{ $item['quantity'] }}) - Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">Jumlah Total (Qty)</label>
                <input type="number" name="quantity" value="1" min="1" required style="width: 100%; padding: 12px; border: 1px solid #e2dcf5; border-radius: 8px; font-size: 14px; outline: none;">
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">Alamat Pengiriman Lengkap</label>
                <textarea name="shipping_address" rows="3" required placeholder="Masukkan alamat lengkap tujuan pengiriman..." style="width: 100%; padding: 12px; border: 1px solid #e2dcf5; border-radius: 8px; font-size: 14px; outline: none;"></textarea>
            </div>

            <button type="submit" style="width: 100%; background: var(--purple-deep); color: white; border: none; padding: 14px; border-radius: 8px; font-weight: 600; font-size: 15px; cursor: pointer;">
                Buat Pesanan & Selesaikan Transaksi
            </button>
        </form>
    </div>
    @else
        <div style="text-align: center; padding: 40px; background: white; border-radius: 12px; border: 1px solid var(--lilac-soft);">
            <p style="color: #665c75; margin-bottom: 15px;">Keranjang Anda kosong, tidak dapat melakukan checkout.</p>
            <a href="{{ url('/') }}" style="background: var(--purple-deep); color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px;">Mulai Belanja</a>
        </div>
    @endif

</div>
@endsection
