<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => $this->faker->imageUrl(),  // Generate a random image URL
            'imageable_id' => Product::factory(),  // Or another model like Category::factory()
            'imageable_type' => Product::class,   // Or the appropriate model class
        ];
    }
}
