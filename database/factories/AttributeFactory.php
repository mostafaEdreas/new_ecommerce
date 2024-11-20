<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attribute>
 */
class AttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_ar' => $this->faker->unique()->word, // Unique Arabic name
            'name_en' => $this->faker->unique()->word, // Unique English name
            'status' => $this->faker->boolean, // Random true/false
        ];
    }
}
