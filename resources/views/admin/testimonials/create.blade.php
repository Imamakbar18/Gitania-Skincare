@extends('layouts.admin')

@section('title', 'Tambah Ulasan Baru — Admin Gitania Skincare')

@section('content')
<style>
    .form-container-card {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        border-radius: 24px;
        border: 1.5px solid #DDD6FE;
        padding: 36px 32px;
        box-shadow: 0 10px 30px rgba(107, 33, 168, 0.05);
    }
    .form-header-box {
        border-bottom: 1.5px solid #F1F5F9;
        padding-bottom: 20px;
        margin-bottom: 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }
    .form-title {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        font-weight: 700;
        color: var(--admin-purple);
        margin: 0 0 4px 0;
    }
    .form-desc {
        font-size: 13.5px;
        color: #64748b;
        margin: 0;
    }
    .btn-back-link {
        color: #7C3AED;
        font-weight: 600;
        font-size: 13.5px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .form-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    @media (max-width: 640px) {
        .form-row-2 {
            grid-template-columns: 1fr;
        }
    }
    .form-group-item {
        margin-bottom: 22px;
    }
    .form-label-custom {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #1E1B4B;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .form-input-custom {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #DDD6FE;
        border-radius: 12px;
        font-size: 14px;
        color: #1E1B4B;
        background: #FAF8FF;
        outline: none;
        box-sizing: border-box;
        font-family: inherit;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-input-custom:focus {
        border-color: #7C3AED;
        background: white;
        box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
    }
    .form-help-text {
        font-size: 12px;
        color: #64748b;
        margin-top: 6px;
    }
    .color-preset-group {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 8px;
    }
    .color-preset-opt {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid transparent;
        transition: transform 0.2s;
    }
    .color-preset-opt:hover {
        transform: scale(1.15);
    }
    .color-preset-opt.selected {
        border-color: #1E1B4B;
        box-shadow: 0 0 0 3px rgba(107, 33, 168, 0.3);
    }
    .btn-submit-action {
        padding: 14px 28px;
        background: linear-gradient(135deg, #7C3AED, #6B21A8);
        color: white;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(107, 33, 168, 0.25);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-submit-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(107, 33, 168, 0.35);
    }
</style>

<div class="form-container-card">
    <div class="form-header-box">
        <div>
            <h1 class="form-title">✨ Tambah Ulasan Hasil Baru</h1>
            <p class="form-desc">Tambahkan testimoni pelanggan untuk ditampilkan di bagian "Cerita Indah Dari Sahabat Gitania".</p>
        </div>
        <a href="{{ route('admin.testimonials.index') }}" class="btn-back-link">
            ← Kembali ke Daftar
        </a>
    </div>

    @if ($errors->any())
        <div style="background: #FEF2F2; border: 1.5px solid #FECACA; color: #991B1B; padding: 14px 18px; border-radius: 12px; margin-bottom: 24px; font-size: 13.5px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.testimonials.store') }}" method="POST">
        @csrf

        <div class="form-row-2">
            <!-- Nama Pelanggan -->
            <div class="form-group-item">
                <label class="form-label-custom">Nama Pelanggan *</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Isnaini Azzahra" class="form-input-custom">
            </div>

            <!-- Badge / Status -->
            <div class="form-group-item">
                <label class="form-label-custom">Lencana / Status</label>
                <input type="text" name="badge" value="{{ old('badge', 'Terverifikasi') }}" placeholder="Contoh: Terverifikasi, Dokter Konsumen" class="form-input-custom">
                <div class="form-help-text">Tampil di samping nama (misal: ✓ Terverifikasi).</div>
            </div>
        </div>

        <div class="form-row-2">
            <!-- Rating Bintang -->
            <div class="form-group-item">
                <label class="form-label-custom">Rating Kepuasan (1 - 5 Bintang) *</label>
                <select name="rating" required class="form-input-custom">
                    <option value="5" {{ old('rating', 5) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Bintang - Sangat Puas)</option>
                    <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Bintang - Puas)</option>
                    <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 Bintang - Cukup)</option>
                    <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>⭐⭐ (2 Bintang - Kurang)</option>
                    <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>⭐ (1 Bintang)</option>
                </select>
            </div>

            <!-- Tag Produk / Treatment -->
            <div class="form-group-item">
                <label class="form-label-custom">Tag Produk / Treatment</label>
                <input type="text" name="product_tag" value="{{ old('product_tag') }}" placeholder="Contoh: ✨ Paket IPL Meso & Glow Kit" class="form-input-custom">
                <div class="form-help-text">Bisa sertakan emoji di depan nama produk.</div>
            </div>
        </div>

        <!-- Isi Ulasan / Cerita -->
        <div class="form-group-item">
            <label class="form-label-custom">Isi Cerita / Ulasan Pelanggan *</label>
            <textarea name="comment" rows="4" required placeholder="Tuliskan pengalaman atau ulasan lengkap pelanggan..." class="form-input-custom">{{ old('comment') }}</textarea>
        </div>

        <div class="form-row-2">
            <!-- Inisial Avatar (Opsional) -->
            <div class="form-group-item">
                <label class="form-label-custom">Inisial Avatar (Opsional)</label>
                <input type="text" name="avatar_initial" maxlength="2" value="{{ old('avatar_initial') }}" placeholder="Kosongkan untuk otomatis (huruf depan)" class="form-input-custom">
            </div>

            <!-- Urutan Tampil -->
            <div class="form-group-item">
                <label class="form-label-custom">Urutan Tampil (Order)</label>
                <input type="number" name="order_index" value="{{ old('order_index', 0) }}" class="form-input-custom">
                <div class="form-help-text">Angka lebih kecil tampil lebih awal.</div>
            </div>
        </div>

        <!-- Pilihan Warna Gradient Avatar -->
        <div class="form-group-item">
            <label class="form-label-custom">Warna Tema Avatar</label>
            <input type="hidden" name="avatar_gradient" id="selectedGradient" value="{{ old('avatar_gradient', 'linear-gradient(135deg, #7C3AED, #A855F7)') }}">
            <div class="color-preset-group">
                <div class="color-preset-opt selected" style="background: linear-gradient(135deg, #7C3AED, #A855F7);" onclick="pickGradient(this, 'linear-gradient(135deg, #7C3AED, #A855F7)')" title="Purple Luxury"></div>
                <div class="color-preset-opt" style="background: linear-gradient(135deg, #1E1B4B, #4C1D95);" onclick="pickGradient(this, 'linear-gradient(135deg, #1E1B4B, #4C1D95)')" title="Midnight Violet"></div>
                <div class="color-preset-opt" style="background: linear-gradient(135deg, #059669, #10B981);" onclick="pickGradient(this, 'linear-gradient(135deg, #059669, #10B981)')" title="Emerald Green"></div>
                <div class="color-preset-opt" style="background: linear-gradient(135deg, #DB2777, #F43F5E);" onclick="pickGradient(this, 'linear-gradient(135deg, #DB2777, #F43F5E)')" title="Rose Pink"></div>
                <div class="color-preset-opt" style="background: linear-gradient(135deg, #2563EB, #38BDF8);" onclick="pickGradient(this, 'linear-gradient(135deg, #2563EB, #38BDF8)')" title="Royal Blue"></div>
            </div>
        </div>

        <!-- Status Aktif Checkbox -->
        <div class="form-group-item" style="background: #FAF8FF; border: 1.5px solid #DDD6FE; padding: 16px 20px; border-radius: 14px; margin-top: 10px;">
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-weight: 600; color: #1E1B4B; font-size: 14px;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #7C3AED;">
                <span>🟢 Langsung Tampilkan Ulasan ini di Halaman Depan (Home)</span>
            </label>
        </div>

        <!-- Tombol Aksi -->
        <div style="margin-top: 30px; display: flex; gap: 14px; align-items: center;">
            <button type="submit" class="btn-submit-action">
                💾 Simpan Ulasan Baru
            </button>
            <a href="{{ route('admin.testimonials.index') }}" style="color: #64748b; font-weight: 600; font-size: 13.5px; text-decoration: none;">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    function pickGradient(el, gradientVal) {
        document.querySelectorAll('.color-preset-opt').forEach(opt => opt.classList.remove('selected'));
        el.classList.add('selected');
        document.getElementById('selectedGradient').value = gradientVal;
    }
</script>
@endsection
