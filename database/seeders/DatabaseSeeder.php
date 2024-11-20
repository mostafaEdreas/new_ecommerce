<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            AttributeSeeder::class,        // Seeds attributes table
            AttributeValueSeeder::class,  // Seeds attribute_values table
            CategorySeeder::class,        // Seeds categories table (if applicable)
            BrandSeeder::class, // Seeds the brands table
            ProductSeeder::class,
            DiscountSeeder::class,
            ProductAttributeSeeder::class,
            ProductAttributeValueSeeder::class,
            ProductStockSeeder::class,  

        ]);



    }
}
