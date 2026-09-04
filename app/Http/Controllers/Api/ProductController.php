<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductVariantResource;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'variants', 'images'])->latest()->paginate(10);
        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        $product->load(['category', 'variants.inventory', 'images']);
        return new ProductResource($product);
    }

    public function categories()
    {
        $categories = Category::withCount('products')->get();
        return CategoryResource::collection($categories);
    }

    public function variants(Product $product)
    {
        $variants = $product->variants()->with('inventory')->get();
        return ProductVariantResource::collection($variants);
    }
}
