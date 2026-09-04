<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Menampilkan form ulasan untuk pesanan tertentu
    public function create(Order $order)
    {
        // Pastikan pesanan benar-benar milik user dan statusnya sudah completed
        if ($order->status !== 'completed') {
            return redirect()->back()->with('error', 'Pesanan belum selesai.');
        }

        return view('user.reviews.create', compact('order'));
    }

    // Menyimpan ulasan ke database
    public function store(Request $request, Order $order)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'order_id' => $order->id,
            'product_id' => $order->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('profile.index', ['tab' => 'orders'])->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}
