<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Helper untuk mengambil query data pesanan & label periode serta status berdasarkan filter
     */
    private function getFilteredOrders(Request $request)
    {
        $filter    = $request->get('filter', 'all');
        $status    = $request->get('status', 'all');
        $startDate = $request->get('start_date');
        $endDate   = $request->get('end_date');

        $query = Order::latest();
        $periodLabel = 'Semua Waktu';
        $statusLabel = 'Semua Status';

        // 1. Filter Tanggal / Periode
        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end   = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
            $periodLabel = $start->format('d/m/Y') . ' – ' . $end->format('d/m/Y');
            $filter = 'custom';
        } elseif ($filter === 'today') {
            $query->whereDate('created_at', Carbon::today());
            $periodLabel = 'Hari Ini (' . Carbon::today()->translatedFormat('d F Y') . ')';
        } elseif ($filter === 'week') {
            $start = Carbon::now()->subDays(6)->startOfDay();
            $end   = Carbon::now()->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
            $periodLabel = '7 Hari Terakhir (' . $start->format('d M') . ' – ' . $end->format('d M Y') . ')';
        } elseif ($filter === 'month') {
            $query->whereYear('created_at', Carbon::now()->year)
                  ->whereMonth('created_at', Carbon::now()->month);
            $periodLabel = 'Bulan Ini (' . Carbon::now()->translatedFormat('F Y') . ')';
        } elseif ($filter === 'year') {
            $query->whereYear('created_at', Carbon::now()->year);
            $periodLabel = 'Tahun Ini (' . Carbon::now()->year . ')';
        }

        // 2. Filter Status Pesanan
        if ($status === 'completed') {
            $query->where('status', 'completed');
            $statusLabel = 'Selesai (Completed)';
        } elseif ($status === 'paid') {
            $query->where('status', 'paid');
            $statusLabel = 'Sudah Bayar / Lunas (Paid)';
        } elseif ($status === 'pending') {
            $query->whereIn('status', ['pending', 'menunggu pembayaran']);
            $statusLabel = 'Menunggu Pembayaran (Pending)';
        } elseif ($status === 'cancelled') {
            $query->where('status', 'cancelled');
            $statusLabel = 'Dibatalkan (Cancelled)';
        }

        $orders = $query->get();

        return [
            'orders'       => $orders,
            'periodLabel'  => $periodLabel,
            'statusLabel'  => $statusLabel,
            'filter'       => $filter,
            'status'       => $status,
            'startDate'    => $startDate,
            'endDate'      => $endDate,
        ];
    }

    /**
     * Halaman Laporan & Ekspor dengan Preview Data & Filter Periode & Status
     */
    public function index(Request $request)
    {
        $data = $this->getFilteredOrders($request);

        return view('admin.reports.index', [
            'orders'       => $data['orders'],
            'periodLabel'  => $data['periodLabel'],
            'statusLabel'  => $data['statusLabel'],
            'activeFilter' => $data['filter'],
            'activeStatus' => $data['status'],
            'startDate'    => $data['startDate'],
            'endDate'      => $data['endDate'],
        ]);
    }

    /**
     * Export laporan ke format PDF berdasarkan filter periode & status
     */
    public function exportPdf(Request $request)
    {
        $data = $this->getFilteredOrders($request);
        $orders = $data['orders'];
        $periodLabel = $data['periodLabel'];
        $statusLabel = $data['statusLabel'];

        $filterSuffix = match($data['filter']) {
            'today'   => 'harian-' . date('Y-m-d'),
            'week'    => 'mingguan-' . date('Y-m-d'),
            'month'   => 'bulanan-' . date('Y-m'),
            'custom'  => 'custom-' . ($data['startDate'] ?? '') . '-sd-' . ($data['endDate'] ?? ''),
            default   => 'semua-' . date('Y-m-d'),
        };

        if ($data['status'] !== 'all') {
            $filterSuffix .= '-status-' . $data['status'];
        }

        $fileName = 'Laporan-Penjualan-Gitania-' . $filterSuffix . '.pdf';

        $pdf = Pdf::loadView('admin.reports.pdf', compact('orders', 'periodLabel', 'statusLabel'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download($fileName);
    }

    /**
     * Export laporan ke format CSV / Excel berdasarkan filter periode & status
     */
    public function exportCsv(Request $request)
    {
        $data = $this->getFilteredOrders($request);
        $orders = $data['orders'];
        $periodLabel = $data['periodLabel'];
        $statusLabel = $data['statusLabel'];

        $filterSuffix = match($data['filter']) {
            'today'   => 'harian-' . date('Y-m-d'),
            'week'    => 'mingguan-' . date('Y-m-d'),
            'month'   => 'bulanan-' . date('Y-m'),
            'custom'  => 'custom-' . ($data['startDate'] ?? '') . '-sd-' . ($data['endDate'] ?? ''),
            default   => 'semua-' . date('Y-m-d'),
        };

        if ($data['status'] !== 'all') {
            $filterSuffix .= '-status-' . $data['status'];
        }

        $fileName = 'Laporan-Penjualan-Gitania-' . $filterSuffix . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($orders, $periodLabel, $statusLabel) {
            $output = fopen('php://output', 'w');

            // ⚡ UTF-8 BOM — agar terbaca rapi di Microsoft Excel
            fputs($output, "\xEF\xBB\xBF");

            // ── Judul Laporan & Periode ──
            fputcsv($output, ['LAPORAN PENJUALAN GITANIA SKINCARE'], ';');
            fputcsv($output, ['Periode Laporan: ' . $periodLabel], ';');
            fputcsv($output, ['Status Pesanan: ' . $statusLabel], ';');
            fputcsv($output, ['Dicetak pada: ' . now()->translatedFormat('d F Y, H:i') . ' WIB'], ';');
            fputcsv($output, ['Total Transaksi: ' . $orders->count() . ' Pesanan'], ';');
            fputcsv($output, [''], ';'); // baris kosong

            // ── Header Kolom ──
            fputcsv($output, [
                'No',
                'ID Invoice',
                'Nama Pelanggan',
                'No Telepon',
                'Total Harga (Rp)',
                'Status',
                'Marketplace / Sumber',
                'Tanggal Pesan',
            ], ';');

            // ── Baris Data ──
            $no = 1;
            foreach ($orders as $order) {
                fputcsv($output, [
                    $no++,
                    $order->invoice_number,
                    $order->customer_name,
                    "'" . $order->customer_phone,
                    (int) $order->total_amount,
                    ucfirst($order->status),
                    $order->marketplace_source ?? 'website',
                    $order->created_at->format('d/m/Y H:i:s'),
                ], ';');
            }

            // ── Baris Ringkasan Total ──
            fputcsv($output, [''], ';');
            fputcsv($output, [
                '',
                '',
                '',
                'TOTAL PENDAPATAN:',
                (int) $orders->sum('total_amount'),
                '',
                '',
                '',
            ], ';');

            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }
}
