<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Menghitung statistik dan mengambil data pesanan terbaru secara aman
        $totalPenjualan = class_exists(Order::class) ? Order::sum('total_amount') : 0;
        $totalPesanan = class_exists(Order::class) ? Order::count() : 0;
        $totalProduk = class_exists(Product::class) ? Product::count() : 0;
        $latestOrders = class_exists(Order::class) ? Order::latest()->take(5)->get() : collect();

        return view('admin.dashboard', compact(
            'totalPenjualan',
            'totalPesanan',
            'totalProduk',
            'latestOrders'
        ));
    }
}
