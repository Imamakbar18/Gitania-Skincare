<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Penjualan Gitania Skincare</title>
    <style>
        @page {
            margin: 20px 25px;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        body {
            font-size: 10px;
            color: #1e293b;
            background: #ffffff;
        }

        /* ===== HEADER ===== */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            background: #6B21A8;
            color: #ffffff;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .header-table td {
            padding: 16px 20px;
            vertical-align: middle;
        }
        .brand-title {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #ffffff;
        }
        .brand-subtitle {
            font-size: 9px;
            color: #e9d5ff;
            margin-top: 3px;
        }
        .report-title-cell {
            text-align: right;
        }
        .report-badge {
            font-size: 14px;
            font-weight: bold;
            color: #ffffff;
        }
        .report-meta {
            font-size: 9px;
            color: #e9d5ff;
            margin-top: 4px;
        }

        /* ===== SUMMARY STATS ===== */
        .stats-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
            margin-bottom: 15px;
        }
        .stat-card {
            background: #F5F3FF;
            border: 1px solid #DDD6FE;
            border-radius: 6px;
            padding: 10px 8px;
            text-align: center;
        }
        .stat-label {
            font-size: 8px;
            text-transform: uppercase;
            color: #6B21A8;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .stat-val {
            font-size: 13px;
            font-weight: bold;
            color: #1e1b4b;
        }
        .stat-val.purple { color: #6B21A8; }
        .stat-val.green { color: #15803D; }
        .stat-val.orange { color: #C2410C; }

        /* ===== MAIN DATA TABLE ===== */
        .section-heading {
            font-size: 11px;
            font-weight: bold;
            color: #6B21A8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            border-bottom: 1.5px solid #DDD6FE;
            padding-bottom: 4px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .data-table th {
            background: #6B21A8;
            color: #ffffff;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 7px 8px;
            text-align: left;
            border: 1px solid #581C87;
        }
        .data-table td {
            padding: 6px 8px;
            font-size: 9px;
            border-bottom: 1px solid #EDE9FE;
            border-left: 1px solid #F1F5F9;
            border-right: 1px solid #F1F5F9;
            vertical-align: middle;
        }
        .data-table tr:nth-child(even) {
            background: #FAF8FF;
        }
        .data-table tr:nth-child(odd) {
            background: #ffffff;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-mono { font-family: monospace; font-size: 8.5px; color: #6B21A8; font-weight: bold; }
        .price-col { font-weight: bold; color: #6B21A8; }

        /* BADGES */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-completed { background: #DCFCE7; color: #166534; }
        .badge-paid      { background: #DBEAFE; color: #1E40AF; }
        .badge-pending   { background: #FEF3C7; color: #92400E; }
        .badge-cancelled { background: #FEE2E2; color: #991B1B; }

        /* TOTAL FOOTER ROW */
        .total-row td {
            background: #F5F3FF;
            font-weight: bold;
            font-size: 9.5px;
            border-top: 2px solid #6B21A8;
            border-bottom: 2px solid #6B21A8;
            color: #1e1b4b;
        }

        /* ===== FOOTER NOTE ===== */
        .footer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border-top: 1px solid #E2E8F0;
            padding-top: 6px;
        }
        .footer-table td {
            font-size: 8px;
            color: #94A3B8;
        }
    </style>
</head>
<body>

    <!-- Header Table -->
    <table class="header-table">
        <tr>
            <td style="width: 55%;">
                <div class="brand-title">GITANIA SKINCARE</div>
                <div class="brand-subtitle">Clinical Skincare & Official Store Management</div>
            </td>
            <td class="report-title-cell" style="width: 45%;">
                <div class="report-badge">REKAP TRANSAKSI PENJUALAN</div>
                <div class="report-meta" style="font-weight: bold; color: #ffffff;">Periode: {{ $periodLabel ?? 'Semua Waktu' }}</div>
                <div class="report-meta" style="color: #e9d5ff;">Status: {{ $statusLabel ?? 'Semua Status' }}</div>
                <div class="report-meta">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</div>
            </td>
        </tr>
    </table>

    <!-- Stats Summary Table -->
    <table class="stats-table">
        <tr>
            <td class="stat-card" style="width: 25%;">
                <div class="stat-label">Total Transaksi</div>
                <div class="stat-val purple">{{ $orders->count() }} Pesanan</div>
            </td>
            <td class="stat-card" style="width: 30%;">
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-val purple">Rp{{ number_format($orders->sum('total_amount'), 0, ',', '.') }}</div>
            </td>
            <td class="stat-card" style="width: 22%;">
                <div class="stat-label">Pesanan Selesai</div>
                <div class="stat-val green">{{ $orders->whereIn('status', ['completed', 'paid'])->count() }}</div>
            </td>
            <td class="stat-card" style="width: 23%;">
                <div class="stat-label">Menunggu / Pending</div>
                <div class="stat-val orange">{{ $orders->whereIn('status', ['pending', 'menunggu pembayaran'])->count() }}</div>
            </td>
        </tr>
    </table>

    <!-- Section Heading -->
    <div class="section-heading">Detail Riwayat Transaksi — Periode: {{ $periodLabel ?? 'Semua Waktu' }} • Status: {{ $statusLabel ?? 'Semua Status' }} ({{ $orders->count() }} Data)</div>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 24px;" class="text-center">No</th>
                <th style="width: 110px;">ID Invoice</th>
                <th>Nama Pelanggan</th>
                <th style="width: 85px;">No. Telepon</th>
                <th style="width: 85px;" class="text-right">Total Harga</th>
                <th style="width: 70px;" class="text-center">Status</th>
                <th style="width: 65px;" class="text-center">Sumber</th>
                <th style="width: 95px;" class="text-center">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $order)
            <tr>
                <td class="text-center" style="color: #64748b;">{{ $index + 1 }}</td>
                <td class="font-mono">{{ $order->invoice_number }}</td>
                <td style="font-weight: 600; color: #1e293b;">{{ $order->customer_name }}</td>
                <td style="color: #475569;">{{ $order->customer_phone }}</td>
                <td class="text-right price-col">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                <td class="text-center">
                    @php
                        $st = strtolower($order->status);
                        $badgeClass = match($st) {
                            'completed' => 'badge-completed',
                            'paid'      => 'badge-paid',
                            'pending'   => 'badge-pending',
                            'cancelled' => 'badge-cancelled',
                            default     => 'badge-pending',
                        };
                        $badgeText = match($st) {
                            'completed' => 'Selesai',
                            'paid'      => 'Dibayar',
                            'pending'   => 'Pending',
                            'cancelled' => 'Batal',
                            default     => ucfirst($order->status),
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                </td>
                <td class="text-center" style="color: #475569; text-transform: capitalize;">{{ $order->marketplace_source ?? 'Website' }}</td>
                <td class="text-center" style="color: #64748b; font-size: 8px;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center" style="padding: 30px; color: #64748b;">
                    Belum ada riwayat data transaksi yang tersedia.
                </td>
            </tr>
            @endforelse

            @if($orders->count() > 0)
            <tr class="total-row">
                <td colspan="4" class="text-right" style="padding: 8px 10px;">TOTAL KESELURUHAN:</td>
                <td class="text-right price-col" style="padding: 8px 10px;">Rp{{ number_format($orders->sum('total_amount'), 0, ',', '.') }}</td>
                <td colspan="3"></td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- Footer Table -->
    <table class="footer-table">
        <tr>
            <td style="width: 70%;">
                Dokumen ini digenerate secara otomatis oleh Sistem Administrasi Gitania Skincare.
            </td>
            <td style="width: 30%; text-align: right;">
                Halaman 1 / 1
            </td>
        </tr>
    </table>

</body>
</html>
