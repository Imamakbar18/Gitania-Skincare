@extends('layouts.admin')

@section('title', 'Kelola Artikel Media - Admin Panel')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
    <div>
        <h2 style="color: #1e293b; font-size: 20px; font-weight: 700; margin: 0 0 4px 0; font-family: 'Poppins', sans-serif;">📰 Kelola Artikel (News & Spotlight)</h2>
        <p style="color: #64748b; font-size: 13px; margin: 0;">Tambah dan kelola artikel untuk halaman News dan Gitania Spotlight.</p>
    </div>
    <a href="{{ route('admin.media-posts.create') }}" style="background: var(--admin-purple); color: white; padding: 11px 18px; border-radius: 12px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; white-space: nowrap;">
        + Tambah Artikel Baru
    </a>
</div>

@if(session('success'))
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; margin-bottom: 20px;">
        ✨ {{ session('success') }}
    </div>
@endif

<div class="admin-card">
    <div class="admin-table-container">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; min-width: 600px;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #f1f5f9; color: #475569; font-weight: 600;">
                    <th style="padding: 12px 14px; width: 70px;">Thumbnail</th>
                    <th style="padding: 12px 14px;">Judul Artikel</th>
                    <th style="padding: 12px 14px;">Kategori</th>
                    <th style="padding: 12px 14px;">Tanggal Publikasi</th>
                    <th style="padding: 12px 14px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 12px 14px;">
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid #f1f5f9;">
                        </td>
                        <td style="padding: 12px 14px; font-weight: 600; color: #1e293b;">{{ $post->title }}</td>
                        <td style="padding: 12px 14px;">
                            <span style="background: {{ $post->category == 'news' ? '#e0f2fe' : '#f3e8ff' }}; color: {{ $post->category == 'news' ? '#0369a1' : 'var(--admin-purple)' }}; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase;">
                                {{ $post->category }}
                            </span>
                        </td>
                        <td style="padding: 12px 14px; color: #64748b; font-size: 12px;">{{ \Carbon\Carbon::parse($post->published_date ?? $post->published_at ?? $post->created_at)->translatedFormat('d F Y') }}</td>
                        <td style="padding: 12px 14px; text-align: center; white-space: nowrap;">
                            <a href="{{ route('admin.media-posts.edit', $post->id) }}"
                               style="background: #F5F3FF; color: #7C3AED; border: 1.5px solid #DDD6FE; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; margin-right: 6px; transition: all 0.2s;"
                               onmouseover="this.style.background='#EDE9FE'"
                               onmouseout="this.style.background='#F5F3FF'">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('admin.media-posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">
                            <div style="font-size: 32px; margin-bottom: 10px;">📰</div>
                            Belum ada artikel. Silakan tambahkan artikel baru.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
