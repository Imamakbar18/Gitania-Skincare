@extends('layouts.admin')

@section('title', 'Edit Artikel - Admin Panel')

@section('content')
<!-- Header Halaman -->
<div style="margin-bottom: 24px;">
    <h2 style="color: #1e293b; font-size: 20px; font-weight: 700; margin: 0 0 4px 0; font-family: 'Poppins', sans-serif;">✏️ Edit Artikel</h2>
    <p style="color: #64748b; font-size: 13px; margin: 0;">Perbarui informasi, kategori, foto, atau isi konten artikel.</p>
</div>

<!-- Alert Error Validasi -->
@if($errors->any())
    <div style="background: #FEF2F2; border: 1.5px solid #FECACA; color: #DC2626; padding: 14px 18px; border-radius: 12px; font-size: 13px; margin-bottom: 24px; max-width: 800px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.media-posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="admin-card" style="max-width: 800px; border: 1.5px solid #DDD6FE;">
    @csrf
    @method('PUT')

    <!-- 1. Judul Artikel -->
    <div style="margin-bottom: 20px;">
        <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; text-transform: uppercase;">
            Judul Artikel <span style="color: #DC2626;">*</span>
        </label>
        <input type="text" name="title" value="{{ old('title', $post->title) }}" required
               placeholder="Contoh: Info Penipuan: Pengumuman Untuk Customer..."
               style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit;">
    </div>

    <!-- 2. Kategori & Tanggal Publikasi -->
    <div class="admin-grid-2" style="margin-bottom: 20px;">
        <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; text-transform: uppercase;">
                Kategori <span style="color: #DC2626;">*</span>
            </label>
            <select name="category" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; background: white; font-family: inherit;">
                <option value="news" {{ old('category', $post->category) == 'news' ? 'selected' : '' }}>News</option>
                <option value="spotlight" {{ old('category', $post->category) == 'spotlight' ? 'selected' : '' }}>Gitania Spotlight</option>
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; text-transform: uppercase;">
                Tanggal Publikasi <span style="color: #DC2626;">*</span>
            </label>
            @php
                $publishedVal = $post->published_date ?? $post->published_at ?? now();
                $dateFormatted = \Carbon\Carbon::parse($publishedVal)->format('Y-m-d');
            @endphp
            <input type="date" name="published_at" value="{{ old('published_at', $dateFormatted) }}" required
                   style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit;">
        </div>
    </div>

    <!-- 3. Foto Thumbnail -->
    <div style="margin-bottom: 20px;">
        <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; text-transform: uppercase;">
            Foto Thumbnail
        </label>

        <!-- Preview Thumbnail Saat Ini -->
        <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 10px; padding: 10px; background: #FAF8FF; border: 1.5px solid #DDD6FE; border-radius: 10px;">
            <img id="currentThumbnailPreview" src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #DDD6FE;">
            <div>
                <span style="font-size: 12px; font-weight: 600; color: #1e1b4b; display: block;">Thumbnail Saat Ini</span>
                <span style="font-size: 11px; color: #64748b;">Pilih file baru di bawah jika ingin mengganti thumbnail.</span>
            </div>
        </div>

        <input type="file" name="thumbnail" accept="image/*" onchange="previewNewThumbnail(event)"
               style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12px; background: white;">
        <small style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">Format: JPG, PNG, WebP (Max: 2MB). Biarkan kosong jika tidak ingin mengubah foto.</small>
    </div>

    <!-- 4. Isi Konten Artikel -->
    <div style="margin-bottom: 25px;">
        <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; text-transform: uppercase;">
            Isi Deskripsi / Konten Artikel <span style="color: #DC2626;">*</span>
        </label>
        <textarea name="content" rows="8" required placeholder="Tulis deskripsi lengkap artikel di sini..."
                  style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit; line-height: 1.6;">{{ old('content', $post->content) }}</textarea>
    </div>

    <!-- Tombol Aksi -->
    <div style="display: flex; justify-content: flex-end; gap: 12px; flex-wrap: wrap;">
        <a href="{{ route('admin.media-posts.index') }}"
           style="background: #e2e8f0; color: #334155; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
            Batal
        </a>
        <button type="submit"
                style="background: var(--admin-purple); color: white; border: none; padding: 10px 24px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 14px rgba(107,33,168,0.25);">
            💾 Simpan Perubahan
        </button>
    </div>
</form>

<script>
function previewNewThumbnail(event) {
    const input = event.target;
    const preview = document.getElementById('currentThumbnailPreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
