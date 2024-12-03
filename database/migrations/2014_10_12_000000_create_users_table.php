<?php

use App\Models\User;
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
            $table->string('them')->nullable()->default('default');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable()->default(Hash::make(date('YmdHi')));
            $table->boolean('is_admin')->nullable()->default(0);
            $table->boolean('admin_seen')->nullable()->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
        User::create(['f_name'=> 'Super','l_name'=> 'Admin','phone'=> 01126713126,'email' =>'admin@gohina.com', 'password' => Hash::make(123456),'is_admin' => 1 , 'admin_seen' => 1 ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
