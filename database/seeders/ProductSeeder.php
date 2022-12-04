<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {

        $products = [
            [
                "name" => "Pizza de Vegetales",
                "description" => "Prueba",
                "product_category_id" => 2,
                "price" => "850.00",
                "image_url" => "http://localhost:8000/public/productImages/d31116ca-9ecf-4750-a70a-a751059263e4.png",
                "estimated_time" => "00:50:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Flan",
                "description" => "prueba",
                "product_category_id" => 6,
                "price" => "80.00",
                "image_url" => "http://localhost:8000/public/productImages/3a595f65-7edb-4c0b-a14c-b8a838a6fcc0.png",
                "estimated_time" => "00:05:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Camaron Rico",
                "description" => "prueba",
                "product_category_id" => 7,
                "price" => "250.00",
                "image_url" => "http://localhost:8000/public/productImages/b11851b5-f25d-4a85-ab18-c4400dee76dc.png",
                "estimated_time" => "00:30:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Jugo de Fresa",
                "description" => "prueba",
                "product_category_id" => 4,
                "price" => "80.00",
                "image_url" => "http://localhost:8000/public/productImages/c2b11962-761b-4916-9087-19d3ea4bb515.png",
                "estimated_time" => "00:05:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Jugo de Naranja",
                "description" => "prueba",
                "product_category_id" => 4,
                "price" => "80.00",
                "image_url" => "http://localhost:8000/public/productImages/a74f5a13-399c-46ff-8880-bb6930ec11c3.png",
                "estimated_time" => "00:05:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Pastel de Fresa",
                "description" => "Prueba",
                "product_category_id" => 6,
                "price" => "120.00",
                "image_url" => "http://localhost:8000/public/productImages/43030eb6-adfb-4986-a181-858e56fed1a4.png",
                "estimated_time" => "00:05:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Hamburguesa con Papas",
                "description" => "prueba",
                "product_category_id" => 1,
                "price" => "350.00",
                "image_url" => "http://localhost:8000/public/productImages/fdd64213-a7e3-4958-9e73-a5c8de2beb10.png",
                "estimated_time" => "00:10:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Ensalada de Coditos con Atun",
                "description" => "prueba",
                "product_category_id" => 8,
                "price" => "100.00",
                "image_url" => "http://localhost:8000/public/productImages/80fecfde-3b6e-47ca-9b34-89c3e17f1648.png",
                "estimated_time" => "00:10:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Pollo a la Crema",
                "description" => "prueba",
                "product_category_id" => 3,
                "price" => "250.00",
                "image_url" => "http://localhost:8000/public/productImages/0a830819-270e-4bcd-9c3b-0ce4286b5348.png",
                "estimated_time" => "00:30:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Galletas de Chocolate",
                "description" => "prueba",
                "product_category_id" => 6,
                "price" => "30.00",
                "image_url" => "http://localhost:8000/public/productImages/0b35cd54-1534-43ee-b0bb-25379ef74216.png",
                "estimated_time" => "00:10:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Pollo Frito con Papas",
                "description" => "prueba",
                "product_category_id" => 3,
                "price" => "250.00",
                "image_url" => "http://localhost:8000/public/productImages/00475a75-c5e2-4805-95ae-27e15c3a3ad3.png",
                "estimated_time" => "00:10:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Sandwich de Jamon y Queso",
                "description" => "prueba",
                "product_category_id" => 5,
                "price" => "80.00",
                "image_url" => "http://localhost:8000/public/productImages/ba7df675-ef29-4e9c-b148-4e687922dacf.png",
                "estimated_time" => "00:05:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Hamburguesa de Queso con Aros de Cebolla",
                "description" => "prueba",
                "product_category_id" => 1,
                "price" => "450.00",
                "image_url" => "http://localhost:8000/public/productImages/6deb8596-34df-4a86-85db-ce89d3b8a65b.png",
                "estimated_time" => "00:40:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Pollo Horneado",
                "description" => "prueba",
                "product_category_id" => 3,
                "price" => "250.00",
                "image_url" => "http://localhost:8000/public/productImages/3c5150bf-d9cb-40cc-93a1-bab63ec47945.png",
                "estimated_time" => "00:30:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Hamburguesa con Triple Carne",
                "description" => "prueba",
                "product_category_id" => 1,
                "price" => "550.00",
                "image_url" => "http://localhost:8000/public/productImages/77298855-d229-47c5-bd3a-78b493e71b80.png",
                "estimated_time" => "00:30:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Coca Cola",
                "description" => "prueba",
                "product_category_id" => 4,
                "price" => "35.00",
                "image_url" => "http://localhost:8000/public/productImages/f38fc442-1ab4-4b63-9938-5e50ea69a501.png",
                "estimated_time" => "00:02:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Sandwich Completo",
                "description" => "prueba",
                "product_category_id" => 5,
                "price" => "150.00",
                "image_url" => "http://localhost:8000/public/productImages/85267fb5-5448-4527-8e7e-089e6930c8df.png",
                "estimated_time" => "00:10:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Flan con Mermelada de Fresa",
                "description" => "prueba",
                "product_category_id" => 6,
                "price" => "150.00",
                "image_url" => "http://localhost:8000/public/productImages/5e49b1aa-dd5b-43e1-bdc0-5848ecdf42e1.png",
                "estimated_time" => "00:10:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Pescado Frito",
                "description" => "prueba",
                "product_category_id" => 7,
                "price" => "450.00",
                "image_url" => "http://localhost:8000/public/productImages/4172d31b-a9b5-4b3c-a54c-799076de5669.png",
                "estimated_time" => "01:10:00",
                "score" => 0,
                "status" => true
            ],
            [
                "name" => "Pizza de Pollo",
                "description" => "prueba",
                "product_category_id" => 2,
                "price" => "660.00",
                "image_url" => "http://localhost:8000/public/productImages/6294e6bc-b6e2-442c-b781-69a0b70b3569.png",
                "estimated_time" => "00:30:00",
                "score" => 0,
                "status" => true
            ]
        ];

        foreach ($products as $product){
            Product::create([
                "name" => $product['name'],
                "description" => $product['description'],
                "product_category_id" => $product['product_category_id'],
                "price" => $product['price'],
                "image_url" => $product['image_url'],
                "estimated_time" => $product['estimated_time'],
                "score" => $product['score'],
                "status" => $product['status']
            ]);
        }

    }
}
