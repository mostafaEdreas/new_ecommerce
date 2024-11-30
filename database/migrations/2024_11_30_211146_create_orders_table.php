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
            $table->boolean('status')->default(0);
            $table->foreignId('address_id')->constrained('addresses');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('payment_id')->constrained('payments');
            $table->foreignId('shipping_id')->constrained('shippings');
            $table->decimal('products_price', 10, 2)->default(0.00);
            $table->foreignId('coupon_id')->constrained('coupons');
            $table->boolean('payment_status')->default(0);
            $table->text('note')->nullable();
            $table->boolean('admin_seen')->default(0);
            $table->date('delivery_date')->nullable();
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
