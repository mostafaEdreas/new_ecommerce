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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar')->unique();
            $table->string('title_en')->unique();
            $table->longText('text_ar');
            $table->longText('text_en');
            $table->string('link_ar',255)->unique();
            $table->string('link_en',255)->unique();
            $table->string('mete_title_ar',255)->nullable();
            $table->string('mete_title_en',255)->nullable();
            $table->longText('mete_description_ar')->nullable();
            $table->longText('mete_description_en')->nullable();
            $table->string('status',255)->nullable()->default(1);
            $table->boolean('index')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
