<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang belanja.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    /**
     * Ambil data keranjang untuk AJAX (Drawer).
     */
    public function getCartData()
    {
        $cart = session()->get('cart', []);
        $html = view('partials.cart-drawer-content', compact('cart'))->render();

        return response()->json([
            'html' => $html,
            'count' => count($cart)
        ]);
    }

    /**
     * Tambah produk ke keranjang via AJAX.
     */
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);

        $product = Product::find($productId);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.'
            ], 404);
        }

        $cart = session()->get('cart', []);

        // Ambil gambar utama produk
        $img = $product->images->where('is_primary', 1)->first() ?? $product->images->first();
        $imagePath = $img ? asset('storage/' . $img->image_path) : asset('images/default.png');

        // Jika produk sudah ada di keranjang, tambahkan jumlahnya
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // Jika belum ada, masukkan data produk baru ke session cart
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $imagePath
            ];
        }

        session()->put('cart', $cart);

        // Render ulang HTML bagian keranjang sidebar (drawer)
        $html = view('partials.cart-drawer-content', compact('cart'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'html' => $html,
            'count' => count($cart)
        ]);
    }

    /**
     * Update jumlah produk di keranjang.
     */
    public function update(Request $request)
    {
        $productId = $request->input('product_id');
        $change = $request->input('change', 0);
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $change;

            if ($cart[$productId]['quantity'] <= 0) {
                unset($cart[$productId]);
            }

            session()->put('cart', $cart);
        }

        $html = view('partials.cart-drawer-content', compact('cart'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => count($cart)
        ]);
    }

    /**
     * Hapus item dari keranjang via AJAX.
     */
    public function removeAjax(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        $html = view('partials.cart-drawer-content', compact('cart'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => count($cart)
        ]);
    }

    /**
     * Hapus item dari keranjang via URL (Non-AJAX).
     */
    public function remove(mixed $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }
}
