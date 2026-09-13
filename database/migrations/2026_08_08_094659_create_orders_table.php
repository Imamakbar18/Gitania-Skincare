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
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('invoice_number')->unique();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('shipping_address');
            $table->integer('quantity')->default(1);
            $table->decimal('total_amount', 12, 2);
            $table->string('status')->default('menunggu pembayaran');
            $table->string('tracking_number')->nullable();
            $table->string('marketplace_source')->default('website');
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
