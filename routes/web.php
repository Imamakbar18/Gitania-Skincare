<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\MediaPostController as AdminMediaPostController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\BeforeAfterController as AdminBeforeAfterController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\ChatController;


// --- Rute Publik Website ---
Route::get('/', [ShopController::class, 'home'])->name('home');
Route::get('/products', [ShopController::class, 'index'])->name('shop.index');
Route::get('/products/{slug}', [ShopController::class, 'show'])->name('products.show');
Route::get('/about', [ShopController::class, 'about'])->name('about');
Route::get('/media', [ShopController::class, 'mediaIndex'])->name('media');
Route::get('/media/{category}', [ShopController::class, 'mediaCategory'])->name('media.category');
Route::get('/media/article/{slug}', [ShopController::class, 'mediaShow'])->name('media.show');
Route::get('/contact', [ShopController::class, 'contact'])->name('contact');

// --- Rute AI Chat Gemini ---
Route::post('/ai-chat', [ChatController::class, 'chat'])->name('ai.chat');

// --- Keranjang Belanja & Checkout (AJAX & Web) ---
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/data', [CartController::class, 'getCartData'])->name('cart.data');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/remove-ajax', [CartController::class, 'removeAjax'])->name('cart.ajax.remove');
Route::get('/checkout', function () {
    return view('cart.checkout');
})->name('cart.checkout');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/payment/{invoice_number}', [OrderController::class, 'payment'])->name('orders.payment');
Route::get('/orders/success/{invoice_number}', [OrderController::class, 'success'])->name('orders.success');
Route::get('/orders/check-status/{invoice_number}', [OrderController::class, 'checkStatus'])->name('orders.status');

// Webhook Midtrans
Route::post('/midtrans/notification', [\App\Http\Controllers\MidtransWebhookController::class, 'handle'])->name('midtrans.notification');
Route::post('/api/midtrans/notification', [\App\Http\Controllers\MidtransWebhookController::class, 'handle'])->name('midtrans.notification.web');
Route::post('/midtrans/webhook', [\App\Http\Controllers\MidtransWebhookController::class, 'handle'])->name('midtrans.webhook');
Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle'])->name('midtrans.callback');

// --- Rute Khusus Admin ---
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-csv', [ReportController::class, 'exportCsv'])->name('reports.exportCsv');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.exportPdf');

    // Kelola Pelanggan
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');

    // Kelola Media / Instagram Admin
    Route::get('/media', [AdminMediaController::class, 'index'])->name('media.dashboard');
    Route::get('/media/list', [AdminMediaController::class, 'index'])->name('media.index');
    Route::get('/media/create', [AdminMediaController::class, 'create'])->name('media.form.create');
    Route::post('/media', [AdminMediaController::class, 'store'])->name('media.save');
    Route::delete('/media/{id}', [AdminMediaController::class, 'destroy'])->name('media.remove');

    // Kelola Artikel Media Admin
    Route::get('/media-posts', [AdminMediaPostController::class, 'index'])->name('media-posts.index');
    Route::get('/media-posts/create', [AdminMediaPostController::class, 'create'])->name('media-posts.create');
    Route::post('/media-posts', [AdminMediaPostController::class, 'store'])->name('media-posts.store');
    Route::get('/media-posts/{id}/edit', [AdminMediaPostController::class, 'edit'])->name('media-posts.edit');
    Route::put('/media-posts/{id}', [AdminMediaPostController::class, 'update'])->name('media-posts.update');
    Route::delete('/media-posts/{id}', [AdminMediaPostController::class, 'destroy'])->name('media-posts.destroy');

    // Kelola Banner Hero Slider Admin
    Route::get('/banners', [AdminBannerController::class, 'index'])->name('banners.index');
    Route::post('/banners', [AdminBannerController::class, 'store'])->name('banners.store');
    Route::delete('/banners/{id}', [AdminBannerController::class, 'destroy'])->name('banners.destroy');
    Route::post('/banners/{id}/toggle', [AdminBannerController::class, 'toggle'])->name('banners.toggle');

    // Kelola Hasil Nyata (Before-After) Admin
    Route::get('/before-after', [AdminBeforeAfterController::class, 'index'])->name('before-after.index');
    Route::post('/before-after', [AdminBeforeAfterController::class, 'store'])->name('before-after.store');
    Route::put('/before-after/{id}', [AdminBeforeAfterController::class, 'update'])->name('before-after.update');
    Route::delete('/before-after/{id}', [AdminBeforeAfterController::class, 'destroy'])->name('before-after.destroy');
    Route::post('/before-after/{id}/toggle', [AdminBeforeAfterController::class, 'toggle'])->name('before-after.toggle');

    // Kelola Ulasan Hasil / Testimoni Admin
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
    Route::patch('testimonials/{id}/toggle-active', [\App\Http\Controllers\Admin\TestimonialController::class, 'toggleActive'])->name('testimonials.toggleActive');

    // --- PENGATURAN AKUN KHUSUS ADMIN ---
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings');

    // CRUD Produk Admin
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [AdminProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
});

// --- Rute Profil Pengguna / Member Biasa ---
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');

    Route::get('/profile', function (Request $request) {
        $tab = $request->query('tab', 'overview');
        return view('profile.index', compact('tab'));
    })->name('profile.index');

    Route::get('/profile/edit', function (Request $request) {
        return redirect()->route('profile.index', ['tab' => 'edit']);
    })->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Rute Ulasan Pengguna ---
    Route::get('/user/orders/{order}/review', [ReviewController::class, 'create'])->name('user.reviews.create');
    Route::post('/user/orders/{order}/review', [ReviewController::class, 'store'])->name('user.reviews.store');
});

require __DIR__.'/auth.php';
