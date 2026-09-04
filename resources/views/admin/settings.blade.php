@extends('layouts.admin')

@section('title', 'My Profile - Admin Panel')

@section('content')
<div style="max-width: 900px; margin: 0 auto; position: relative;">

    <!-- Judul Halaman -->
    <h1 style="color: #1e293b; font-size: 22px; font-weight: 700; margin-bottom: 20px; font-family: 'Poppins', sans-serif;">Pengaturan Profil Admin</h1>

    <!-- BOX 1: HEADER PROFIL (AVATAR & INFO UTAMA) -->
    <div class="admin-card" style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
        <div style="position: relative;">
            <div style="width: 70px; height: 70px; background: var(--admin-purple-soft); color: var(--admin-purple); border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; font-size: 26px; font-weight: 700; border: 2px solid var(--admin-purple-light); flex-shrink: 0;">
                @if(Auth::user()->profile_photo)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    {{ substr(Auth::user()->name, 0, 1) }}
                @endif
            </div>
        </div>
        <div style="min-width: 0; flex: 1;">
            <h2 style="margin: 0 0 4px 0; font-size: 18px; color: #1e293b; font-family: 'Poppins', sans-serif;">{{ Auth::user()->name }}</h2>
            <div style="font-size: 13px; color: var(--admin-purple); font-weight: 600; margin-bottom: 2px;">Administrator Gitania</div>
            <div style="font-size: 12px; color: #64748b;">{{ Auth::user()->email }}</div>
        </div>
    </div>

    <!-- BOX 2: PERSONAL INFORMATION -->
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
            <h3 style="margin: 0; font-size: 16px; color: #1e293b; font-weight: 700; font-family: 'Poppins', sans-serif;">Informasi Pribadi</h3>
            <button onclick="openModal('personalModal')" style="background: var(--admin-purple); color: white; border: none; padding: 8px 18px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <span>✏️</span> Edit Profil
            </button>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
            <div>
                <div style="font-size: 11px; color: #94a3b8; font-weight: 700; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Nama Lengkap</div>
                <div style="font-size: 14px; font-weight: 600; color: #1e293b;">{{ Auth::user()->name }}</div>
            </div>
            <div>
                <div style="font-size: 11px; color: #94a3b8; font-weight: 700; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Alamat Email</div>
                <div style="font-size: 14px; font-weight: 600; color: #1e293b;">{{ Auth::user()->email }}</div>
            </div>
        </div>
    </div>
</div>

<!-- ================= MODAL EDIT PERSONAL INFORMATION RESPONSIF ================= -->
<div id="personalModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(3px); z-index: 100000; align-items: center; justify-content: center; padding: 16px;">
    <div style="background: white; width: 100%; max-width: 480px; border-radius: 18px; padding: 24px; position: relative; box-shadow: 0 20px 40px rgba(0,0,0,0.2); max-height: calc(100vh - 32px); overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0; font-size: 17px; font-weight: 700; color: #1e293b; font-family: 'Poppins', sans-serif;">Edit Informasi Profil</h3>
            <button type="button" onclick="closeModal('personalModal')" style="background: #f1f5f9; border: none; width: 30px; height: 30px; border-radius: 8px; font-size: 16px; cursor: pointer; color: #64748b;">✕</button>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <!-- PREVIEW FOTO SAAT INI DI DALAM MODAL -->
            <div style="margin-bottom: 18px; text-align: center; background: #f8fafc; padding: 15px; border-radius: 12px; border: 1px dashed #cbd5e1;">
                <label style="font-size: 12px; font-weight: 600; color: #475569; display: block; margin-bottom: 8px;">Foto Profil Saat Ini</label>
                <div style="width: 60px; height: 60px; margin: 0 auto 10px auto; border-radius: 50%; overflow: hidden; background: var(--admin-purple-soft); color: var(--admin-purple); display: flex; align-items: center; justify-content: center; font-weight: bold; border: 1.5px solid var(--admin-purple-light);">
                    @if(Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        {{ substr(Auth::user()->name, 0, 1) }}
                    @endif
                </div>

                <label style="font-size: 12px; font-weight: 600; color: #475569; display: block; margin-top: 8px;">Ganti Foto Profil Baru (Opsional)</label>
                <input type="file" name="profile_photo" accept="image/*" style="font-size: 12px; color: #64748b; margin-top: 6px; width: 100%; max-width: 250px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-size: 12px; font-weight: 600; color: #475569; display: block; margin-bottom: 6px; text-transform: uppercase;">Nama Lengkap</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit;">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px; flex-wrap: wrap;">
                <button type="button" onclick="closeModal('personalModal')" style="padding: 10px 18px; background: #e2e8f0; border: none; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13px;">Batal</button>
                <button type="submit" style="padding: 10px 22px; background: var(--admin-purple); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13px;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
        document.body.style.overflow = '';
    }
</script>
@endsection
