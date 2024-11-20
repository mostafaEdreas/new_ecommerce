<?php

namespace Database\Seeders;

use App\Models\ProductAttributeValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductAttributeValue::factory(10)->create(); // Create 10 records
    }
}
