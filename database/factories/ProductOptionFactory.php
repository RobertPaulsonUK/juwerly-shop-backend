<?php

namespace Database\Factories;

use App\Models\AttributeOption;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductOption>
 */
class ProductOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $option = AttributeOption::get()->random();
        return [
            'product_id' => Product::factory(),
            'option_id' => $option->id,
            'attribute_id' => $option->attribute_id,
        ];
    }
}
