<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductService {
    public function createProduct(array $data): Product {
        return DB::transaction(function () use ($data) {
            $mainImage = $data['image'] ?? null;
            unset($data['image']);

            $galleryImages = $data['images'] ?? [];
            unset($data['images']);

            $variants = $data['variants'] ?? [];
            unset($data['variants']);

            $data['slug'] = Str::slug($data['name']);
            $data['stock'] = $data['stock'] ?? 0;

            $product = Product::create($data);

            $order = 1;

            if ($mainImage) {
                $mainImagePath = $mainImage->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $mainImagePath,
                    'is_primary' => 1,
                    'order' => $order++,
                ]);
            }

            if (!empty($galleryImages)) {
                foreach ($galleryImages as $imgFile) {
                    $galleryPath = $imgFile->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $galleryPath,
                        'is_primary' => 0,
                        'order' => $order++,
                    ]);
                }
            }

            if (!empty($variants)) {
                foreach ($variants as $variant) {
                    $product->variants()->create($variant);
                }
            }

            return $product;
        });
    }

    public function updateProduct(Product $product, array $data): Product {
        return DB::transaction(function () use ($product, $data) {
            $mainImage = $data['image'] ?? null;
            unset($data['image']);

            $galleryImages = $data['images'] ?? [];
            unset($data['images']);

            $variants = $data['variants'] ?? [];
            unset($data['variants']);

            if (isset($data['name'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            if (isset($data['stock'])) {
                $product->stock = $data['stock'];
            }

            $product->update($data);

            $order = $product->images()->count() + 1;

            // Jika ada foto utama baru saat update
            if ($mainImage) {
                // Opsional: set foto lama jadi bukan primary
                $product->images()->update(['is_primary' => 0]);

                $mainImagePath = $mainImage->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $mainImagePath,
                    'is_primary' => 1, // Set sebagai foto utama
                    'order' => $order++,
                ]);
            }

            if (!empty($galleryImages)) {
                foreach ($galleryImages as $imgFile) {
                    $galleryPath = $imgFile->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $galleryPath,
                        'is_primary' => 0,
                        'order' => $order++,
                    ]);
                }
            }

            if (!empty($variants)) {
                $product->variants()->delete();
                foreach ($variants as $variant) {
                    $product->variants()->create($variant);
                }
            }

            return $product;
        });
    }
}
