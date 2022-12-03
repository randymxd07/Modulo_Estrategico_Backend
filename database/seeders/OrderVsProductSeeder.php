<?php

namespace Database\Seeders;

use App\Models\OrderVsProduct;
use Illuminate\Database\Seeder;

class OrderVsProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderVsProduct::factory()->count(5)->create();
    }
}
