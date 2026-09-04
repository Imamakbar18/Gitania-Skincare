@extends('layouts.admin')

@section('title', 'Laporan & Ekspor Penjualan - Gitania Skincare')

@section('content')
<!-- Page Header -->
<div style="margin-bottom: 24px;">
    <h2 style="color: #1e293b; font-size: 20px; font-weight: 700; margin: 0 0 4px 0; font-family: 'Poppins', sans-serif;">📊 Laporan &amp; Ekspor Data Penjualan</h2>
    <p style="color: #64748b; font-size: 13px; margin: 0;">Filter rekapitulasi data penjualan berdasarkan periode waktu dan status pesanan, lalu unduh dalam format PDF atau CSV.</p>
</div>

<!-- ========================================================
     PANEL FILTER UTAMA: PERIODE WAKTU & STATUS PESANAN
     ======================================================== -->
<div class="admin-card" style="margin-bottom: 24px; border: 1.5px solid #DDD6FE; background: #ffffff; padding: 22px;">
    
    <!-- Header & Indikator Filter Aktif -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid #EDE9FE;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 42px; height: 42px; background: #F5F3FF; color: #7C3AED; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 1.5px solid #DDD6FE;">
                🔍
            </div>
            <div>
                <h3 style="font-size: 15px; font-weight: 700; color: #1e1b4b; margin: 0; font-family: 'Poppins', sans-serif;">Filter Laporan Penjualan</h3>
                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                    Periode: <strong style="color: #7C3AED;">{{ $periodLabel }}</strong> • Status: <strong style="color: #7C3AED;">{{ $statusLabel }}</strong>
                </div>
            </div>
        </div>

        @if(request('filter') || request('status') || request('start_date'))
            <a href="{{ route('admin.reports.index') }}"
               style="font-size: 12px; color: #DC2626; text-decoration: none; font-weight: 600; padding: 7px 14px; border-radius: 8px; background: #FEF2F2; border: 1px solid #FECACA; display: inline-flex; align-items: center; gap: 4px;">
                ✕ Reset Semua Filter
            </a>
        @endif
    </div>

    <!-- 1. BARIS FILTER PERIODE WAKTU -->
    <div style="margin-bottom: 18px;">
        <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">
            📅 1. Pilih Periode Waktu:
        </label>
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <a href="{{ route('admin.reports.index', array_merge(request()->except(['filter', 'start_date', 'end_date', 'page']), ['filter' => 'all'])) }}"
               style="padding: 7px 15px; border-radius: 999px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;
                      {{ $activeFilter === 'all' && !request('start_date') ? 'background: #7C3AED; color: white; box-shadow: 0 4px 12px rgba(124,58,237,0.25);' : 'background: #FAF8FF; color: #554a6b; border: 1.5px solid #DDD6FE;' }}">
                Semua Waktu
            </a>
            <a href="{{ route('admin.reports.index', array_merge(request()->except(['filter', 'start_date', 'end_date', 'page']), ['filter' => 'today'])) }}"
               style="padding: 7px 15px; border-radius: 999px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;
                      {{ $activeFilter === 'today' ? 'background: #7C3AED; color: white; box-shadow: 0 4px 12px rgba(124,58,237,0.25);' : 'background: #FAF8FF; color: #554a6b; border: 1.5px solid #DDD6FE;' }}">
                ⚡ Hari Ini (Harian)
            </a>
            <a href="{{ route('admin.reports.index', array_merge(request()->except(['filter', 'start_date', 'end_date', 'page']), ['filter' => 'week'])) }}"
               style="padding: 7px 15px; border-radius: 999px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;
                      {{ $activeFilter === 'week' ? 'background: #7C3AED; color: white; box-shadow: 0 4px 12px rgba(124,58,237,0.25);' : 'background: #FAF8FF; color: #554a6b; border: 1.5px solid #DDD6FE;' }}">
                📆 7 Hari (Mingguan)
            </a>
            <a href="{{ route('admin.reports.index', array_merge(request()->except(['filter', 'start_date', 'end_date', 'page']), ['filter' => 'month'])) }}"
               style="padding: 7px 15px; border-radius: 999px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;
                      {{ $activeFilter === 'month' ? 'background: #7C3AED; color: white; box-shadow: 0 4px 12px rgba(124,58,237,0.25);' : 'background: #FAF8FF; color: #554a6b; border: 1.5px solid #DDD6FE;' }}">
                🗓️ Bulan Ini (Bulanan)
            </a>
        </div>
    </div>

    <!-- 2. BARIS FILTER STATUS PESANAN (FITUR BARU) -->
    <div style="margin-bottom: 18px;">
        <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">
            🏷️ 2. Pilih Status Pesanan:
        </label>
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <!-- Semua Status -->
            <a href="{{ route('admin.reports.index', array_merge(request()->except(['status', 'page']), ['status' => 'all'])) }}"
               style="padding: 7px 14px; border-radius: 999px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;
                      {{ $activeStatus === 'all' ? 'background: #6B21A8; color: white; box-shadow: 0 4px 12px rgba(107,33,168,0.25);' : 'background: #FAF8FF; color: #475569; border: 1.5px solid #DDD6FE;' }}">
                🌐 Semua Status
            </a>
            <!-- Selesai -->
            <a href="{{ route('admin.reports.index', array_merge(request()->except(['status', 'page']), ['status' => 'completed'])) }}"
               style="padding: 7px 14px; border-radius: 999px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;
                      {{ $activeStatus === 'completed' ? 'background: #16A34A; color: white; box-shadow: 0 4px 12px rgba(22,163,74,0.25);' : 'background: #F0FDF4; color: #166534; border: 1.5px solid #BBF7D0;' }}">
                ✅ Selesai (Completed)
            </a>
            <!-- Sudah Bayar -->
            <a href="{{ route('admin.reports.index', array_merge(request()->except(['status', 'page']), ['status' => 'paid'])) }}"
               style="padding: 7px 14px; border-radius: 999px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;
                      {{ $activeStatus === 'paid' ? 'background: #2563EB; color: white; box-shadow: 0 4px 12px rgba(37,99,235,0.25);' : 'background: #EFF6FF; color: #1E40AF; border: 1.5px solid #BFDBFE;' }}">
                💳 Sudah Bayar (Paid)
            </a>
            <!-- Menunggu -->
            <a href="{{ route('admin.reports.index', array_merge(request()->except(['status', 'page']), ['status' => 'pending'])) }}"
               style="padding: 7px 14px; border-radius: 999px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;
                      {{ $activeStatus === 'pending' ? 'background: #D97706; color: white; box-shadow: 0 4px 12px rgba(217,119,6,0.25);' : 'background: #FFFBEB; color: #92400E; border: 1.5px solid #FDE68A;' }}">
                ⏳ Menunggu Pembayaran (Pending)
            </a>
            <!-- Dibatalkan -->
            <a href="{{ route('admin.reports.index', array_merge(request()->except(['status', 'page']), ['status' => 'cancelled'])) }}"
               style="padding: 7px 14px; border-radius: 999px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;
                      {{ $activeStatus === 'cancelled' ? 'background: #DC2626; color: white; box-shadow: 0 4px 12px rgba(220,38,38,0.25);' : 'background: #FEF2F2; color: #991B1B; border: 1.5px solid #FECACA;' }}">
                ❌ Dibatalkan (Cancelled)
            </a>
        </div>
    </div>

    <!-- 3. FORM RENTANG TANGGAL KUSTOM -->
    <form action="{{ route('admin.reports.index') }}" method="GET" style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap; padding-top: 14px; border-top: 1px solid #EDE9FE;">
        <input type="hidden" name="status" value="{{ $activeStatus }}">
        
        <span style="font-size: 12.5px; font-weight: 600; color: #475569;">Atau tentukan tanggal khusus:</span>
        
        <div style="display: flex; align-items: center; gap: 8px;">
            <input type="date" name="start_date" value="{{ $startDate ?? '' }}" required
                   style="padding: 7px 12px; border: 1.5px solid #DDD6FE; border-radius: 8px; font-size: 12.5px; color: #1e1b4b; background: #FAF8FF; outline: none;">
            <span style="font-size: 12px; color: #94a3b8;">s/d</span>
            <input type="date" name="end_date" value="{{ $endDate ?? '' }}" required
                   style="padding: 7px 12px; border: 1.5px solid #DDD6FE; border-radius: 8px; font-size: 12.5px; color: #1e1b4b; background: #FAF8FF; outline: none;">
        </div>

        <button type="submit"
                style="padding: 7px 16px; background: #7C3AED; color: white; border: none; border-radius: 8px; font-size: 12.5px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
            🔍 Terapkan Rentang
        </button>
    </form>
</div>

<!-- ========================================================
     RINGKASAN STATISTIK SESUAI FILTER
     ======================================================== -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div style="background: white; padding: 18px 20px; border-radius: 14px; border: 1.5px solid #DDD6FE; box-shadow: 0 4px 12px rgba(107,33,168,0.04);">
        <div style="font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 700; margin-bottom: 4px;">Total Transaksi Terfilter</div>
        <div style="font-size: 22px; font-weight: 800; color: #6B21A8;">{{ $orders->count() }} <span style="font-size: 13px; font-weight: 500; color: #64748b;">Pesanan</span></div>
    </div>
    <div style="background: white; padding: 18px 20px; border-radius: 14px; border: 1.5px solid #DDD6FE; box-shadow: 0 4px 12px rgba(107,33,168,0.04);">
        <div style="font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 700; margin-bottom: 4px;">Total Omzet / Pendapatan</div>
        <div style="font-size: 22px; font-weight: 800; color: #7C3AED;">Rp{{ number_format($orders->sum('total_amount'), 0, ',', '.') }}</div>
    </div>
    <div style="background: white; padding: 18px 20px; border-radius: 14px; border: 1.5px solid #DDD6FE; box-shadow: 0 4px 12px rgba(107,33,168,0.04);">
        <div style="font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 700; margin-bottom: 4px;">Pesanan Selesai / Lunas</div>
        <div style="font-size: 22px; font-weight: 800; color: #16A34A;">{{ $orders->whereIn('status', ['completed', 'paid'])->count() }} <span style="font-size: 13px; font-weight: 500; color: #64748b;">Pesanan</span></div>
    </div>
    <div style="background: white; padding: 18px 20px; border-radius: 14px; border: 1.5px solid #DDD6FE; box-shadow: 0 4px 12px rgba(107,33,168,0.04);">
        <div style="font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 700; margin-bottom: 4px;">Pesanan Menunggu</div>
        <div style="font-size: 22px; font-weight: 800; color: #EA580C;">{{ $orders->whereIn('status', ['pending', 'menunggu pembayaran'])->count() }} <span style="font-size: 13px; font-weight: 500; color: #64748b;">Pesanan</span></div>
    </div>
</div>

<!-- ========================================================
     TOMBOL UNDUH EKSPOR (PDF & CSV) DENGAN FILTER LENGKAP
     ======================================================== -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 28px;">

    <!-- Card 1: Ekspor PDF -->
    <div class="admin-card" style="margin-bottom: 0; display: flex; flex-direction: column; justify-content: space-between; border: 1.5px solid #DDD6FE; transition: transform 0.2s, box-shadow 0.2s;"
         onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 12px 28px rgba(107,33,168,0.12)'"
         onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'">
        <div>
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #F5F3FF, #EDE9FE); color: #7C3AED; border: 1.5px solid #DDD6FE; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 14px;">
                📄
            </div>
            <h3 style="font-size: 16px; color: #1e293b; font-weight: 700; margin: 0 0 6px 0; font-family: 'Poppins', sans-serif;">Ekspor Rekap Transaksi (PDF)</h3>
            <p style="font-size: 12.5px; color: #64748b; margin: 0 0 16px 0; line-height: 1.5;">
                Unduh PDF untuk periode <strong>{{ $periodLabel }}</strong> dengan status <strong>{{ $statusLabel }}</strong> ({{ $orders->count() }} transaksi).
            </p>
        </div>

        <a href="{{ route('admin.reports.exportPdf', request()->query()) }}" target="_blank"
           style="background: linear-gradient(135deg, #8B5CF6, #7C3AED); color: white; padding: 11px 18px; border-radius: 10px; font-weight: 600; text-decoration: none; font-size: 13px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(124, 58, 237, 0.25); transition: opacity 0.2s;"
           onmouseover="this.style.opacity='0.92'"
           onmouseout="this.style.opacity='1'">
            📑 Unduh PDF ({{ $orders->count() }} Pesanan)
        </a>
    </div>

    <!-- Card 2: Ekspor CSV / Excel -->
    <div class="admin-card" style="margin-bottom: 0; display: flex; flex-direction: column; justify-content: space-between; border: 1.5px solid #DDD6FE; transition: transform 0.2s, box-shadow 0.2s;"
         onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 12px 28px rgba(107,33,168,0.12)'"
         onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'">
        <div>
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #F5F3FF, #EDE9FE); color: #7C3AED; border: 1.5px solid #DDD6FE; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 14px;">
                📊
            </div>
            <h3 style="font-size: 16px; color: #1e293b; font-weight: 700; margin: 0 0 6px 0; font-family: 'Poppins', sans-serif;">Ekspor Rekap Transaksi (CSV)</h3>
            <p style="font-size: 12.5px; color: #64748b; margin: 0 0 16px 0; line-height: 1.5;">
                Unduh CSV/Excel untuk periode <strong>{{ $periodLabel }}</strong> dengan status <strong>{{ $statusLabel }}</strong> ({{ $orders->count() }} transaksi).
            </p>
        </div>

        <a href="{{ route('admin.reports.exportCsv', request()->query()) }}"
           style="background: var(--admin-purple); color: white; padding: 11px 18px; border-radius: 10px; font-weight: 600; text-decoration: none; font-size: 13px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(90, 46, 136, 0.2); transition: opacity 0.2s;"
           onmouseover="this.style.opacity='0.92'"
           onmouseout="this.style.opacity='1'">
            ⬇️ Unduh CSV ({{ $orders->count() }} Pesanan)
        </a>
    </div>

</div>

<!-- ========================================================
     TABEL PREVIEW DATA TRANSAKSI
     ======================================================== -->
<div class="admin-card" style="border: 1px solid #DDD6FE;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
        <h3 style="font-size: 15px; font-weight: 700; color: #1e1b4b; margin: 0; font-family: 'Poppins', sans-serif;">
            📋 Preview Data Pesanan ({{ $orders->count() }} Data Ditemukan)
        </h3>
        <span style="font-size: 12px; color: #64748b;">Menampilkan data sesuai filter periode &amp; status yang dipilih</span>
    </div>

    <div class="admin-table-container">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
                <tr style="background: #F5F3FF; border-bottom: 1.5px solid #DDD6FE; text-align: left;">
                    <th style="padding: 10px 14px; font-weight: 700; color: #6B21A8;">No</th>
                    <th style="padding: 10px 14px; font-weight: 700; color: #6B21A8;">ID Invoice</th>
                    <th style="padding: 10px 14px; font-weight: 700; color: #6B21A8;">Pelanggan</th>
                    <th style="padding: 10px 14px; font-weight: 700; color: #6B21A8;">No. Telepon</th>
                    <th style="padding: 10px 14px; font-weight: 700; color: #6B21A8; text-align: right;">Total Harga</th>
                    <th style="padding: 10px 14px; font-weight: 700; color: #6B21A8; text-align: center;">Status</th>
                    <th style="padding: 10px 14px; font-weight: 700; color: #6B21A8; text-align: center;">Sumber</th>
                    <th style="padding: 10px 14px; font-weight: 700; color: #6B21A8;">Tanggal Pesan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $idx => $order)
                <tr style="border-bottom: 1px solid #EDE9FE; transition: background 0.15s;" onmouseover="this.style.background='#FAF8FF'" onmouseout="this.style.background='white'">
                    <td style="padding: 11px 14px; color: #64748b;">{{ $idx + 1 }}</td>
                    <td style="padding: 11px 14px; font-family: monospace; font-weight: 700; color: #7C3AED;">{{ $order->invoice_number }}</td>
                    <td style="padding: 11px 14px; font-weight: 600; color: #1e1b4b;">{{ $order->customer_name }}</td>
                    <td style="padding: 11px 14px; color: #475569;">{{ $order->customer_phone }}</td>
                    <td style="padding: 11px 14px; text-align: right; font-weight: 700; color: #6B21A8;">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td style="padding: 11px 14px; text-align: center;">
                        @php
                            $st = strtolower($order->status);
                            $badgeBg = match($st) {
                                'completed' => '#DCFCE7',
                                'paid'      => '#DBEAFE',
                                'pending', 'menunggu pembayaran' => '#FEF3C7',
                                'cancelled' => '#FEE2E2',
                                default     => '#FEF3C7',
                            };
                            $badgeColor = match($st) {
                                'completed' => '#166534',
                                'paid'      => '#1E40AF',
                                'pending', 'menunggu pembayaran' => '#92400E',
                                'cancelled' => '#991B1B',
                                default     => '#92400E',
                            };
                            $badgeText = match($st) {
                                'completed' => 'Selesai',
                                'paid'      => 'Dibayar',
                                'pending', 'menunggu pembayaran' => 'Menunggu',
                                'cancelled' => 'Batal',
                                default     => ucfirst($order->status),
                            };
                        @endphp
                        <span style="display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; background: {{ $badgeBg }}; color: {{ $badgeColor }};">
                            {{ $badgeText }}
                        </span>
                    </td>
                    <td style="padding: 11px 14px; text-align: center; text-transform: capitalize; color: #64748b;">
                        {{ $order->marketplace_source ?? 'Website' }}
                    </td>
                    <td style="padding: 11px 14px; color: #64748b; font-size: 12px;">
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding: 40px 20px; text-align: center; color: #8B5CF6;">
                        <div style="font-size: 32px; margin-bottom: 8px;">📭</div>
                        <div style="font-weight: 600; font-size: 14px;">Tidak ada transaksi ditemukan untuk filter ini.</div>
                        <div style="font-size: 12px; color: #94a3b8; margin-top: 4px;">Periode: {{ $periodLabel }} • Status: {{ $statusLabel }}</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
