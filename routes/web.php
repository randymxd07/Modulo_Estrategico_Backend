<?php

use App\Models\Order;
use App\Models\OrderVsProduct;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::get('/orderEmail', function () {
//
//    $sendOrder = Order::findOrFail(57);
//
//    $orderDetails = OrderVsProduct::join('products', 'products.id', '=', 'order_vs_products.product_id')
//        ->select(
//            'products.id as product_id',
//            'products.name as product_name',
//            'order_vs_products.quantity',
//            'products.price as product_price',
//            'products.estimated_time'
//        )
//        ->where('order_id', '=', 57)
//        ->get();
//
//    $sendOrder->fullname = 'randy';
//    $sendOrder->order_details = $orderDetails;
//
//    return view('emails.OrderEmail', compact(["sendOrder"]));
//
//});
