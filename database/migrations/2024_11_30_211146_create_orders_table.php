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
            $table->string('number')->unique();
            $table->foreignId('address_id')->constrained('addresses');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('delivery_id')->constrained('deliveries');
            $table->foreignId('payment_id')->constrained('payment_methods');
            $table->decimal('payment_fees', 10, 2)->nullable()->default(0.00);
            $table->foreignId('shipping_id')->constrained('shipping_methods');
            $table->decimal('shipping_fees', 10, 2)->nullable()->default(0.00);
            $table->decimal('products_price', 10, 2)->nullable()->default(0.00);
            $table->foreignId('coupon_id')->constrained('coupons');
            $table->decimal('coupon_discount', 10, 2)->nullable()->default(0.00);
            $table->decimal('total_price', 10, 2)->nullable()->default(0.00);

            $table->boolean('payment_status')->default(0);
            $table->text('note')->nullable();
            $table->boolean('admin_seen')->default(0);
            $table->date('delivery_date')->nullable();
            $table->string('status')->default('pennding');
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
