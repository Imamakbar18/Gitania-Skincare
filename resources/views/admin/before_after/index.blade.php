@extends('layouts.admin')

@section('title', 'Kelola Hasil Nyata (Before-After) — Gitania Skincare')

@section('content')
<!-- Page Header -->
<div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
    <div>
        <h2 style="color: #1e293b; font-size: 20px; font-weight: 700; margin: 0 0 4px 0; font-family: 'Poppins', sans-serif;">✨ Kelola Hasil Nyata (Before - After)</h2>
        <p style="color: #64748b; font-size: 13px; margin: 0;">Atur kartu testimoni foto klinis Sebelum & Sesudah perawatan yang tampil di halaman depan (Home).</p>
    </div>
    <a href="{{ route('home') }}#hasil-nyata" target="_blank"
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

<!-- Grid 2 Kolom: Form Tambah (Kiri) & Daftar Kasus (Kanan) -->
<div style="display: grid; grid-template-columns: 380px 1fr; gap: 24px; align-items: start;">

    <!-- ========================================================
         KOLOM KIRI: FORM TAMBAH KASUS BARU
         ======================================================== -->
    <div class="admin-card" style="border: 1.5px solid #DDD6FE; position: sticky; top: 90px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1.5px solid #EDE9FE;">
            <div style="width: 36px; height: 36px; background: #F5F3FF; color: #7C3AED; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; border: 1.5px solid #DDD6FE;">
                ➕
            </div>
            <h3 style="font-size: 15px; font-weight: 700; color: #1e1b4b; margin: 0; font-family: 'Poppins', sans-serif;">Tambah Kasus Baru</h3>
        </div>

        <form action="{{ route('admin.before-after.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 1. Judul Kasus (Pill Title) -->
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">
                    Judul / Kondisi Kasus <span style="color: #DC2626;">*</span>
                </label>
                <input type="text" name="case_title" value="{{ old('case_title') }}" required
                       placeholder="Contoh: Acne Gd 3, EPA / Melasma Vaskular"
                       style="width: 100%; padding: 10px 14px; border: 1.5px solid #DDD6FE; border-radius: 10px; font-size: 13px; background: #FAF8FF; outline: none; font-family: 'Poppins', sans-serif;">
            </div>

            <!-- 2. Dokter / Cabang Klinik -->
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">
                    Dokter / Cabang Klinik
                </label>
                <input type="text" name="doctor_or_branch" value="{{ old('doctor_or_branch', 'Treatment by : dr. Farah') }}"
                       placeholder="Contoh: Treatment by : dr. Farah / Gitania Purwokerto"
                       style="width: 100%; padding: 10px 14px; border: 1.5px solid #DDD6FE; border-radius: 10px; font-size: 13px; background: #FAF8FF; outline: none;">
            </div>

            <!-- 3. Hashtag Tagline (Opsional) -->
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">
                    Hashtag / Slogan (Opsional)
                </label>
                <input type="text" name="hashtag" value="{{ old('hashtag', '#JUARANYA ATASI MASALAH KULIT') }}"
                       placeholder="#JUARANYA ATASI MASALAH KULIT"
                       style="width: 100%; padding: 10px 14px; border: 1.5px solid #DDD6FE; border-radius: 10px; font-size: 13px; background: #FAF8FF; outline: none;">
            </div>

            <!-- 4. Urutan Tampil -->
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">
                    Urutan Tampil (Kartu ke-...)
                </label>
                <input type="number" name="order" value="{{ old('order', $cases->count() + 1) }}" min="1"
                       style="width: 100%; padding: 10px 14px; border: 1.5px solid #DDD6FE; border-radius: 10px; font-size: 13px; background: #FAF8FF; outline: none;">
            </div>

            <!-- 5. Upload File Foto Split Before-After -->
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">
                    Foto Split Before-After <span style="color: #DC2626;">*</span>
                </label>
                <input type="file" name="image" id="caseImageInput" accept="image/*" required
                       onchange="previewCaseImage(event)"
                       style="width: 100%; font-size: 12px; color: #475569;">
                <small style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">Gunakan foto split perbandingan Before & After (JPG/PNG max 5MB).</small>

                <!-- Box Preview Gambar -->
                <div id="casePreviewContainer" style="display: none; margin-top: 10px; border-radius: 12px; overflow: hidden; border: 1.5px dashed #7C3AED; background: #FAF8FF; text-align: center; padding: 6px;">
                    <img id="casePreviewImg" src="#" alt="Preview Foto" style="max-width: 100%; max-height: 140px; object-fit: cover; border-radius: 8px;">
                </div>
            </div>

            <!-- 6. Deskripsi Penjelasan Pasien -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">
                    Deskripsi Penjelasan Kasus <span style="color: #DC2626;">*</span>
                </label>
                <textarea name="description" rows="4" required
                          placeholder="Jelaskan kondisi awal pasien, nama treatment yang diberikan, dan hasil perubahan kulitnya..."
                          style="width: 100%; padding: 10px 14px; border: 1.5px solid #DDD6FE; border-radius: 10px; font-size: 12.5px; background: #FAF8FF; outline: none; font-family: 'Poppins', sans-serif; resize: vertical;">{{ old('description') }}</textarea>
            </div>

            <!-- Tombol Submit -->
            <button type="submit"
                    style="width: 100%; background: linear-gradient(135deg, #6B21A8, #7C3AED); color: white; border: none; padding: 12px; border-radius: 10px; font-size: 13.5px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(107, 33, 168, 0.25); transition: all 0.2s;"
                    onmouseover="this.style.opacity='0.95'; this.style.transform='translateY(-1px)'"
                    onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'">
                <span>➕</span> Simpan Kasus
            </button>
        </form>
    </div>

    <!-- ========================================================
         KOLOM KANAN: DAFTAR KASUS BEFORE-AFTER AKTIF
         ======================================================== -->
    <div>
        <div class="admin-card" style="margin-bottom: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1.5px solid #EDE9FE;">
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #1e1b4b; margin: 0; font-family: 'Poppins', sans-serif;">
                        Daftar Kartu Kasus ({{ $cases->count() }})
                    </h3>
                    <p style="font-size: 12.5px; color: #64748b; margin: 2px 0 0 0;">Semua kasus yang aktif akan tampil di section Hasil Nyata pada homepage.</p>
                </div>
            </div>

            @if($cases->isEmpty())
                <div style="text-align: center; padding: 50px 20px; color: #64748b;">
                    <div style="font-size: 44px; margin-bottom: 10px;">✨</div>
                    <p style="font-weight: 600; font-size: 14px; margin-bottom: 4px;">Belum ada data Hasil Nyata</p>
                    <p style="font-size: 12.5px; margin: 0;">Gunakan formulir di sebelah kiri untuk menambahkan data foto Before-After.</p>
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
                    @foreach($cases as $case)
                        @php
                            $imgSrc = str_starts_with($case->image_path, 'images/')
                                ? asset($case->image_path)
                                : asset('storage/' . $case->image_path);
                        @endphp

                        <div style="border: 1.5px solid {{ $case->is_active ? '#DDD6FE' : '#E2E8F0' }}; border-radius: 18px; overflow: hidden; background: #ffffff; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 15px rgba(107,33,168,0.05); transition: all 0.25s;">
                            
                            <!-- Bagian Atas Mini Preview -->
                            <div>
                                <!-- Top Frame Banner -->
                                <div style="background: linear-gradient(165deg, #EFE5FD 0%, #DFC9FA 50%, #D0B1F8 100%); padding: 14px 14px 10px 14px; position: relative;">
                                    
                                    <!-- Order Badge & Status -->
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <span style="background: white; color: #6B21A8; font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: 999px; border: 1px solid #DDD6FE;">
                                            #{{ $case->order }}
                                        </span>
                                        <span style="background: {{ $case->is_active ? '#DCFCE7' : '#F1F5F9' }}; color: {{ $case->is_active ? '#15803D' : '#64748B' }}; font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: 999px;">
                                            {{ $case->is_active ? '● Tampil di Web' : '○ Disembunyikan' }}
                                        </span>
                                    </div>

                                    <!-- Pill Judul -->
                                    <div style="text-align: center; margin-bottom: 10px;">
                                        <span style="display: inline-block; background: linear-gradient(180deg, #F8F3FF, #EBDCFE); color: #4A1E70; font-size: 11.5px; font-weight: 700; padding: 3px 14px; border-radius: 999px; border: 1px solid rgba(255,255,255,0.9); box-shadow: 0 2px 6px rgba(124,58,237,0.12);">
                                            {{ $case->case_title }}
                                        </span>
                                    </div>

                                    <!-- Foto Container -->
                                    <div style="position: relative; width: 100%; aspect-ratio: 4/3; border-radius: 12px; overflow: hidden; background: white; border: 2px solid white; box-shadow: 0 4px 12px rgba(90,46,136,0.12);">
                                        <img src="{{ $imgSrc }}" alt="{{ $case->case_title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        <!-- Censor Bars Overlay -->
                                        <div style="position: absolute; top: 38%; left: 8%; width: 34%; height: 12px; background: white; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"></div>
                                        <div style="position: absolute; top: 38%; right: 8%; width: 34%; height: 12px; background: white; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"></div>
                                    </div>

                                    <!-- Tag Dokter / Subtitle -->
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px; font-size: 10.5px; color: #4C1D95; font-weight: 600;">
                                        <span>{{ $case->doctor_or_branch }}</span>
                                        @if($case->hashtag)
                                            <span style="font-size: 8.5px; color: #7C3AED; font-weight: 800;">{{ $case->hashtag }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Box Deskripsi -->
                                <div style="padding: 14px 14px 10px 14px;">
                                    <p style="font-size: 12px; color: #475569; line-height: 1.55; margin: 0; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $case->description }}
                                    </p>
                                </div>
                            </div>

                            <!-- Footer Aksi Tombol -->
                            <div style="padding: 12px 14px; background: #FAF8FF; border-top: 1px solid #EDE9FE; display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                                
                                <!-- Toggle Status -->
                                <form action="{{ route('admin.before-after.toggle', $case->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit"
                                            title="{{ $case->is_active ? 'Klik untuk sembunyikan' : 'Klik untuk tampilkan' }}"
                                            style="background: {{ $case->is_active ? '#DCFCE7' : '#F1F5F9' }}; color: {{ $case->is_active ? '#15803D' : '#64748B' }}; border: 1px solid {{ $case->is_active ? '#86EFAC' : '#CBD5E1' }}; padding: 6px 10px; border-radius: 8px; font-size: 11px; font-weight: 600; cursor: pointer;">
                                        {{ $case->is_active ? '👁️ Aktif' : '🔒 Sembunyi' }}
                                    </button>
                                </form>

                                <div style="display: flex; gap: 6px;">
                                    <!-- Tombol Edit Modal -->
                                    <button type="button"
                                            onclick='openEditModal(@json($case), "{{ $imgSrc }}")'
                                            style="background: #F5F3FF; color: #7C3AED; border: 1px solid #DDD6FE; padding: 6px 12px; border-radius: 8px; font-size: 11.5px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px;">
                                        ✏️ Edit
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.before-after.destroy', $case->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data hasil nyata kasus {{ addslashes($case->case_title) }}?');"
                                          style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                style="background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; padding: 6px 10px; border-radius: 8px; font-size: 11.5px; font-weight: 600; cursor: pointer;">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>

<!-- ========================================================
     MODAL EDIT KASUS BEFORE-AFTER
     ======================================================== -->
<div id="editCaseModal" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.55); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: white; border-radius: 20px; max-width: 520px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.3); border: 2px solid #DDD6FE;">
        
        <!-- Modal Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 18px 24px; border-bottom: 1.5px solid #EDE9FE; background: #FAF8FF;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 20px;">✏️</span>
                <h3 style="font-size: 16px; font-weight: 700; color: #1e1b4b; margin: 0;">Edit Kasus Before-After</h3>
            </div>
            <button onclick="closeEditModal()" style="background: #F5F3FF; border: 1px solid #DDD6FE; width: 32px; height: 32px; border-radius: 50%; color: #6B21A8; font-size: 14px; font-weight: bold; cursor: pointer;">✕</button>
        </div>

        <!-- Modal Form -->
        <form id="editCaseForm" method="POST" enctype="multipart/form-data" style="padding: 20px 24px;">
            @csrf
            @method('PUT')

            <!-- Judul Kasus -->
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">Judul / Kondisi Kasus <span style="color: #DC2626;">*</span></label>
                <input type="text" name="case_title" id="editCaseTitle" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #DDD6FE; border-radius: 10px; font-size: 13px; background: #FAF8FF; outline: none;">
            </div>

            <!-- Dokter / Cabang -->
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">Dokter / Cabang Klinik</label>
                <input type="text" name="doctor_or_branch" id="editCaseDoctor" style="width: 100%; padding: 10px 14px; border: 1.5px solid #DDD6FE; border-radius: 10px; font-size: 13px; background: #FAF8FF; outline: none;">
            </div>

            <!-- Hashtag -->
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">Hashtag / Slogan</label>
                <input type="text" name="hashtag" id="editCaseHashtag" style="width: 100%; padding: 10px 14px; border: 1.5px solid #DDD6FE; border-radius: 10px; font-size: 13px; background: #FAF8FF; outline: none;">
            </div>

            <!-- Urutan -->
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">Urutan Tampil</label>
                <input type="number" name="order" id="editCaseOrder" min="1" style="width: 100%; padding: 10px 14px; border: 1.5px solid #DDD6FE; border-radius: 10px; font-size: 13px; background: #FAF8FF; outline: none;">
            </div>

            <!-- Ganti Foto -->
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">Ganti Foto (Biarkan kosong jika tidak ingin ganti)</label>
                <input type="file" name="image" id="editCaseImageInput" accept="image/*" onchange="previewEditCaseImage(event)" style="width: 100%; font-size: 12px; color: #475569;">
                
                <div style="margin-top: 10px; text-align: center;">
                    <p style="font-size: 11px; color: #64748b; margin-bottom: 6px;">Foto Saat Ini / Preview:</p>
                    <img id="editCaseImgPreview" src="" alt="Preview" style="max-width: 100%; max-height: 140px; object-fit: cover; border-radius: 10px; border: 1.5px solid #DDD6FE;">
                </div>
            </div>

            <!-- Deskripsi -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">Deskripsi Kasus <span style="color: #DC2626;">*</span></label>
                <textarea name="description" id="editCaseDesc" rows="4" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #DDD6FE; border-radius: 10px; font-size: 12.5px; background: #FAF8FF; outline: none; resize: vertical;"></textarea>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeEditModal()" style="padding: 10px 18px; border: 1.5px solid #CBD5E1; background: white; color: #475569; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer;">
                    Batal
                </button>
                <button type="submit" style="padding: 10px 22px; background: linear-gradient(135deg, #6B21A8, #7C3AED); color: white; border: none; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(107,33,168,0.2);">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Preview Foto Tambah
function previewCaseImage(event) {
    const input = event.target;
    const previewContainer = document.getElementById('casePreviewContainer');
    const previewImg = document.getElementById('casePreviewImg');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Modal Edit
function openEditModal(caseData, currentImgUrl) {
    const modal = document.getElementById('editCaseModal');
    const form = document.getElementById('editCaseForm');

    form.action = "{{ url('admin/before-after') }}/" + caseData.id;
    document.getElementById('editCaseTitle').value = caseData.case_title;
    document.getElementById('editCaseDoctor').value = caseData.doctor_or_branch || '';
    document.getElementById('editCaseHashtag').value = caseData.hashtag || '';
    document.getElementById('editCaseOrder').value = caseData.order || 1;
    document.getElementById('editCaseDesc').value = caseData.description || '';
    document.getElementById('editCaseImgPreview').src = currentImgUrl;

    modal.style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editCaseModal').style.display = 'none';
}

// Preview Foto Edit
function previewEditCaseImage(event) {
    const input = event.target;
    const previewImg = document.getElementById('editCaseImgPreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Tutup modal jika klik backdrop
window.addEventListener('click', function(event) {
    const modal = document.getElementById('editCaseModal');
    if (event.target === modal) {
        closeEditModal();
    }
});
</script>
@endsection
