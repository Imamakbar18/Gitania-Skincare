<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApiAndUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_products_api()
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_can_fetch_categories_api()
    {
        Category::factory()->count(2)->create();

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_admin_can_upload_product_image_successfully()
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true]);
        $category = Category::factory()->create();

        $file = UploadedFile::fake()->create('skincare.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'category_id' => $category->id,
            'name' => 'Cream Glowing',
            'sku' => 'GLOW-01',
            'price' => 120000,
            'weight' => 50,
            'status' => 'active',
            'image' => $file,
        ]);

        $response->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', ['sku' => 'GLOW-01']);
    }
}
