@extends('layouts.admin')

@section('title', 'Edit Produk - Gitania Skincare')

@section('content')
<div style="margin-bottom: 24px;">
    <h2 style="color: #1e293b; font-size: 20px; font-weight: 700; margin: 0 0 4px 0; font-family: 'Poppins', sans-serif;">✏️ Edit Produk</h2>
    <p style="color: #64748b; font-size: 13px; margin: 0;">Perbarui informasi produk dan detail tab informasi di bawah ini.</p>
</div>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="admin-card">
    @csrf
    @method('PUT')

    @if ($errors->any())
        <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #dc2626; padding: 14px; border-radius: 10px; margin-bottom: 20px; font-size: 13px;">
            <strong style="display: block; margin-bottom: 5px;">Terjadi Kesalahan Validasi:</strong>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h3 style="font-size: 15px; color: var(--admin-purple); margin-bottom: 16px; font-weight: 700; font-family: 'Poppins', sans-serif;">Informasi Utama Produk</h3>

    <div class="admin-grid-2" style="margin-bottom: 20px;">
        <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; text-transform: uppercase;">Nama Produk</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit;">
        </div>
        <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; text-transform: uppercase;">Kategori</label>
            <select name="category_id" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; background: white; font-family: inherit;">
                <option value="">Pilih Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ (old('category_id', $product->category_id) == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Grid SKU, Harga, Berat, dan Stok Responsif -->
    <div class="admin-grid-4" style="margin-bottom: 20px;">
        <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; text-transform: uppercase;">SKU Utama</label>
            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit;">
        </div>
        <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; text-transform: uppercase;">Harga Dasar (IDR)</label>
            <input type="number" name="price" value="{{ old('price', $product->price) }}" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit;">
        </div>
        <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; text-transform: uppercase;">Berat (gram)</label>
            <input type="number" name="weight" value="{{ old('weight', $product->weight) }}" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit;">
        </div>
        <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; text-transform: uppercase;">Stok</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit;">
        </div>
    </div>

    <div class="admin-grid-2" style="margin-bottom: 20px;">
        <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; text-transform: uppercase;">Status</label>
            <select name="status" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; background: white; font-family: inherit;">
                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
            </select>
        </div>
    </div>

    <!-- Bagian Foto Responsif -->
    <div class="admin-grid-2" style="margin-bottom: 20px; background: #f8fafc; padding: 18px; border-radius: 12px; border: 1px solid #e2e8f0;">
        <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px;">Ganti Foto Utama (Opsional)</label>
            <input type="file" name="image" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12px; background: white;">
            @if($product->image)
                <div style="margin-top: 8px;">
                    <img src="{{ asset('storage/' . $product->image) }}" width="60" style="border-radius: 6px; border: 1px solid #e2e8f0;">
                </div>
            @endif
        </div>
    </div>

    <div style="margin-bottom: 20px;">
        <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; text-transform: uppercase;">Deskripsi Produk</label>
        <textarea name="description" rows="4" style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit;">{{ old('description', $product->description) }}</textarea>
    </div>

    <!-- INFORMASI DETAIL & TAB PRODUK -->
    <div style="background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 25px;">
        <h3 style="font-size: 14px; color: var(--admin-purple); margin-top: 0; margin-bottom: 14px; font-weight: 700; font-family: 'Poppins', sans-serif;">Informasi Detail & Tab Produk</h3>

        <div class="admin-grid-2" style="margin-bottom: 16px;">
            <div>
                <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px;">Recommended For</label>
                <input type="text" name="recommended_for" value="{{ old('recommended_for', $product->recommended_for) }}" placeholder="Cth: Semua jenis kulit berjerawat" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; background: white; font-family: inherit;">
            </div>
            <div>
                <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px;">Benefits (Manfaat)</label>
                <input type="text" name="benefits" value="{{ old('benefits', $product->benefits) }}" placeholder="Cth: Meredakan kemerahan & membersihkan pori" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; background: white; font-family: inherit;">
            </div>
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px;">Skin Concerns</label>
            <input type="text" name="skin_concerns" value="{{ old('skin_concerns', $product->skin_concerns) }}" placeholder="Cth: Sensitive Skin, Wrinkle-free" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; background: white; font-family: inherit;">
        </div>

        <div class="admin-grid-2">
            <div>
                <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px;">How to Use (Cara Pakai)</label>
                <textarea name="how_to_use" rows="3" placeholder="Tuliskan langkah-langkah penggunaan..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; background: white; font-family: inherit;">{{ old('how_to_use', $product->how_to_use) }}</textarea>
            </div>
            <div>
                <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px;">Ingredients (Kandungan)</label>
                <textarea name="ingredients" rows="3" placeholder="Tuliskan bahan-bahan produk..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; background: white; font-family: inherit;">{{ old('ingredients', $product->ingredients) }}</textarea>
            </div>
        </div>
    </div>

    <div style="display: flex; justify-content: flex-end; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('admin.products.index') }}" style="background: #e2e8f0; color: #334155; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 600; text-decoration: none;">Batal</a>
        <button type="submit" style="background: var(--admin-purple); color: white; border: none; padding: 10px 24px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer;">Perbarui Produk</button>
    </div>
</form>
@endsection
