<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "code" => 48756658,
            "imported_t" => now(),
            "url" => fake()->name(),
            "creator" => fake()->name(),
            "product_name" => fake()->name(),
            "quantity" => fake()->name(),
            "brands" => fake()->name(),
            "categories" => fake()->name(),
            "labels" => fake()->name(),
            "cities" => fake()->name(),
            "purchase_places" => fake()->name(),
            "stores" => fake()->name(),
            "ingredients_text" => fake()->name(),
            "traces" => fake()->name(),
            "serving_size" => 10,
            "serving_quantity" => 5,
            "nutriscore_score" => fake()->name(),
            "nutriscore_grade" => fake()->name(),
            "main_category" => fake()->name(),
            "image_url" => fake()->name()
        ];
    }
}
