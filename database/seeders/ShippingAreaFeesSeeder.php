<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\ShippingFees;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingAreaFeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Area::pluck('id') as $key => $id) {
            ShippingFees::create(['area_id' => $id]) ;
        }
    }
}
