<?php

namespace Database\Seeders;

use App\Models\OrderType;
use Illuminate\Database\Seeder;

class OrderTypeSeeder extends Seeder
{
    public function run()
    {

        $orderTypes = ["Ordenar en el Restaurante", "Ordenar a Domicilio"];

        foreach ($orderTypes as $orderType){
            OrderType::create([
               "description" => $orderType,
                "status" => true,
            ]);
        }

    }
}
