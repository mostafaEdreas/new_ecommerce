<?php

namespace Database\Factories;

use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAttributeValue>
 */
class ProductAttributeValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_attribute_id' => ProductAttribute::factory(), // Automatically creates a related product_attribute
            'value_id' => AttributeValue::factory(), // Automatically creates a related value
        ];
    }
}
