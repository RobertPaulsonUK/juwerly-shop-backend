<?php

namespace Database\Factories;

use App\Models\AttributeOption;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variation>
 */
class VariationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = $this->faker->randomFloat(2, 100, 10000);
        $option = AttributeOption::get()->random();
        return [
            'price' => $price,
            'sale_price' => $this->faker->boolean(30) ? $this->faker->randomFloat(2, 50, $price - 1) : null,
            'in_stock' => $this->faker->boolean(),
            'value' => [
                'attribute' => $option->attribute->title,
                'option' => $option->title
            ],
            'product_id' => Product::factory()
        ];
    }
}
