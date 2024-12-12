<?php

use App\Models\Area;
use App\Models\ShippingFees;
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
        Schema::create('shipping_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            $table->decimal('fees',10,2)->nullable()->default(0.00);
            $table->timestamps();
        });

        foreach (Area::pluck('id') as $key => $id) {
            ShippingFees::create(['area_id' => $id]) ;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_fees');
    }
};
