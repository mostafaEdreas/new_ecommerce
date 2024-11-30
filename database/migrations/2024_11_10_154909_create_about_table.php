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
        Schema::create('about', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar',255);
            $table->string('title_en',255);
            $table->longText('text_ar')->nullable();
            $table->longText('text_en')->nullable();
            $table->string('video_link')->nullable();
            $table->string('image',255)->nullable();
            $table->string('banner',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us_');
    }
};
