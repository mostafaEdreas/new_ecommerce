<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
            'order' => $this->faker->numberBetween(1, 10), // Order number
            'parent_id' => \App\Models\Category::inRandomOrder()->first()?->id, // Random parent ID or null
            'text_ar' => $this->faker->optional()->paragraph, // Optional Arabic text
            'text_en' => $this->faker->optional()->paragraph, // Optional English text
            'image' => $this->faker->imageUrl(640, 480, 'business'), // Random image URL
            'icon' => $this->faker->optional()->imageUrl(100, 100, 'abstract'), // Optional icon URL
            'status' => $this->faker->randomElement(['active', 'inactive']), // Status
            'link_ar' => $this->faker->unique()->word, // Unique Arabic link
            'link_en' => $this->faker->unique()->word, // Unique English link
            'mete_title_ar' => $this->faker->optional()->sentence, // Optional Arabic meta title
            'mete_title_en' => $this->faker->optional()->sentence, // Optional English meta title
            'mete_description_ar' => $this->faker->optional()->paragraph, // Optional Arabic meta description
            'mete_description_en' => $this->faker->optional()->paragraph, // Optional English meta description
            'index' => $this->faker->boolean, // Boolean for indexing
        ];
    }
}
