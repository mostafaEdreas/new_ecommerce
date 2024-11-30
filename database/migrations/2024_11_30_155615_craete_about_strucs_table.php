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
        Schema::table('about_strucs', function (Blueprint $table) {
            $table->id(); // Adds an auto-incrementing ID
            $table->string('name_ar'); // Arabic name
            $table->string('name_en'); // English name
            $table->longText('text_ar')->nullable(); // Arabic text, nullable
            $table->longText('text_en')->nullable(); // English text, nullable
            $table->foreignId('parent_id')->nullable()->constrained('about_strucs'); // Parent ID, nullable for hierarchical data
            $table->string('image')->nullable(); // Image path, nullable
            $table->integer('order')->default(0); // Order field, default 0
            $table->boolean('status')->default(1); // Status (e.g., active/inactive)
            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_strucs', function (Blueprint $table) {
            //
        });
    }
};
