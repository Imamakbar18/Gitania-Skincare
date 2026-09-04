<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Media;
use App\Models\MediaPost;
use App\Models\Banner;
use App\Models\BeforeAfterCase;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Halaman Home / Dashboard Depan
    public function home(Request $request)
    {
        $products = Product::with(['category', 'variants', 'images'])->latest()->take(8)->get();
        $categories = Category::all();
        $banners = Banner::where('is_active', true)->orderBy('order', 'asc')->get();
        $beforeAfterCases = BeforeAfterCase::where('is_active', true)->orderBy('order', 'asc')->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('order_index', 'asc')->orderBy('created_at', 'desc')->get();

        return view('welcome', compact('products', 'categories', 'banners', 'beforeAfterCases', 'testimonials'));
    }

    // Halaman Our Products / Katalog Lengkap
    public function index(Request $request)
    {
        $query = Product::with(['category', 'variants', 'images']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->get('filter') == 'new') {
            $query->latest();
        } elseif ($request->get('filter') == 'best') {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('shop.index', compact('products', 'categories'));
    }

    // Halaman Detail Produk
    public function show($slug)
    {
        $product = Product::with(['category', 'variants', 'images'])->where('slug', $slug)->firstOrFail();
        return view('shop.show', compact('product'));
    }

    // Halaman About Us
    public function about()
    {
        return view('about');
    }

    // Halaman Media Utama (Menampilkan pilihan topik News & Gitania Spotlight)
    public function mediaIndex()
    {
        return view('media.index');
    }

    // Halaman List Berdasarkan Kategori (News / Spotlight)
    public function mediaCategory($category)
    {
        if (!in_array($category, ['news', 'spotlight'])) {
            abort(404);
        }
        $posts = MediaPost::where('category', $category)->latest()->paginate(9);
        return view('media.category', compact('posts', 'category'));
    }

    // Halaman Detail Artikel
    public function mediaShow($slug)
    {
        $post = MediaPost::where('slug', $slug)->firstOrFail();
        return view('media.show', compact('post'));
    }

    // Halaman Media Lama (Opsional / Tetap dipertahankan jika masih dibutuhkan)
    public function media()
    {
        $mediaItems = Media::latest()->get();
        return view('media', compact('mediaItems'));
    }

    // Halaman Contact Us
    public function contact()
    {
        return view('contact');
    }
}
