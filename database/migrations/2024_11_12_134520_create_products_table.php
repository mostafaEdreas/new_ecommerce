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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar',255)->unique();
            $table->string('name_en',255)->unique();
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('brand_id')->nullable()->constrained('brands');
            $table->integer('order', 20);
            $table->longText('text_ar')->nullable();
            $table->longText('text_en')->nullable();
            $table->longText('short_text_ar')->nullable();
            $table->longText('short_text_en')->nullable();
            $table->string('main_image',20);
            $table->string('second_image',20)->nullable();
            $table->string('icon',255)->nullable();
            $table->string('status',255)->default(0);
            $table->string('link_ar',255)->unique();
            $table->string('link_en',255)->unique();
            $table->string('mete_title_ar',255)->nullable();
            $table->string('mete_title_en',255)->nullable();
            $table->longText('mete_description_ar')->nullable();
            $table->longText('mete_description_en')->nullable();
            $table->boolean('index')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
