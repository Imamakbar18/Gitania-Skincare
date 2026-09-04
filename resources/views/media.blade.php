@extends('layouts.app')

@section('title', 'Follow Our Instagram — Gitania Skincare')

@section('content')
    <style>
        .insta-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(74, 46, 122, 0.08); }
    </style>

    <!-- CONTAINER UTAMA HALAMAN INSTAGRAM FEED -->
    <div style="max-width: 1100px; margin: 50px auto 80px auto; padding: 0 20px;">

        <!-- HEADER BAGIAN ATAS (Judul & Tombol Open Instagram) -->
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 35px; border-bottom: 1px solid var(--lilac-soft); padding-bottom: 20px;">
            <div>
                <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--accent-pink); letter-spacing: 1.5px; margin-bottom: 6px;">Social Media</div>
                <h1 style="color: var(--purple-deep); font-size: 28px; font-weight: 700; margin: 0 0 4px 0;">Follow Our Instagram</h1>
                <p style="color: #665c75; font-size: 13px; margin: 0;">@gitaniaskincare</p>
            </div>
            <div>
                <a href="https://www.instagram.com" target="_blank" style="font-size: 13px; font-weight: 600; color: var(--purple-deep); text-decoration: none; display: flex; align-items: center; gap: 6px; transition: 0.2s;" onmouseover="this.style.color='var(--accent-pink)'" onmouseout="this.style.color='var(--purple-deep)'">
                    Open Instagram &rarr;
                </a>
            </div>
        </div>

        <!-- GRID FEED INSTAGRAM -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
            @forelse($mediaItems as $item)
                <a href="{{ $item->instagram_link }}" target="_blank" class="insta-card" style="background: white; border-radius: 16px; overflow: hidden; border: 1px solid var(--lilac-soft); text-decoration: none; color: inherit; box-shadow: 0 6px 20px rgba(74, 46, 122, 0.03); display: flex; flex-direction: column; transition: all 0.2s ease;">

                    <!-- Thumbnail Foto Kegiatan -->
                    <div style="width: 100%; height: 200px; overflow: hidden; background: #eee; position: relative;">
                        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        <!-- Ikon Kecil Instagram di Pojok -->
                        <div style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.4); color: white; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px;">
                            📸
                        </div>
                    </div>

                    <!-- Keterangan Judul Singkat -->
                    <div style="padding: 15px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <h3 style="font-size: 13px; margin: 0 0 10px 0; color: var(--text-dark); font-weight: 500; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $item->title }}
                        </h3>
                        <span style="font-size: 11px; font-weight: 600; color: var(--accent-pink);">View Post &rarr;</span>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px; background: white; border-radius: 20px; border: 1px solid var(--lilac-soft);">
                    <p style="font-size: 14px; color: #665c75; font-weight: 500; margin: 0;">Belum ada postingan Instagram yang dibagikan oleh admin.</p>
                </div>
            @endforelse
        </div>

    </div>
@endsection
