<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductStock>
 */
class ProductStockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id,  // This assumes you have a factory for Product
            'stock' => $this->faker->numberBetween(1, 100),  // Random stock quantity
            'price' => $this->faker->randomFloat(2, 10, 500),  // Random price between 10 and 500
        ];
    }
}
