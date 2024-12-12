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
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->foreignId('region_id')->constrained('regions')->onDelete('cascade');
            $table->boolean('status')->nullable()->default(1);
            $table->unique(['name_ar' , 'region_id']);
            $table->unique(['name_en' , 'region_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('areas', function (Blueprint $table) {
            Schema::dropIfExists('areas');
        });
    }
};
