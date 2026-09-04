<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->string('invoice_number')->unique();
    $table->string('customer_name');
    $table->string('customer_phone');
    $table->text('shipping_address');
    $table->decimal('total_amount', 12, 2);
    $table->enum('status', ['pending', 'paid', 'packed', 'shipping', 'completed', 'cancelled'])->default('pending');
    $table->string('tracking_number')->nullable(); // <-- Tambahkan baris ini untuk nomor resi
    $table->string('marketplace_source')->default('website'); // website, shopee, tokopedia
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
