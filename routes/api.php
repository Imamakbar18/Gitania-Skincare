<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/categories', [ProductController::class, 'categories']);
Route::get('/products/{product}/variants', [ProductController::class, 'variants']);

// Midtrans Webhook Notification Endpoint
Route::post('/midtrans/notification', [\App\Http\Controllers\MidtransWebhookController::class, 'handle'])->name('midtrans.notification.api');
Route::post('/midtrans/webhook', [\App\Http\Controllers\MidtransWebhookController::class, 'handle'])->name('midtrans.webhook.api');
Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle'])->name('midtrans.callback.api');
