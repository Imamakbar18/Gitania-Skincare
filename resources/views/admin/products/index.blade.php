@extends('layouts.admin')

@section('title', 'Kelola Produk - Gitania Skincare')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
    <div>
        <h2 style="color: #1e293b; font-size: 20px; font-weight: 700; margin: 0 0 4px 0; font-family: 'Poppins', sans-serif;">📦 Kelola Daftar Produk Skincare</h2>
        <p style="color: #64748b; font-size: 13px; margin: 0;">Tambah, ubah, atau cari katalog produk yang tampil di toko.</p>
    </div>

    <!-- Tombol Tambah Produk -->
    <a href="{{ route('admin.products.create') }}" style="background: var(--admin-purple); color: white; padding: 11px 18px; border-radius: 12px; font-weight: 600; text-decoration: none; font-size: 13px; box-shadow: 0 4px 12px rgba(90, 46, 136, 0.15); display: inline-flex; align-items: center; gap: 8px; white-space: nowrap;">
        + Tambah Produk Baru
    </a>
</div>

<!-- Kotak Konten Tabel Produk & Filter Search -->
<div class="admin-card">

    <!-- Form Pencarian (Search Bar Responsif) -->
    <form action="{{ route('admin.products.index') }}" method="GET" class="admin-search-bar">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk atau SKU..." style="padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 13px; outline: none; font-family: inherit;">
        <button type="submit" style="background: var(--admin-purple); color: white; border: none; padding: 10px 18px; border-radius: 10px; font-weight: 600; font-size: 13px; cursor: pointer; white-space: nowrap;">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.products.index') }}" style="background: #f1f5f9; color: #475569; padding: 10px 14px; border-radius: 10px; font-size: 13px; text-decoration: none; display: flex; align-items: center; white-space: nowrap;">Reset</a>
        @endif
    </form>

    <div class="admin-table-container">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; min-width: 650px;">
            <thead>
                <tr style="background: #f8fafc; color: #475569; text-align: left; border-bottom: 1px solid #f1f5f9;">
                    <th style="padding: 12px 14px; font-weight: 600; width: 50px;">No</th>
                    <th style="padding: 12px 14px; font-weight: 600;">Nama Produk</th>
                    <th style="padding: 12px 14px; font-weight: 600;">Kategori</th>
                    <th style="padding: 12px 14px; font-weight: 600;">Stok</th>
                    <th style="padding: 12px 14px; font-weight: 600;">Harga</th>
                    <th style="padding: 12px 14px; font-weight: 600; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products ?? [] as $index => $product)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px 14px; color: #64748b;">{{ $products->firstItem() + $index }}</td>
                    <td style="padding: 12px 14px; font-weight: 600; color: #1e293b;">{{ $product->name }}</td>
                    <td style="padding: 12px 14px; color: #475569;">{{ $product->category->name ?? 'Tanpa Kategori' }}</td>

                    <!-- Indikator Status & Jumlah Stok -->
                    <td style="padding: 12px 14px;">
                        @if($product->stock > 5)
                            <span style="background: #e6f4ea; color: #137333; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;">{{ $product->stock }} pcs</span>
                        @elseif($product->stock > 0)
                            <span style="background: #fef7e0; color: #b06000; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;">Menipis ({{ $product->stock }})</span>
                        @else
                            <span style="background: #fce8e6; color: #c5221f; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;">Habis</span>
                        @endif
                    </td>

                    <td style="padding: 12px 14px; font-weight: 700; color: var(--admin-purple);">IDR {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td style="padding: 12px 14px; text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 6px; flex-wrap: wrap;">
                            <a href="{{ route('admin.products.edit', $product->id) }}" style="background: #f3e8ff; color: var(--admin-purple); padding: 5px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none;">Edit</a>

                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #fee2e2; color: #ef4444; border: none; padding: 5px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">
                        <div style="font-size: 32px; margin-bottom: 10px;">🔍</div>
                        Tidak ada produk yang ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginasi -->
    <div style="margin-top: 20px; overflow-x: auto;">
        {{ $products->links() }}
    </div>
</div>
@endsection
