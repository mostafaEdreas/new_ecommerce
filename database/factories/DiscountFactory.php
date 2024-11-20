<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_date' => $this->faker->dateTimeThisYear(),
            'end_date' => $this->faker->dateTimeThisYear('+1 month'),
            'discount' => $this->faker->randomFloat(2, 5, 100), // Random discount between 5 and 100
            'type' => $this->faker->boolean(50), // Randomly 0 or 1
            'product_id' => Product::inRandomOrder()->first()->id, // Random product ID
        ];
    }
}
