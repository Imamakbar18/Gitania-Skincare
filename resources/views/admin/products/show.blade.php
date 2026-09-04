@extends('layouts.admin')

@section('title', 'Detail Produk: ' . $product->name . ' - Admin Panel')

@section('content')
<div style="margin-bottom: 24px;">
    <div style="margin-bottom: 8px;">
        <a href="{{ route('admin.products.index') }}" style="color: var(--admin-purple); text-decoration: none; font-size: 13px; font-weight: 600;">&larr; Kembali ke Daftar Produk</a>
    </div>
    <h2 style="color: #1e293b; font-size: 20px; font-weight: 700; margin: 0; font-family: 'Poppins', sans-serif;">Detail Produk: {{ $product->name }}</h2>
</div>

<div class="admin-card">
    <h3 style="font-size: 15px; font-weight: 700; color: var(--admin-purple); margin-bottom: 16px; font-family: 'Poppins', sans-serif;">Informasi Produk</h3>
    
    <div class="admin-grid-2" style="margin-bottom: 20px;">
        <div>
            <p style="margin: 0 0 8px 0; font-size: 13px;"><strong style="color: #334155;">SKU:</strong> {{ $product->sku }}</p>
            <p style="margin: 0 0 8px 0; font-size: 13px;"><strong style="color: #334155;">Kategori:</strong> {{ $product->category->name ?? '-' }}</p>
            <p style="margin: 0 0 8px 0; font-size: 13px;"><strong style="color: #334155;">Harga:</strong> IDR {{ number_format($product->price, 0, ',', '.') }}</p>
        </div>
        <div>
            <p style="margin: 0 0 8px 0; font-size: 13px;"><strong style="color: #334155;">Berat:</strong> {{ $product->weight }} gram</p>
            <p style="margin: 0 0 8px 0; font-size: 13px;"><strong style="color: #334155;">Status:</strong> <span style="text-transform: capitalize;">{{ $product->status }}</span></p>
            <p style="margin: 0 0 8px 0; font-size: 13px;"><strong style="color: #334155;">Stok:</strong> {{ $product->stock }}</p>
        </div>
    </div>

    @if($product->description)
        <div style="background: #f8fafc; padding: 14px; border-radius: 10px; border: 1px solid #f1f5f9; margin-bottom: 20px;">
            <strong style="color: #334155; font-size: 12px; text-transform: uppercase; display: block; margin-bottom: 4px;">Deskripsi:</strong>
            <p style="margin: 0; font-size: 13px; color: #475569; line-height: 1.5;">{{ $product->description }}</p>
        </div>
    @endif

    <hr style="border: none; border-top: 1px solid #f1f5f9; margin: 24px 0;">

    <h3 style="font-size: 15px; font-weight: 700; color: var(--admin-purple); margin-bottom: 14px; font-family: 'Poppins', sans-serif;">Manajemen Varian & Stok</h3>
    <div class="admin-table-container">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; min-width: 500px;">
            <thead>
                <tr style="background: #f8fafc; color: #475569; text-align: left; border-bottom: 1px solid #f1f5f9;">
                    <th style="padding: 10px 14px; font-weight: 600;">Nama Varian</th>
                    <th style="padding: 10px 14px; font-weight: 600;">SKU Varian</th>
                    <th style="padding: 10px 14px; font-weight: 600;">Harga</th>
                    <th style="padding: 10px 14px; font-weight: 600;">Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse($product->variants as $variant)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 10px 14px; font-weight: 600; color: #1e293b;">{{ $variant->variant_name }}</td>
                    <td style="padding: 10px 14px; color: #475569;">{{ $variant->sku }}</td>
                    <td style="padding: 10px 14px; font-weight: 600; color: var(--admin-purple);">IDR {{ number_format($variant->price, 0, ',', '.') }}</td>
                    <td style="padding: 10px 14px;">{{ $variant->stock ?? 0 }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 25px; color: #94a3b8;">Belum ada varian untuk produk ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Galeri Foto Produk -->
<div class="admin-card">
    <h4 style="font-size: 15px; color: var(--admin-purple); margin-bottom: 15px; font-weight: 700; font-family: 'Poppins', sans-serif;">Galeri Foto Produk</h4>
    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
        @forelse($product->images as $img)
            <div style="position: relative; border: 1px solid #cbd5e1; border-radius: 10px; padding: 6px; background: #f8fafc;">
                <img src="{{ asset('storage/' . $img->image_path) }}" alt="Foto Produk" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                @if($img->is_primary)
                    <span style="position: absolute; bottom: 10px; left: 10px; background: var(--admin-purple); color: white; font-size: 10px; padding: 2px 6px; border-radius: 4px; font-weight: 700;">Utama</span>
                @endif
            </div>
        @empty
            <p style="color: #64748b; font-size: 13px; margin: 0;">Belum ada foto galeri yang di-upload untuk produk ini.</p>
        @endforelse
    </div>
</div>
@endsection
