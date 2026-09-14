<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Serum',
            'Facial Wash',
            '5 Produk dalam 1 Paket',
            'Refreshing Toner/Toner',
            'Day Cream',
            'Gitania 3 in 1',
            'Night Cream',
            'Face Mist',
            'Cleanser',
            'Moisturizer',
        ];

        foreach ($categories as $catName) {
            Category::firstOrCreate(
                ['name' => $catName],
                [
                    'slug' => Str::slug($catName),
                    'status' => 'active',
                ]
            );
        }
    }
}