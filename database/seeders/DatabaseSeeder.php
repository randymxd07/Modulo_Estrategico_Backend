<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(ProductCategorySeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(OrderTypeSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
