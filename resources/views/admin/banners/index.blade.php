@extends('layouts.admin')

@section('title', 'Kelola Banner Slider — Gitania Skincare')

@section('content')
<!-- Page Header -->
<div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
    <div>
        <h2 style="color: #1e293b; font-size: 20px; font-weight: 700; margin: 0 0 4px 0; font-family: 'Poppins', sans-serif;">🖼️ Kelola Banner Hero Slider</h2>
        <p style="color: #64748b; font-size: 13px; margin: 0;">Atur foto-foto banner interaktif yang berganti-ganti di halaman depan (Home) website.</p>
    </div>
    <a href="{{ route('home') }}" target="_blank"
       style="background: #F5F3FF; color: #7C3AED; border: 1.5px solid #DDD6FE; padding: 9px 18px; border-radius: 10px; font-weight: 600; font-size: 12.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;"
       onmouseover="this.style.background='#EDE9FE'"
       onmouseout="this.style.background='#F5F3FF'">
        👁️ Lihat Tampilan di Homepage →
    </a>
</div>

<!-- Alert Sukses -->
@if(session('success'))
    <div style="background: #F0FDF4; border: 1.5px solid #BBF7D0; color: #15803D; padding: 14px 18px; border-radius: 12px; font-size: 13px; font-weight: 600; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
        <span>✅</span> {{ session('success') }}
    </div>
@endif

<!-- Alert Error Validasi -->
@if($errors->any())
    <div style="background: #FEF2F2; border: 1.5px solid #FECACA; color: #DC2626; padding: 14px 18px; border-radius: 12px; font-size: 13px; margin-bottom: 24px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Grid 2 Kolom: Form Tambah (Kiri) & Daftar Banner Aktif (Kanan) -->
<div style="display: grid; grid-template-columns: 360px 1fr; gap: 24px; align-items: start;">

    <!-- ========================================================
         KOLOM KIRI: FORM TAMBAH BANNER BARU
         ======================================================== -->
    <div class="admin-card" style="border: 1.5px solid #DDD6FE; position: sticky; top: 90px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1.5px solid #EDE9FE;">
            <div style="width: 36px; height: 36px; background: #F5F3FF; color: #7C3AED; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; border: 1.5px solid #DDD6FE;">
                ➕
            </div>
            <h3 style="font-size: 15px; font-weight: 700; color: #1e1b4b; margin: 0; font-family: 'Poppins', sans-serif;">Tambah Banner Baru</h3>
        </div>

        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 1. Judul / Label Slide -->
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">
                    Nama / Label Slide <span style="color: #DC2626;">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       placeholder="Contoh: Signature Set, Sunscreen Serum"
                       style="width: 100%; padding: 10px 14px; border: 1.5px solid #DDD6FE; border-radius: 10px; font-size: 13px; background: #FAF8FF; outline: none; font-family: 'Poppins', sans-serif;">
                <small style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">Teks ini akan muncul pada tombol pill di bawah slider.</small>
            </div>

            <!-- 2. Icon / Emoji -->
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">
                    Icon / Emoji Tombol
                </label>
                <input type="text" name="icon" value="{{ old('icon', '🌿') }}"
                       placeholder="🌿, ☀️, ✨, 🌸"
                       style="width: 100%; padding: 10px 14px; border: 1.5px solid #DDD6FE; border-radius: 10px; font-size: 13px; background: #FAF8FF; outline: none;">
            </div>

            <!-- 3. Urutan Tampil -->
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">
                    Urutan Tampil (Slide ke-...)
                </label>
                <input type="number" name="order" value="{{ old('order', $banners->count() + 1) }}" min="1"
                       style="width: 100%; padding: 10px 14px; border: 1.5px solid #DDD6FE; border-radius: 10px; font-size: 13px; background: #FAF8FF; outline: none;">
            </div>

            <!-- 4. Upload File Foto -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">
                    File Foto Banner <span style="color: #DC2626;">*</span>
                </label>
                <input type="file" name="image" id="bannerImageInput" accept="image/*" required
                       onchange="previewBannerImage(event)"
                       style="width: 100%; font-size: 12px; color: #475569;">
                <small style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">Rekomendasi rasio: 16:9 / Landscape (JPG, PNG, WebP max 5MB).</small>

                <!-- Box Preview Gambar -->
                <div id="bannerPreviewContainer" style="display: none; margin-top: 12px; border-radius: 12px; overflow: hidden; border: 1.5px dashed #7C3AED; background: #FAF8FF; text-align: center; padding: 6px;">
                    <img id="bannerPreviewImg" src="#" alt="Preview Banner" style="max-width: 100%; max-height: 160px; object-fit: cover; border-radius: 8px;">
                </div>
            </div>

            <!-- Tombol Submit -->
            <button type="submit"
                    style="width: 100%; padding: 12px; background: linear-gradient(135deg, #8B5CF6, #7C3AED); color: white; border: none; border-radius: 10px; font-weight: 700; font-size: 13.5px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(124, 58, 237, 0.25); transition: opacity 0.2s;"
                    onmouseover="this.style.opacity='0.92'"
                    onmouseout="this.style.opacity='1'">
                🚀 Unggah Banner Slider
            </button>
        </form>
    </div>

    <!-- ========================================================
         KOLOM KANAN: DAFTAR BANNER SLIDER YANG ADA
         ======================================================== -->
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: 16px; font-weight: 700; color: #1e1b4b; margin: 0; font-family: 'Poppins', sans-serif;">
                📋 Daftar Slide Banner ({{ $banners->count() }} Foto)
            </h3>
            <span style="font-size: 12px; color: #7C3AED; font-weight: 600;">Slider otomatis berganti setiap 4.5 detik</span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
            @forelse($banners as $banner)
            <div class="admin-card" style="margin-bottom: 0; border: 1.5px solid #DDD6FE; padding: 0; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s, box-shadow 0.2s;"
                 onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 10px 24px rgba(107,33,168,0.10)'"
                 onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'">
                
                <!-- Preview Foto Banner -->
                <div style="position: relative; width: 100%; height: 180px; background: #EDE9FE; overflow: hidden;">
                    @php
                        $imageSrc = str_starts_with($banner->image_path, 'images/') 
                            ? asset($banner->image_path) 
                            : asset('storage/' . $banner->image_path);
                    @endphp
                    <img src="{{ $imageSrc }}" alt="{{ $banner->title }}" style="width: 100%; height: 100%; object-fit: cover;">

                    <!-- Badge Slide # -->
                    <div style="position: absolute; top: 12px; left: 12px; background: rgba(107,33,168,0.85); backdrop-filter: blur(4px); color: white; padding: 3px 10px; border-radius: 999px; font-size: 11px; font-weight: 700;">
                        Slide #{{ $banner->order }}
                    </div>

                    <!-- Badge Status Aktif -->
                    <div style="position: absolute; top: 12px; right: 12px;">
                        @if($banner->is_active)
                            <span style="background: rgba(22, 163, 74, 0.9); backdrop-filter: blur(4px); color: white; padding: 3px 10px; border-radius: 999px; font-size: 10.5px; font-weight: 700;">
                                ● Aktif
                            </span>
                        @else
                            <span style="background: rgba(100, 116, 139, 0.9); backdrop-filter: blur(4px); color: white; padding: 3px 10px; border-radius: 999px; font-size: 10.5px; font-weight: 700;">
                                ○ Non-Aktif
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Info Banner -->
                <div style="padding: 16px 18px; flex: 1;">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                        <span style="font-size: 18px;">{{ $banner->icon ?? '✨' }}</span>
                        <h4 style="font-size: 15px; font-weight: 700; color: #1e1b4b; margin: 0; font-family: 'Poppins', sans-serif;">
                            {{ $banner->title }}
                        </h4>
                    </div>
                    <p style="font-size: 11.5px; color: #64748b; margin: 0;">
                        Urutan: <strong>Slide ke-{{ $banner->order }}</strong> • Ditambahkan: {{ $banner->created_at->format('d/m/Y') }}
                    </p>
                </div>

                <!-- Action Footer (Toggle & Hapus) -->
                <div style="padding: 12px 18px; background: #FAF8FF; border-top: 1px solid #EDE9FE; display: flex; justify-content: space-between; align-items: center; gap: 10px;">
                    <!-- Form Toggle Status -->
                    <form action="{{ route('admin.banners.toggle', $banner->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit"
                                style="padding: 6px 12px; border-radius: 8px; font-size: 11.5px; font-weight: 600; cursor: pointer; border: 1.5px solid; transition: all 0.2s;
                                       {{ $banner->is_active ? 'background: #F0FDF4; border-color: #BBF7D0; color: #16A34A;' : 'background: #F1F5F9; border-color: #CBD5E1; color: #64748b;' }}">
                            {{ $banner->is_active ? 'Matikan Slide' : 'Aktifkan Slide' }}
                        </button>
                    </form>

                    <!-- Form Hapus -->
                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="margin: 0;"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus banner slider ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                style="padding: 6px 12px; background: #FEF2F2; border: 1.5px solid #FECACA; color: #DC2626; border-radius: 8px; font-size: 11.5px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px; transition: background 0.2s;"
                                onmouseover="this.style.background='#FEE2E2'"
                                onmouseout="this.style.background='#FEF2F2'">
                            🗑️ Hapus
                        </button>
                    </form>
                </div>

            </div>
            @empty
            <div style="grid-column: 1 / -1; background: white; border: 1.5px dashed #DDD6FE; border-radius: 16px; padding: 50px 20px; text-align: center; color: #6B21A8;">
                <div style="font-size: 36px; margin-bottom: 10px;">🖼️</div>
                <h4 style="font-size: 16px; font-weight: 700; margin: 0 0 6px 0;">Belum Ada Banner Slider</h4>
                <p style="font-size: 13px; color: #64748b; margin: 0 0 16px 0;">Gunakan formulir di sebelah kiri untuk menambahkan foto banner slider baru.</p>
            </div>
            @endforelse
        </div>
    </div>

</div>

<!-- Script Preview Image -->
<script>
function previewBannerImage(event) {
    const input = event.target;
    const container = document.getElementById('bannerPreviewContainer');
    const preview = document.getElementById('bannerPreviewImg');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        container.style.display = 'none';
    }
}
</script>

<style>
@media (max-width: 900px) {
    div[style*="grid-template-columns: 360px 1fr"] {
        grid-template-columns: 1fr !important;
    }
    .admin-card[style*="position: sticky"] {
        position: static !important;
    }
}
</style>
@endsection
