@extends('layouts.admin')

@section('title', 'Kelola Ulasan & Testimoni — Admin Gitania Skincare')

@section('content')
<style>
    .testi-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .testi-page-title {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        font-weight: 700;
        color: var(--admin-purple);
        margin: 0 0 4px 0;
    }
    .testi-page-desc {
        color: #64748b;
        font-size: 13.5px;
        margin: 0;
    }

    /* Summary Cards */
    .testi-summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 18px;
        margin-bottom: 28px;
    }
    .testi-stat-card {
        background: white;
        border-radius: 18px;
        border: 1.5px solid #DDD6FE;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 16px rgba(107, 33, 168, 0.04);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .testi-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(107, 33, 168, 0.09);
    }
    .testi-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    .testi-stat-val {
        font-size: 24px;
        font-weight: 800;
        color: #1e1b4b;
        line-height: 1.2;
    }
    .testi-stat-lbl {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Filters Bar */
    .testi-filter-card {
        background: white;
        border-radius: 20px;
        border: 1.5px solid #DDD6FE;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 4px 16px rgba(107, 33, 168, 0.04);
    }
    .testi-filter-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }
    .testi-pill-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .testi-filter-pill {
        padding: 8px 18px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        color: #64748b;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .testi-filter-pill:hover {
        background: #EDE9FE;
        color: #6B21A8;
        border-color: #DDD6FE;
    }
    .testi-filter-pill.active {
        background: linear-gradient(135deg, #7C3AED, #6B21A8);
        color: white;
        border-color: #6B21A8;
        box-shadow: 0 4px 12px rgba(107, 33, 168, 0.25);
    }

    .testi-actions-right {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }
    .testi-search-box {
        display: flex;
        align-items: center;
        background: #FAF8FF;
        border: 1.5px solid #DDD6FE;
        border-radius: 12px;
        padding: 4px 12px;
    }
    .testi-search-box input {
        border: none;
        background: transparent;
        padding: 6px 8px;
        font-size: 13px;
        outline: none;
        color: #1e1b4b;
        font-family: inherit;
        width: 180px;
    }
    .btn-add-testi {
        padding: 10px 20px;
        background: linear-gradient(135deg, #7C3AED, #6B21A8);
        color: white;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(107, 33, 168, 0.25);
        border: none;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-add-testi:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(107, 33, 168, 0.35);
    }

    /* Table Styles */
    .testi-table-wrap {
        background: white;
        border-radius: 20px;
        border: 1.5px solid #DDD6FE;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(107, 33, 168, 0.05);
    }
    .testi-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13.5px;
    }
    .testi-table thead th {
        background: #FAF8FF;
        padding: 16px 20px;
        font-size: 12px;
        font-weight: 700;
        color: #6B21A8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1.5px solid #DDD6FE;
    }
    .testi-table tbody td {
        padding: 16px 20px;
        border-bottom: 1px solid #F1F5F9;
        vertical-align: middle;
        color: #334155;
    }
    .testi-table tbody tr:last-child td {
        border-bottom: none;
    }
    .testi-table tbody tr:hover td {
        background: #FAF9FF;
    }

    .testi-avatar-circle {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 800;
        font-size: 16px;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    .testi-user-cell {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .testi-user-name {
        font-weight: 700;
        color: #1e1b4b;
        font-size: 14px;
        margin-bottom: 2px;
    }
    .testi-user-badge {
        font-size: 11px;
        color: #059669;
        font-weight: 600;
        background: #ECFDF5;
        padding: 2px 8px;
        border-radius: 6px;
        display: inline-block;
    }
    .testi-stars-cell {
        color: #F59E0B;
        font-size: 15px;
        letter-spacing: 1px;
    }
    .testi-comment-text {
        max-width: 320px;
        line-height: 1.5;
        color: #475569;
        font-size: 13px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .testi-tag-pill {
        background: #F3E8FF;
        color: #7C3AED;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 600;
        display: inline-block;
    }
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    .status-active {
        background: #DCFCE7;
        color: #15803D;
    }
    .status-inactive {
        background: #F1F5F9;
        color: #64748B;
    }

    .action-btn-group {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    .btn-edit-sm {
        padding: 6px 12px;
        background: #EDE9FE;
        color: #6B21A8;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        border: 1px solid #DDD6FE;
    }
    .btn-edit-sm:hover {
        background: #DDD6FE;
    }
    .btn-delete-sm {
        padding: 6px 12px;
        background: #FEE2E2;
        color: #DC2626;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid #FECACA;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .btn-delete-sm:hover {
        background: #FCA5A5;
        color: white;
    }
</style>

<div class="testi-page-header">
    <div>
        <h1 class="testi-page-title">💬 Kelola Ulasan Hasil (Testimoni)</h1>
        <p class="testi-page-desc">Kelola ulasan "Cerita Indah Dari Sahabat Gitania" yang tampil di halaman depan (Home).</p>
    </div>
    <a href="{{ route('admin.testimonials.create') }}" class="btn-add-testi">
        <span>+</span> Tambah Ulasan Baru
    </a>
</div>

<!-- Alerts -->
@if(session('success'))
    <div style="background: #F0FDF4; border: 1.5px solid #BBF7D0; color: #166534; padding: 14px 20px; border-radius: 14px; margin-bottom: 22px; font-weight: 600; font-size: 13.5px; display: flex; align-items: center; gap: 10px;">
        <span>✅</span> {{ session('success') }}
    </div>
@endif

<!-- Summary Cards -->
<div class="testi-summary-grid">
    <div class="testi-stat-card">
        <div class="testi-stat-icon" style="background: #EDE9FE; color: #6B21A8;">💬</div>
        <div>
            <div class="testi-stat-val">{{ $totalCount }}</div>
            <div class="testi-stat-lbl">Total Ulasan</div>
        </div>
    </div>
    <div class="testi-stat-card">
        <div class="testi-stat-icon" style="background: #DCFCE7; color: #15803D;">✨</div>
        <div>
            <div class="testi-stat-val">{{ $activeCount }}</div>
            <div class="testi-stat-lbl">Ulasan Aktif (Tampil)</div>
        </div>
    </div>
    <div class="testi-stat-card">
        <div class="testi-stat-icon" style="background: #FEF3C7; color: #D97706;">⭐</div>
        <div>
            <div class="testi-stat-val">{{ $fiveStarCount }}</div>
            <div class="testi-stat-lbl">Bintang 5</div>
        </div>
    </div>
    <div class="testi-stat-card">
        <div class="testi-stat-icon" style="background: #E0F2FE; color: #0284C7;">📊</div>
        <div>
            <div class="testi-stat-val">{{ number_format($averageRating, 1) }} / 5.0</div>
            <div class="testi-stat-lbl">Rata-rata Rating</div>
        </div>
    </div>
</div>

<!-- Filter Bar -->
<div class="testi-filter-card">
    <div class="testi-filter-row">
        <!-- Status Pills -->
        <div class="testi-pill-group">
            <a href="{{ route('admin.testimonials.index', array_merge(request()->except('status', 'page'), ['status' => 'all'])) }}" class="testi-filter-pill {{ $statusFilter == 'all' ? 'active' : '' }}">
                Semua ({{ $totalCount }})
            </a>
            <a href="{{ route('admin.testimonials.index', array_merge(request()->except('status', 'page'), ['status' => 'active'])) }}" class="testi-filter-pill {{ $statusFilter == 'active' ? 'active' : '' }}">
                🟢 Aktif ({{ $activeCount }})
            </a>
            <a href="{{ route('admin.testimonials.index', array_merge(request()->except('status', 'page'), ['status' => 'inactive'])) }}" class="testi-filter-pill {{ $statusFilter == 'inactive' ? 'active' : '' }}">
                ⚪ Nonaktif ({{ $totalCount - $activeCount }})
            </a>
        </div>

        <!-- Rating & Search Filters -->
        <div class="testi-actions-right">
            <form action="{{ route('admin.testimonials.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif

                <select name="rating" onchange="this.form.submit()" style="padding: 8px 14px; border: 1.5px solid #DDD6FE; border-radius: 12px; font-size: 13px; background: #FAF8FF; color: #1e1b4b; font-weight: 600; outline: none; cursor: pointer;">
                    <option value="all" {{ $ratingFilter == 'all' ? 'selected' : '' }}>⭐ Semua Rating</option>
                    <option value="5" {{ $ratingFilter == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Bintang)</option>
                    <option value="4" {{ $ratingFilter == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Bintang)</option>
                    <option value="3" {{ $ratingFilter == '3' ? 'selected' : '' }}>⭐⭐⭐ (3 Bintang)</option>
                </select>

                <div class="testi-search-box">
                    <span>🔍</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / produk...">
                </div>

                @if(request('search') || request('rating') != 'all')
                    <a href="{{ route('admin.testimonials.index') }}" style="font-size: 12px; color: #DC2626; text-decoration: none; font-weight: 600; padding: 6px 10px;">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>
</div>

<!-- Table Data -->
<div class="testi-table-wrap">
    <table class="testi-table">
        <thead>
            <tr>
                <th style="width: 60px; text-align: center;">Urutan</th>
                <th>Pelanggan</th>
                <th style="width: 130px;">Rating</th>
                <th>Isi Cerita / Ulasan</th>
                <th>Tag Produk / Treatment</th>
                <th style="width: 120px; text-align: center;">Status Tampil</th>
                <th style="width: 150px; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($testimonials as $testi)
            <tr>
                <td style="text-align: center; font-weight: 700; color: #7C3AED;">
                    #{{ $testi->order_index ?? $loop->iteration }}
                </td>
                <td>
                    <div class="testi-user-cell">
                        <div class="testi-avatar-circle" style="background: {{ $testi->avatar_gradient ?? 'linear-gradient(135deg, #7C3AED, #A855F7)' }};">
                            {{ $testi->initial }}
                        </div>
                        <div>
                            <div class="testi-user-name">{{ $testi->name }}</div>
                            @if($testi->badge)
                                <span class="testi-user-badge">✓ {{ $testi->badge }}</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td>
                    <div class="testi-stars-cell">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $testi->rating)
                                ★
                            @else
                                <span style="color: #CBD5E1;">★</span>
                            @endif
                        @endfor
                        <span style="font-size: 12px; color: #64748B; font-weight: 600; margin-left: 4px;">({{ $testi->rating }}.0)</span>
                    </div>
                </td>
                <td>
                    <div class="testi-comment-text" title="{{ $testi->comment }}">
                        "{{ $testi->comment }}"
                    </div>
                </td>
                <td>
                    @if($testi->product_tag)
                        <span class="testi-tag-pill">{{ $testi->product_tag }}</span>
                    @else
                        <span style="color: #94A3B8; font-size: 12px;">-</span>
                    @endif
                </td>
                <td style="text-align: center;">
                    <form action="{{ route('admin.testimonials.toggleActive', $testi->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="status-badge {{ $testi->is_active ? 'status-active' : 'status-inactive' }}" title="Klik untuk mengubah status">
                            {{ $testi->is_active ? '● Aktif' : '○ Nonaktif' }}
                        </button>
                    </form>
                </td>
                <td style="text-align: center;">
                    <div class="action-btn-group" style="justify-content: center;">
                        <a href="{{ route('admin.testimonials.edit', $testi->id) }}" class="btn-edit-sm">
                            ✏️ Edit
                        </a>
                        <form action="{{ route('admin.testimonials.destroy', $testi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan dari {{ $testi->name }}?')" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete-sm">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 40px; color: #64748B;">
                    <div style="font-size: 32px; margin-bottom: 10px;">🔍</div>
                    <div style="font-weight: 600; font-size: 15px; color: #1E1B4B; margin-bottom: 6px;">Tidak ada ulasan ditemukan</div>
                    <p style="font-size: 13px; margin: 0 0 16px 0;">Coba ubah filter atau tambahkan ulasan baru untuk ditampilkan di Home.</p>
                    <a href="{{ route('admin.testimonials.create') }}" class="btn-add-testi" style="display: inline-flex;">
                        + Tambah Ulasan Baru
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div style="margin-top: 24px; display: flex; justify-content: flex-end;">
    {{ $testimonials->links() }}
</div>

@endsection
