<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('f_name');
            $table->string('l_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('image')->nullable();
            $table->string('them')->default('default');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default(Hash::make(date('YmdHi')));
            $table->boolean('is_admin')->default(0);
            $table->boolean('admin_seen')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};