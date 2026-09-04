<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPenjualan = Order::sum('total_amount');
        $totalPesanan = Order::count();
        $totalProduk = Product::count();

        $successfulOrders = Order::where('status', 'completed')->count();
        $successRate = $totalPesanan > 0 ? round(($successfulOrders / $totalPesanan) * 100) : 0;

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $pendapatanBulanan = Order::whereMonth('created_at', $currentMonth)
                            ->whereYear('created_at', $currentYear)
                            ->sum('total_amount');

        $pendapatanBulanLalu = Order::whereMonth('created_at', Carbon::now()->subMonth()->month)
                               ->sum('total_amount');

        $persentasePemesanan = min($successRate, 100);
        $persentasePendapatan = $pendapatanBulanLalu > 0 ? min(round(($pendapatanBulanan / $pendapatanBulanLalu) * 100), 100) : ($pendapatanBulanan > 0 ? 100 : 0);

        $thisWeekEarnings = [];
        $lastWeekEarnings = [];

        for ($i = 0; $i < 7; $i++) {
            $dayThisWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY)->addDays($i);
            $dayLastWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY)->subWeek()->addDays($i);

            $thisWeekEarnings[] = Order::whereDate('created_at', $dayThisWeek->format('Y-m-d'))->sum('total_amount') / 1000;
            $lastWeekEarnings[] = Order::whereDate('created_at', $dayLastWeek->format('Y-m-d'))->sum('total_amount') / 1000;
        }

        // --- DIPERBAIKI: Menggunakan collection kosong agar tidak error kolom stock ---
        $lowStockProducts = collect();

        $latestOrders = Order::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPenjualan',
            'totalPesanan',
            'totalProduk',
            'pendapatanBulanan',
            'persentasePemesanan',
            'persentasePendapatan',
            'thisWeekEarnings',
            'lastWeekEarnings',
            'lowStockProducts',
            'latestOrders'
        ));
    }
}
