@extends('layouts.admin')

@section('title', 'Kelola Media - Admin Gitania Skincare')

@section('content')
<div class="admin-card">

    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 14px;">
        <div>
            <h1 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0; font-family: 'Poppins', sans-serif;">📸 Kelola Media Instagram</h1>
            <p style="font-size: 13px; color: #64748b; margin: 0;">Kelola postingan feed Instagram yang tampil di halaman depan.</p>
        </div>
        <a href="{{ route('admin.media.form.create') }}" style="background: var(--admin-purple); color: white; padding: 11px 18px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; white-space: nowrap;">
            + Tambah Media Baru
        </a>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; color: #065f46; padding: 12px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; font-weight: 600;">
            ✨ {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Data Media Responsif -->
    <div class="admin-table-container">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; min-width: 550px;">
            <thead>
                <tr style="border-bottom: 1px solid #f1f5f9; background: #f8fafc; color: #475569;">
                    <th style="padding: 12px 14px; font-weight: 600; width: 80px;">Thumbnail</th>
                    <th style="padding: 12px 14px; font-weight: 600;">Judul</th>
                    <th style="padding: 12px 14px; font-weight: 600;">Link Instagram</th>
                    <th style="padding: 12px 14px; text-align: center; font-weight: 600;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mediaItems as $media)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 12px 14px;">
                            <img src="{{ asset('storage/' . $media->thumbnail) }}" alt="Thumbnail" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid #f1f5f9;">
                        </td>
                        <td style="padding: 12px 14px; color: #334155; font-weight: 600;">{{ $media->title }}</td>
                        <td style="padding: 12px 14px;">
                            <a href="{{ $media->instagram_link }}" target="_blank" style="text-decoration: none; color: var(--admin-purple); font-weight: 600; font-size: 13px;">Buka Link ↗</a>
                        </td>
                        <td style="padding: 12px 14px; text-align: center;">
                            <form action="{{ route('admin.media.remove', $media->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus media ini?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #fee2e2; color: #dc2626; border: none; padding: 6px 14px; border-radius: 8px; cursor: pointer; font-size: 12px; font-weight: 600;">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 40px; text-align: center; color: #94a3b8;">
                            <div style="font-size: 32px; margin-bottom: 10px;">📸</div>
                            Belum ada data media Instagram.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
