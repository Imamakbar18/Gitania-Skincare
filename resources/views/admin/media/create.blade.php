@extends('layouts.admin')

@section('title', 'Tambah Media Instagram - Admin Panel')

@section('content')
<div style="margin-bottom: 24px;">
    <h2 style="color: #1e293b; font-size: 20px; font-weight: 700; margin: 0 0 4px 0; font-family: 'Poppins', sans-serif;">➕ Tambah Postingan Instagram</h2>
    <p style="color: #64748b; font-size: 13px; margin: 0;">Upload foto dan masukkan link postingan Instagram.</p>
</div>

<form action="{{ route('admin.media.save') }}" method="POST" enctype="multipart/form-data" class="admin-card" style="max-width: 700px;">
    @csrf

    <div style="margin-bottom: 20px;">
        <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; text-transform: uppercase;">Judul / Keterangan Singkat</label>
        <input type="text" name="title" required placeholder="Cth: Produk Unik Gitania Skincare..." style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit;">
    </div>

    <div style="margin-bottom: 20px;">
        <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; text-transform: uppercase;">Link URL Instagram</label>
        <input type="url" name="instagram_link" required placeholder="https://www.instagram.com/p/..." style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit;">
    </div>

    <div style="margin-bottom: 25px;">
        <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; text-transform: uppercase;">Foto Thumbnail</label>
        <input type="file" name="thumbnail" accept="image/*" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12px; background: white;">
    </div>

    <div style="display: flex; justify-content: flex-end; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('admin.media.dashboard') }}" style="background: #e2e8f0; color: #334155; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 600; text-decoration: none;">Batal</a>
        <button type="submit" style="background: var(--admin-purple); color: white; border: none; padding: 10px 24px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer;">Simpan Postingan</button>
    </div>
</form>
@endsection
