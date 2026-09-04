<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = Product::with(['category', 'variants', 'images'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        if ($request->hasFile('images')) {
            $data['images'] = $request->file('images');
        }

        $this->productService->createProduct($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk baru beserta varian, stok, dan fotonya berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'variants', 'images']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load(['category', 'variants', 'images']);
        return view('admin.products.edit', compact('categories', 'product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        if ($request->hasFile('images')) {
            $data['images'] = $request->file('images');
        }

        $this->productService->updateProduct($product, $data);

        return redirect()->route('admin.products.index')->with('success', 'Produk dan stok berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
