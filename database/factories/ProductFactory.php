<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductOption;
use App\Models\Variation;
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
        $price = $this->faker->randomFloat(2, 100, 10000);
        return [
            'name' => $this->faker->words(3, true),
            'article_number' => $this->faker->unique()->numerify('ART#####'),
            'main_image_url' => $this->faker->imageUrl(640, 480, 'products'),
            'gallery_urls' => [
                $this->faker->imageUrl(640, 480, 'products'),
                $this->faker->imageUrl(640, 480, 'products'),
                $this->faker->imageUrl(640, 480, 'products'),
                $this->faker->imageUrl(640, 480, 'products'),
            ],
            'content' => $this->faker->paragraphs(3, true),
            'price' => $price,
            'sale_price' => $this->faker->boolean(30) ? $this->faker->randomFloat(2, 50, $price - 1) : null,
            'is_hit' => $this->faker->boolean(),
            'is_published' => true,
            'in_stock' => $this->faker->boolean(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            ProductOption::factory(rand(3,6))->create(['product_id' => $product->id]);
            Variation::factory($this->faker->boolean(30) ? 3 : 0)->create(['product_id' => $product->id]);
        });
    }
}
