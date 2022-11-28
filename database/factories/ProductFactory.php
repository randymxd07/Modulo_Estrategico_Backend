<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductFactory extends Factory
{

    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'product_category_id' => ProductCategory::factory(),
            'price' => $this->faker->randomFloat(2, 0, 999999.99),
            'image_url' => $this->faker->word,
            'estimated_time' => $this->faker->time(),
            'score' => $this->faker->numberBetween(-10000, 10000),
            'status' => $this->faker->boolean,
        ];
    }

}
