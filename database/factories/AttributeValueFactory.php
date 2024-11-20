<?php

namespace Database\Factories;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttributeValue>
 */
class AttributeValueFactory extends Factory
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
            'attribute_id' => Attribute::inRandomOrder()->first()->id, // Random existing attribute
            'status' => $this->faker->boolean, // Random true/false
        ];
    }
}
