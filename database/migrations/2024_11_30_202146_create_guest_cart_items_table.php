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
        Schema::create('guest_cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_stock_id')->constrained('product_stock')->onDelete('cascade');
            $table->integer('quantity');
            $table->foreignId('guest_cart_id')->constrained('guest_carts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_cart_items');
    }
};
