<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_ar' => $this->faker->unique()->word ,
            'name_en' => $this->faker->unique()->word,
            'order' => $this->faker->numberBetween(1, 20),
            'text_ar' => $this->faker->paragraph,
            'text_en' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(640, 480, 'brands'),
            'icon' => $this->faker->imageUrl(100, 100, 'icons'),
            'status' => $this->faker->randomElement(['0', '1']),
            'link_ar' => $this->faker->unique()->word,
            'link_en' => $this->faker->unique()->word,
            'mete_title_ar' => $this->faker->sentence,
            'mete_title_en' => $this->faker->sentence,
            'mete_description_ar' => $this->faker->paragraph,
            'mete_description_en' => $this->faker->paragraph,
            'index' => $this->faker->boolean,
        ];
    }
}
