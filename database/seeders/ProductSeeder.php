<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Inventory;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $category = Category::create([
            'name' => 'Skincare & Serum',
            'slug' => 'skincare-serum'
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Hydrience HA+ Hydration Serum',
            'slug' => 'hydrience-ha-hydration-serum',
            'description' => 'Krim pelembap bertekstur ringan yang menyerap instan, diperkaya dengan 5 essential ceramides.',
            'price' => 150000,
        ]);

        // Varian 15 ml
        $variant1 = ProductVariant::create([
            'product_id' => $product->id,
            'variant_name' => '15 ml / 0.50 FL. OZ.',
            'price' => 150000,
        ]);
        Inventory::create([
            'product_variant_id' => $variant1->id,
            'stock_quantity' => 50,
        ]);

        // Varian 50 ml
        $variant2 = ProductVariant::create([
            'product_id' => $product->id,
            'variant_name' => '50 ml / 1.69 FL. OZ.',
            'price' => 350000,
        ]);
        Inventory::create([
            'product_variant_id' => $variant2->id,
            'stock_quantity' => 30,
        ]);
    }
}
