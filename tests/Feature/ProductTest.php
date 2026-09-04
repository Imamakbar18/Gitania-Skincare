<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase; // <-- Membuat otomatis tabel database saat testing

    public function test_admin_can_create_product()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'category_id' => $category->id,
            'name' => 'Hydrating Serum Test',
            'sku' => 'SERUM-001',
            'price' => 150000,
            'weight' => 100,
            'status' => 'active',
            'description' => 'Serum test description',
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['sku' => 'SERUM-001']);
    }

    public function test_duplicate_sku_is_prevented()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $category = Category::factory()->create();

        Product::factory()->create([
            'category_id' => $category->id,
            'sku' => 'DUPLICATE-SKU',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'category_id' => $category->id,
            'name' => 'Another Product',
            'sku' => 'DUPLICATE-SKU',
            'price' => 100000,
            'weight' => 50,
            'status' => 'active',
        ]);

        $response->assertSessionHasErrors('sku');
    }

    public function test_unauthorized_user_cannot_access_admin_product_creation()
    {
        $regularUser = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($regularUser)->get(route('admin.products.create'));

        $response->assertForbidden();
    }
}
