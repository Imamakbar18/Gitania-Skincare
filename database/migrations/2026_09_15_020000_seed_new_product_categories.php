<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $categories = [
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optional rollback
    }
};