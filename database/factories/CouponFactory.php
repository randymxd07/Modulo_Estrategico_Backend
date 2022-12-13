<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Coupon;
use App\Models\ProductCategory;

class CouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text,
            'porcent' => $this->faker->randomFloat(0, 0, 9999999999.),
            'product_category_id' => ProductCategory::factory(),
            'status' => $this->faker->boolean,
        ];
    }
}
