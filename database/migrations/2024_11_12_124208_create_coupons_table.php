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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar',255);
            $table->string('name_en',255);
            $table->string('code',20);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('max_use')->unsigned()->comment('Maximum number of users that can be used');
            $table->integer('min_price')->unsigned()->comment('Minimum invoice total can be used');
            $table->decimal('discount',10,2);
            $table->boolean('discount_type')->default('0')->comment('0 = amount || 1 = percentage');
            $table->string('type')->nullable()->default('general');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
