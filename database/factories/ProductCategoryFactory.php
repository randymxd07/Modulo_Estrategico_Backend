<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ProductCategory;

class ProductCategoryFactory extends Factory
{

    protected $model = ProductCategory::class;


    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'status' => $this->faker->boolean,
        ];
    }

}
