<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\BeforeAfterCase;
use App\Models\Category;
use App\Models\Media;
use App\Models\MediaPost;
use App\Models\Order;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GitaniaFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake([
            '*' => Http::response(['status' => true], 200),
        ]);
    }

    public function test_homepage_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_products_catalog_loads_and_can_filter()
    {
        $category = Category::factory()->create(['name' => 'Serum Series', 'slug' => 'serum-series']);
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Hydrating Glow Serum',
            'slug' => 'hydrating-glow-serum',
            'status' => 'active',
            'stock' => 15,
            'price' => 125000,
        ]);

        $response = $this->get(route('shop.index'));
        $response->assertStatus(200);
        $response->assertSee('Hydrating Glow Serum');

        $searchResponse = $this->get(route('shop.index', ['search' => 'Hydrating']));
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Hydrating Glow Serum');

        $catResponse = $this->get(route('shop.index', ['category' => 'serum-series']));
        $catResponse->assertStatus(200);
        $catResponse->assertSee('Hydrating Glow Serum');
    }

    public function test_product_detail_page_loads()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Sunscreen SPF 50',
            'slug' => 'sunscreen-spf-50',
            'status' => 'active',
            'stock' => 20,
        ]);

        $response = $this->get(route('products.show', $product->slug));
        $response->assertStatus(200);
        $response->assertSee('Sunscreen SPF 50');
    }

    public function test_contact_page_loads()
    {
        $response = $this->get(route('contact'));
        $response->assertStatus(200);
    }

    public function test_media_and_article_pages_load()
    {
        $post = MediaPost::create([
            'category' => 'news',
            'title' => 'Tips Merawat Skin Barrier Sehat',
            'slug' => 'tips-merawat-skin-barrier-sehat',
            'content' => 'Berikut cara menjaga kelembapan kulit secara alami...',
            'published_date' => now()->toDateString(),
        ]);

        $response = $this->get(route('media'));
        $response->assertStatus(200);

        $detailResponse = $this->get(route('media.show', $post->slug));
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Tips Merawat Skin Barrier Sehat');
    }

    public function test_chatbot_returns_fallback_reply_and_products_when_asked()
    {
        $category = Category::factory()->create();
        Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Acne Spot Care',
            'status' => 'active',
            'stock' => 10,
            'price' => 85000,
        ]);

        $response = $this->postJson(route('ai.chat'), [
            'message' => 'Halo selamat pagi',
        ]);
        $response->assertStatus(200)
                 ->assertJson(['success' => true])
                 ->assertJsonStructure(['reply', 'show_products', 'products']);

        $productChatResponse = $this->postJson(route('ai.chat'), [
            'message' => 'Ada produk skincare apa saja untuk jerawat?',
        ]);
        $productChatResponse->assertStatus(200)
                            ->assertJson(['success' => true, 'show_products' => true]);

        $emptyResponse = $this->postJson(route('ai.chat'), [
            'message' => '',
        ]);
        $emptyResponse->assertStatus(400);
    }

    public function test_cart_operations_work_properly()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Moisturizer Gel',
            'price' => 95000,
            'stock' => 10,
        ]);

        $addResponse = $this->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
        $addResponse->assertStatus(200)
                    ->assertJson(['success' => true, 'count' => 1]);

        $this->assertEquals(2, session('cart')[$product->id]['quantity']);

        $drawerResponse = $this->getJson(route('cart.data'));
        $drawerResponse->assertStatus(200)
                       ->assertJsonStructure(['html', 'count']);

        $updateResponse = $this->postJson(route('cart.update'), [
            'product_id' => $product->id,
            'change' => 1,
        ]);
        $updateResponse->assertStatus(200);
        $this->assertEquals(3, session('cart')[$product->id]['quantity']);

        $cartPage = $this->get(route('cart.index'));
        $cartPage->assertStatus(200);

        $removeResponse = $this->postJson(route('cart.ajax.remove'), [
            'product_id' => $product->id,
        ]);
        $removeResponse->assertStatus(200)
                       ->assertJson(['count' => 0]);
        $this->assertEmpty(session('cart'));
    }

    public function test_guest_is_redirected_to_login_on_checkout()
    {
        $response = $this->post(route('orders.store'), [
            'customer_name' => 'Budi Santoso',
            'customer_phone' => '081234567890',
            'shipping_address' => 'Jl. Mawar No. 10 Malang',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_place_order_and_stock_decrements()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Gentle Facial Wash',
            'price' => 75000,
            'stock' => 10,
        ]);

        $response = $this->actingAs($user)->post(route('orders.store'), [
            'customer_name' => 'Budi Santoso',
            'customer_phone' => '081234567890',
            'customer_email' => 'budi@gmail.com',
            'shipping_address' => 'Jl. Melati No. 5 Surabaya',
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $order = Order::where('customer_phone', '081234567890')->first();
        $this->assertNotNull($order);
        $this->assertEquals(150000, $order->total_amount);
        $this->assertEquals(2, $order->quantity);

        $this->assertEquals(8, $product->fresh()->stock);

        $response->assertRedirect(route('orders.payment', $order->invoice_number));

        $statusResponse = $this->getJson(route('orders.status', $order->invoice_number));
        $statusResponse->assertStatus(200)
                       ->assertJson([
                           'invoice_number' => $order->invoice_number,
                           'status' => 'menunggu pembayaran',
                           'is_paid' => false,
                       ]);

        $successResponse = $this->get(route('orders.success', $order->invoice_number));
        $successResponse->assertStatus(200);
    }

    public function test_midtrans_webhook_updates_order_to_paid_on_settlement()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $order = Order::create([
            'invoice_number' => 'GS-20260913-9999',
            'customer_name' => 'Siti Rahma',
            'customer_phone' => '081298765432',
            'shipping_address' => 'Jakarta',
            'product_id' => $product->id,
            'quantity' => 1,
            'total_amount' => 100000,
            'status' => 'menunggu pembayaran',
        ]);

        $serverKey = config('midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY', '');
        $signature = hash('sha512', $order->invoice_number . '200' . '100000.00' . $serverKey);

        $payload = [
            'order_id' => $order->invoice_number,
            'status_code' => '200',
            'gross_amount' => '100000.00',
            'signature_key' => $signature,
            'transaction_status' => 'settlement',
            'payment_type' => 'qris',
            'transaction_id' => 'TRX-123456',
        ];

        $response = $this->postJson(route('midtrans.notification'), $payload);
        $response->assertStatus(200)
                 ->assertJson(['status' => 'success']);

        $order->refresh();
        $this->assertEquals('paid', $order->status);
    }

    public function test_admin_can_manage_banners_and_testimonials()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Storage::fake('public');

        $bannerFile = UploadedFile::fake()->create('banner.jpg', 200, 'image/jpeg');
        $bannerResponse = $this->actingAs($admin)->post(route('admin.banners.store'), [
            'title' => 'Promo Spesial Lebaran',
            'image' => $bannerFile,
            'link' => '/products',
            'is_active' => 1,
            'order' => 1,
        ]);
        $bannerResponse->assertRedirect(route('admin.banners.index'));
        $this->assertDatabaseHas('banners', ['title' => 'Promo Spesial Lebaran']);

        $testiResponse = $this->actingAs($admin)->post(route('admin.testimonials.store'), [
            'name' => 'Dr. Jessica',
            'badge' => 'Dermatologist',
            'comment' => 'Formula Gitania sangat lembut dan efektif di kulit sensitif.',
            'rating' => 5,
            'is_active' => 1,
            'order_index' => 1,
        ]);
        $testiResponse->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseHas('testimonials', ['name' => 'Dr. Jessica']);
    }

    public function test_admin_reports_csv_and_pdf_export()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        Order::create([
            'invoice_number' => 'GS-REPORT-01',
            'customer_name' => 'Laporan Tester',
            'customer_phone' => '0812345678',
            'shipping_address' => 'Bandung',
            'product_id' => $product->id,
            'quantity' => 1,
            'total_amount' => 150000,
            'status' => 'paid',
        ]);

        $indexResponse = $this->actingAs($admin)->get(route('admin.reports.index'));
        $indexResponse->assertStatus(200);

        $csvResponse = $this->actingAs($admin)->get(route('admin.reports.exportCsv'));
        $csvResponse->assertStatus(200);
        $this->assertEquals('text/csv; charset=UTF-8', $csvResponse->headers->get('Content-Type'));

        $pdfResponse = $this->actingAs($admin)->get(route('admin.reports.exportPdf'));
        $pdfResponse->assertStatus(200);
        $this->assertEquals('application/pdf', $pdfResponse->headers->get('Content-Type'));
    }
}