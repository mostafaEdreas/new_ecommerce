<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function PHPSTORM_META\type;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar',255)->nullable();
            $table->string('title_en',255)->nullable();
            $table->text('text_ar')->nullable();
            $table->text('text_en')->nullable();
            $table->string('video_link')->nullable();
            $table->string('image',50)->nullable();
            $table->integer('order')->nullable()->nullable()->default(1);
            $table->string('type',50)->nullable()->default('home');
            $table->boolean('status')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
