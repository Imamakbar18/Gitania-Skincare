<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->word();
        return [
            'category_id' => Category::factory(),
            'name' => ucfirst($name),
            'slug' => Str::slug($name), // <-- Menambahkan slug otomatis
            'sku' => $this->faker->unique()->bothify('SKU-#####'),
            'price' => 100000,
            'weight' => 100,
            'status' => 'active',
        ];
    }
}
