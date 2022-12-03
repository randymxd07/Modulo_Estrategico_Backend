<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        $paymentMethods = ["Efectivo", "Tarjeta"];

        foreach ($paymentMethods as $paymentMethod){
            PaymentMethod::create([
                "description" => $paymentMethod,
                "status" => true,
            ]);
        }
    }
}
