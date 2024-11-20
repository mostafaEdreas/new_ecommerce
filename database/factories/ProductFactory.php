<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
            'brand_id' => \App\Models\Brand::inRandomOrder()->first()->id,
            'order' => $this->faker->numberBetween(1, 100),
            'text_ar' => $this->faker->paragraph,
            'text_en' => $this->faker->paragraph,
            'short_text_ar' => $this->faker->sentence,
            'short_text_en' => $this->faker->sentence,
            'main_image' => $this->faker->imageUrl(640, 480, 'products'),
            'second_image' => $this->faker->imageUrl(640, 480, 'products'),
            'icon' => $this->faker->imageUrl(100, 100, 'icons'),
            'status' => $this->faker->boolean,
            'link_ar' => $this->faker->unique()->url,
            'link_en' => $this->faker->unique()->url,
            'mete_title_ar' => $this->faker->sentence,
            'mete_title_en' => $this->faker->sentence,
            'mete_description_ar' => $this->faker->paragraph,
            'mete_description_en' => $this->faker->paragraph,
            'index' => $this->faker->boolean,
        ];
    }
}
