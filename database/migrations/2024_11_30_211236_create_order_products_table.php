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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_stock_id')->constrained('product_stock');
            $table->decimal('price', 10, 2)->default(0.00);
            $table->foreignId('discount_id')->nullable()->constrained('discounts');
            $table->decimal('product_discount', 10, 2)->default(0.00);
            $table->integer('quantity')->default(1);
            $table->decimal('total', 10, 2)->nullable()->default(0.00);
            $table->string('status')->default('pennding');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
