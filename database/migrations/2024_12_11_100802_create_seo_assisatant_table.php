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
        Schema::create('seo_assisatant', function (Blueprint $table) {
            $table->id();

            // Home Meta
            $table->string('home_meta_title_en')->nullable();
            $table->text('home_meta_desc_en')->nullable();
            $table->string('home_meta_title_ar')->nullable();
            $table->text('home_meta_desc_ar')->nullable();
            $table->string('home_meta_robots')->nullable();

            // About Meta
            $table->string('about_meta_title_en')->nullable();
            $table->text('about_meta_desc_en')->nullable();
            $table->string('about_meta_title_ar')->nullable();
            $table->text('about_meta_desc_ar')->nullable();
            $table->string('about_meta_robots')->nullable();

            // Contact Meta
            $table->string('contact_meta_title_en')->nullable();
            $table->text('contact_meta_desc_en')->nullable();
            $table->string('contact_meta_title_ar')->nullable();
            $table->text('contact_meta_desc_ar')->nullable();
            $table->string('contact_meta_robots')->nullable();

            // Deals Products Meta
            $table->string('dealsProducts_meta_title_en')->nullable();
            $table->text('dealsProducts_meta_desc_en')->nullable();
            $table->string('dealsProducts_meta_title_ar')->nullable();
            $table->text('dealsProducts_meta_desc_ar')->nullable();
            $table->string('dealsProducts_meta_robots')->nullable();

            // Brands Meta
            $table->string('brands_meta_title_en')->nullable();
            $table->text('brands_meta_desc_en')->nullable();
            $table->string('brands_meta_title_ar')->nullable();
            $table->text('brands_meta_desc_ar')->nullable();
            $table->string('brands_meta_robots')->nullable();

            // Categories Meta
            $table->string('categories_meta_title_en')->nullable();
            $table->text('categories_meta_desc_en')->nullable();
            $table->string('categories_meta_title_ar')->nullable();
            $table->text('categories_meta_desc_ar')->nullable();
            $table->string('categories_meta_robots')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_assisatant');
    }
};
