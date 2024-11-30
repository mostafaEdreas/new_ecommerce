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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar',255)->unique();
            $table->string('name_en',255)->unique();
            $table->boolean('status')->default(0);
            $table->foreignId('parent_id')->nullable()->constrained('menus');
            $table->string('segment')->nullable();
            $table->string('type',255)->default('main');
            $table->integer('order')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lists');
    }
};
