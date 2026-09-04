@extends('layouts.admin')

@section('title', 'Admin Dashboard - Gitania Skincare')

@section('content')
<!-- Include Chart.js CDN untuk Grafik -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<!-- WIDGET PERINGATAN STOK MENIPIS (LOW STOCK ALERT) -->
<div style="background: #fffbeb; border: 1px solid #fef3c7; border-radius: 16px; padding: 18px 20px; margin-bottom: 25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 18px;">⚠️</span>
            <h3 style="font-size: 14px; font-weight: 700; color: #92400e; margin: 0;">Peringatan Stok Produk Menipis</h3>
        </div>
        <span style="background: #fef3c7; color: #b45309; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">
            {{ count($lowStockProducts ?? []) }} Item Terpantau
        </span>
    </div>

    @if(isset($lowStockProducts) && count($lowStockProducts) > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 10px; margin-top: 12px;">
            @foreach($lowStockProducts as $item)
                <div style="background: white; padding: 10px 14px; border-radius: 10px; border: 1px solid #fde68a; display: flex; justify-content: space-between; align-items: center; gap: 8px;">
                    <div style="min-width: 0;">
                        <p style="font-size: 13px; font-weight: 600; color: #1e293b; margin: 0 0 2px 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item->name }}</p>
                        <p style="font-size: 11px; color: #dc2626; margin: 0; font-weight: 500;">Status: Perlu Pengecekan</p>
                    </div>
                    <a href="{{ route('admin.products.index') }}" style="background: #f3e8ff; color: #5a2e88; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; text-decoration: none; flex-shrink: 0;">Cek</a>
                </div>
            @endforeach
        </div>
    @else
        <p style="font-size: 13px; color: #78350f; margin: 0;">Bagus! Semua produk skincare saat ini terpantau aman dan terkontrol di sistem.</p>
    @endif
</div>

<!-- 3 Kartu Statistik Atas Responsif -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 25px;">

    <!-- Total Pemesanan -->
    <div class="admin-card" style="margin-bottom: 0;">
        <span style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Pemesanan</span>
        <h3 style="font-size: 24px; color: #1e293b; margin: 8px 0; font-weight: 800; font-family: 'Poppins', sans-serif;">{{ $totalPesanan ?? 0 }}</h3>
        <span style="font-size: 12px; color: #10b981; font-weight: 600;">+ Realtime Database</span>
    </div>

    <!-- Pemesanan Berhasil -->
    <div class="admin-card" style="margin-bottom: 0;">
        <span style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Pemesanan Berhasil</span>
        <h3 style="font-size: 24px; color: #1e293b; margin: 8px 0; font-weight: 800; font-family: 'Poppins', sans-serif;">{{ $persentasePemesanan ?? 0 }}%</h3>
        <span style="font-size: 12px; color: #0284c7; font-weight: 600;">Status Completed</span>
    </div>

    <!-- Total Pendapatan -->
    <div class="admin-card" style="margin-bottom: 0;">
        <span style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Pendapatan</span>
        <h3 style="font-size: 22px; color: var(--admin-purple); margin: 8px 0; font-weight: 800; font-family: 'Poppins', sans-serif;">IDR {{ number_format($totalPenjualan ?? 0, 0, ',', '.') }}</h3>
        <span style="font-size: 12px; color: #8b5cf6; font-weight: 600;">Akumulasi Keseluruhan</span>
    </div>
</div>

<!-- Bagian Grafik (Statistik Bulanan & Mingguan) Responsif -->
<div class="admin-dashboard-charts">

    <!-- Grafik 1: Pemesanan Bulanan (Donut) -->
    <div class="admin-card" style="margin-bottom: 0; text-align: center; display: flex; flex-direction: column; justify-content: space-between;">
        <p style="font-size: 13px; color: #64748b; font-weight: 600; text-align: left; margin: 0 0 10px 0;">Statistik<br><strong style="font-size: 15px; color: #1e293b;">Pemesanan Bulanan</strong></p>
        <div style="position: relative; width: 130px; height: 130px; margin: 15px auto;">
            <canvas id="pemesananChart"></canvas>
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 18px; font-weight: 800; color: #1e293b;">
                {{ $persentasePemesanan ?? 0 }}%
            </div>
        </div>
        <p style="font-size: 12px; color: #64748b; margin: 10px 0 0 0;">Total Pemesanan<br><strong style="color: #1e293b; font-size: 14px;">{{ $totalPesanan ?? 0 }} Orders</strong></p>
    </div>

    <!-- Grafik 2: Pendapatan Bulanan (Donut) -->
    <div class="admin-card" style="margin-bottom: 0; text-align: center; display: flex; flex-direction: column; justify-content: space-between;">
        <p style="font-size: 13px; color: #64748b; font-weight: 600; text-align: left; margin: 0 0 10px 0;">Statistik<br><strong style="font-size: 15px; color: #1e293b;">Pendapatan Bulanan</strong></p>
        <div style="position: relative; width: 130px; height: 130px; margin: 15px auto;">
            <canvas id="pendapatanChart"></canvas>
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 18px; font-weight: 800; color: #1e293b;">
                {{ $persentasePendapatan ?? 0 }}%
            </div>
        </div>
        <p style="font-size: 12px; color: #64748b; margin: 10px 0 0 0;">Pendapatan Bulan Ini<br><strong style="color: #1e293b; font-size: 14px;">IDR {{ number_format($pendapatanBulanan ?? 0, 0, ',', '.') }}</strong></p>
    </div>

    <!-- Grafik 3: Pendapatan Mingguan (Line Chart) -->
    <div class="admin-card" style="margin-bottom: 0; display: flex; flex-direction: column;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 8px;">
            <div>
                <p style="font-size: 12px; color: #64748b; font-weight: 600; margin: 0;">Statistik</p>
                <h3 style="font-size: 15px; color: #1e293b; margin: 0; font-weight: 700;">Pendapatan Mingguan</h3>
            </div>
            <div style="font-size: 11px; display: flex; gap: 12px;">
                <span style="color: #0ea5e9; font-weight: 600;">● Minggu Ini</span>
                <span style="color: #eab308; font-weight: 600;">● Minggu Lalu</span>
            </div>
        </div>
        <div style="position: relative; height: 180px; flex: 1; min-height: 160px;">
            <canvas id="weeklyEarningsChart"></canvas>
        </div>
    </div>

</div>

<!-- Tabel Pesanan Terbaru Responsif -->
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 10px;">
        <h3 style="font-size: 16px; color: #1e293b; margin: 0; font-weight: 700;">Pesanan Terbaru Masuk</h3>
        <a href="{{ route('admin.orders.index') }}" style="font-size: 13px; color: var(--admin-purple); text-decoration: none; font-weight: 600;">Lihat Semua →</a>
    </div>

    <div class="admin-table-container">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; min-width: 600px;">
            <thead>
                <tr style="background: #f8fafc; color: #475569; text-align: left; border-bottom: 1px solid #f1f5f9;">
                    <th style="padding: 12px 14px; font-weight: 600;">No. Invoice</th>
                    <th style="padding: 12px 14px; font-weight: 600;">Nama Pelanggan</th>
                    <th style="padding: 12px 14px; font-weight: 600;">Total Harga</th>
                    <th style="padding: 12px 14px; font-weight: 600;">Status</th>
                    <th style="padding: 12px 14px; font-weight: 600;">Tanggal Pesan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestOrders ?? [] as $order)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px 14px; font-weight: 600; color: var(--admin-purple);">{{ $order->invoice_number }}</td>
                    <td style="padding: 12px 14px; color: #334155;">{{ $order->customer_name }}</td>
                    <td style="padding: 12px 14px; font-weight: 700; color: #1e293b;">IDR {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td style="padding: 12px 14px;">
                        @php
                            $statusColors = [
                                'pending' => ['bg' => '#fef3c7', 'text' => '#d97706'],
                                'paid' => ['bg' => '#dbeafe', 'text' => '#1d4ed8'],
                                'packed' => ['bg' => '#fae8ff', 'text' => '#c084fc'],
                                'shipping' => ['bg' => '#e0f2fe', 'text' => '#0284c7'],
                                'completed' => ['bg' => '#dcfce7', 'text' => '#16a34a'],
                                'cancelled' => ['bg' => '#fee2e2', 'text' => '#dc2626'],
                            ];
                            $sc = $statusColors[$order->status] ?? ['bg' => '#f1f5f9', 'text' => '#475569'];
                        @endphp
                        <span style="background: {{ $sc['bg'] }}; color: {{ $sc['text'] }}; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block;">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td style="padding: 12px 14px; color: #64748b; font-size: 12px;">{{ $order->created_at->format('d M Y, H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">
                        <div style="font-size: 32px; margin-bottom: 10px;">🛍️</div>
                        Belum ada pesanan masuk saat ini di database.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Script untuk Inisialisasi Chart.js -->
<script>
    // 1. Donut Chart Pemesanan Bulanan
    const ctxPemesanan = document.getElementById('pemesananChart').getContext('2d');
    new Chart(ctxPemesanan, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [{{ $persentasePemesanan ?? 0 }}, {{ max(0, 100 - ($persentasePemesanan ?? 0)) }}],
                backgroundColor: ['#0ea5e9', '#f1f5f9'],
                borderWidth: 0
            }]
        },
        options: { cutout: '75%', responsive: true, maintainAspectRatio: false }
    });

    // 2. Donut Chart Pendapatan Bulanan
    const ctxPendapatan = document.getElementById('pendapatanChart').getContext('2d');
    new Chart(ctxPendapatan, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [{{ $persentasePendapatan ?? 0 }}, {{ max(0, 100 - ($persentasePendapatan ?? 0)) }}],
                backgroundColor: ['#eab308', '#f1f5f9'],
                borderWidth: 0
            }]
        },
        options: { cutout: '75%', responsive: true, maintainAspectRatio: false }
    });

    // 3. Line Chart Pendapatan Mingguan
    const ctxWeekly = document.getElementById('weeklyEarningsChart').getContext('2d');
    new Chart(ctxWeekly, {
        type: 'line',
        data: {
            labels: ['Ming', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
            datasets: [
                {
                    label: 'Minggu Ini',
                    data: {!! json_encode($thisWeekEarnings ?? [0,0,0,0,0,0,0]) !!},
                    borderColor: '#0ea5e9',
                    backgroundColor: 'rgba(14, 165, 233, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Minggu Lalu',
                    data: {!! json_encode($lastWeekEarnings ?? [0,0,0,0,0,0,0]) !!},
                    borderColor: '#eab308',
                    backgroundColor: 'rgba(234, 179, 8, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 } } },
                x: { grid: { display: false }, ticks: { font: { size: 10 } } }
            }
        }
    });
</script>
@endsection
