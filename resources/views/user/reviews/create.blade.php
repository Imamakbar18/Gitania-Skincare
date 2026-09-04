@extends('layouts.app') {{-- Sesuaikan dengan layout user/frontend Anda --}}

@section('content')
<div style="max-width: 600px; margin: 40px auto; background: white; padding: 30px; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
    <h2 style="color: #1e293b; font-size: 20px; font-weight: 700; margin-bottom: 10px;">⭐ Berikan Ulasan Produk</h2>
    <p style="color: #64748b; font-size: 14px; margin-bottom: 25px;">Bagikan pengalaman Anda menggunakan produk pesanan <strong>{{ $order->invoice_number }}</strong>.</p>

    <form action="{{ route('user.reviews.store', $order->id) }}" method="POST">
        @csrf

        <!-- Pilihan Rating Bintang -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #334155; margin-bottom: 8px;">Rating (1 - 5 Bintang)</label>
            <select name="rating" required style="width: 100%; padding: 10px 15px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; outline: none; background: #fff;">
                <option value="5">⭐⭐⭐⭐⭐ (5 - Sangat Puas)</option>
                <option value="4">⭐⭐⭐⭐ (4 - Puas)</option>
                <option value="3">⭐⭐⭐ (3 - Cukup)</option>
                <option value="2">⭐⭐ (2 - Kurang)</option>
                <option value="1">⭐ (1 - Sangat Kurang)</option>
            </select>
        </div>

        <!-- Kolom Komentar / Ulasan -->
        <div style="margin-bottom: 25px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #334155; margin-bottom: 8px;">Ulasan / Komentar</label>
            <textarea name="comment" rows="4" placeholder="Ceritakan bagaimana hasil produk skincare ini di kulit Anda..." style="width: 100%; padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; outline: none; resize: vertical;"></textarea>
        </div>

        <!-- Tombol Aksi -->
        <div style="display: flex; gap: 10px;">
            <button type="submit" style="background: #5a2e88; color: white; border: none; padding: 12px 20px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; flex: 1;">Kirim Ulasan</button>
            <a href="{{ route('profile.index', ['tab' => 'orders']) }}" style="background: #f1f5f9; color: #475569; padding: 12px 20px; border-radius: 10px; font-weight: 600; font-size: 14px; text-decoration: none; text-align: center;">Batal</a>
        </div>
    </form>
</div>
@endsection
