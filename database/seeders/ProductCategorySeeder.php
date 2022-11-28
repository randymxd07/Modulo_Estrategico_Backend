<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{

    public function run()
    {

        $productCategories = ['Hamburguesas', 'Pizzas', 'Pollo', 'Bebidas', 'Sandwiches', 'Postres', 'Mariscos'];

        foreach ($productCategories as $productCategory){
            ProductCategory::create([
                'name' => $productCategory,
                'description' => "Some quick example text to build on the card title and make up the bulk of the card's content.",
                'status' => true,
            ]);
        }

//        ProductCategory::factory()->count(5)->create();

    }

}
