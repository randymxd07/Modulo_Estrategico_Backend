<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderVsProduct;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Request $request)
    {

        try {

            if($request->query('limit') || $request->query('offset')){

                $orders = DB::table('orders')->orderBy('id', 'desc')
                    ->offset($request->query('offset'))
                    ->limit($request->query('limit'))
                    ->get();

            } else {

                $orders = DB::table('orders')->orderBy('id', 'desc')->get();

            }

            foreach ($orders as $order){

                $orderDetails = OrderVsProduct::join('products', 'products.id', '=', 'order_vs_products.product_id')
                    ->select(
                        'products.id as product_id',
                        'products.name as product_name',
                        'order_vs_products.quantity',
                        'products.price as product_price',
                        'products.estimated_time',
                        'order_vs_products.discount'
                    )
                    ->where('order_id', '=', $order->id)
                    ->get();

                $order->fullname = auth()->user()->fullname;
                $order->order_details = $orderDetails;

            }

            if($orders->count() == 0)
                return response()->json([
                    "data" => null,
                    "message" => "No hay ordenes en la base de datos"
                ], 404);

            return response()->json([
                "data" => $orders,
                "message" => "Ordenes encontradas correctamente"
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

    public function getLastFour(){

        try {

            $lastFourOrders = DB::table('orders')->orderBy('id', 'desc')->take(4)->get();

            foreach ($lastFourOrders as $order){

                $orderDetails = OrderVsProduct::join('products', 'products.id', '=', 'order_vs_products.product_id')
                    ->select(
                        'products.id as product_id',
                        'products.name as product_name',
                        'order_vs_products.quantity',
                        'products.price as product_price',
                        'products.estimated_time'
                    )
                    ->where('order_id', '=', $order->id)
                    ->get();

                $order->fullname = auth()->user()->fullname;
                $order->order_details = $orderDetails;

            }

            if($lastFourOrders->count() == 0)
                return response()->json([
                    "data" => null,
                    "message" => "No hay ordenes en la base de datos"
                ], 404);

            return response()->json([
                "data" => $lastFourOrders,
                "message" => "Ordenes encontradas correctamente"
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

    public function store(OrderStoreRequest $request)
    {

        try {

            DB::beginTransaction();

            $orderData = [
                "order_type_id" => $request['order_type_id'],
                "user_id" => auth()->user()->id,
                "payment_method_id" => $request['payment_method_id'],
                "longitude" => $request['longitude'],
                "latitude" => $request['latitude'],
                "status" => $request['status']
            ];

            $order = Order::create($orderData);

            foreach ($request['order_details'] as $order_detail){

                $orderDetails = [
                    "order_id" => $order->id,
                    "product_id" => $order_detail['product_id'],
                    "quantity" => $order_detail['quantity'],
                    "discount" => $order_detail['discount'],
                ];

                OrderVsProduct::create($orderDetails);

            }

            if(!$order)
                return response()->json([
                    "data" => null,
                    "message" => "No se pudo crear la orden"
                ], 400);

            DB::commit();

            $sendOrder = Order::findOrFail($order['id']);

            $orderDetails = OrderVsProduct::join('products', 'products.id', '=', 'order_vs_products.product_id')
                ->select(
                    'products.id as product_id',
                    'products.name as product_name',
                    'order_vs_products.quantity',
                    'products.price as product_price',
                    'products.estimated_time'
                )
                ->where('order_id', '=', $order['id'])
                ->get();

            $sendOrder->fullname = auth()->user()->fullname;
            $sendOrder->order_details = $orderDetails;

            Mail::send('emails.OrderEmail', compact(["sendOrder"]),
            function($message){
                $message->to('randym0624@gmail.com')
                ->subject('Tu orden ha sido enviada!!!');
            });

            $numberOfOrders = Order::all()->count();

            if($numberOfOrders%10 == 0){

                $random_number_of_days = rand(1, 3);
                $random_percent = rand(20, 40);
                $random_product_category_id = rand(1, 15);

                $product_category = ProductCategory::findOrFail($random_product_category_id)->name;

                $couponData = [
                    "coupon_id" => strtoupper(uuid_create()),
                    "description" => "Cupon de descuento para comprar ".strtolower($product_category),
                    "percent" => $random_percent,
                    "product_category_id" => $random_product_category_id,
                    "number_of_days" => $random_number_of_days,
                    "color" => "warning",
                    "status" => false,
                    "show_coupon" => false,
                ];

                Coupon::create($couponData);

                Mail::send('emails.SendCouponByQuantityOfPurchasesEmail', compact(["couponData"]),
                function($message){
                    $message->to('randym0624@gmail.com')
                    ->subject('Aquí te va un regalo!!!');
                });

            }

            return response()->json([
                "data" => $order,
                "message" => "Orden creada correctamente"
            ], 201);

        } catch (\Exception $e){

            DB::rollBack();

            throw new \Exception($e);

        }

    }

    public function  sendOrderInPreparationEmail($id){

        $sendOrder = Order::findOrFail($id);

        $orderDetails = OrderVsProduct::join('products', 'products.id', '=', 'order_vs_products.product_id')
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'order_vs_products.quantity',
                'products.price as product_price',
                'products.estimated_time'
            )
            ->where('order_id', '=', $id)
            ->get();

        $sendOrder->fullname = auth()->user()->fullname;
        $sendOrder->order_details = $orderDetails;

        Mail::send('emails.InPreparationOrderEmail', compact(["sendOrder"]),
        function($message){
            $message->to('randym0624@gmail.com')
                ->subject('Tu orden esta siendo preparada!!!');
        });

        return response()->json([
            "data" => $orderDetails,
            "message" => "Tu orden esta siendo preparada"
        ], 201);

    }

    public function  sendOrderFinishedEmail($id){

        $sendOrder = Order::findOrFail($id);

        $orderDetails = OrderVsProduct::join('products', 'products.id', '=', 'order_vs_products.product_id')
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'order_vs_products.quantity',
                'products.price as product_price',
                'products.estimated_time'
            )
            ->where('order_id', '=', $id)
            ->get();

        $sendOrder->fullname = auth()->user()->fullname;
        $sendOrder->order_details = $orderDetails;

        Mail::send('emails.FinishedOrderEmail', compact(["sendOrder"]),
        function($message){
            $message->to('randym0624@gmail.com')
                ->subject('Tu orden esta lista!!!');
        });

        return response()->json([
            "data" => $orderDetails,
            "message" => "Tu orden esta lista"
        ], 201);

    }

    public function show($id)
    {

        try {

            $order = Order::findOrFail($id);

            $orderDetails = OrderVsProduct::join('products', 'products.id', '=', 'order_vs_products.product_id')
                ->select(
                    'products.id as product_id',
                    'products.name as product_name',
                    'order_vs_products.quantity',
                    'products.price as product_price',
                    'products.estimated_time',
                    'order_vs_products.discount'
                )
                ->where('order_id', '=', $order->id)
                ->get();

            $order->fullname = auth()->user()->fullname;
            $order->order_details = $orderDetails;

            if(!$order)
                return response()->json([
                    "data" => null,
                    "message" => `La orden con el id: ${$id} no pudo ser encontrada`
                ], 404);

            return response()->json([
                "data" => $order,
                "message" => "Orden encontrada correctamente"
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

    public function update($id, OrderUpdateRequest $request)
    {

        try {

            DB::beginTransaction();

            $orderData = [
                "order_type_id" => $request['order_type_id'],
                "user_id" => auth()->user()->id,
                "payment_method_id" => $request['payment_method_id'],
                "longitude" => $request['longitude'],
                "latitude" => $request['latitude'],
                "status" => $request['status']
            ];

            $order = Order::where('id', '=', $id)->update($orderData);

            foreach ($request['order_details'] as $order_detail){

                $orderDetails = [
                    "order_id" => $id,
                    "product_id" => $order_detail['product_id'],
                    "quantity" => $order_detail['quantity']
                ];

                OrderVsProduct::where('id', '=', $id)->update($orderDetails);

            }

            if(!$order)
                return response()->json([
                    "data" => null,
                    "message" => "No se pudo actualizar la orden"
                ], 400);

            DB::commit();

            return response()->json([
                "data" => $request->all(),
                "message" => "Orden actualizada correctamente"
            ], 201);

        } catch (\Exception $e){

            DB::rollBack();

            throw new \Exception($e);

        }

    }

    public function destroy($id)
    {

        try {

            $order = Order::findOrFail($id);

            $orderVsProducts = OrderVsProduct::where('order_id', '=', $order['id'])->get();

            $orderDetails = OrderVsProduct::join('products', 'products.id', '=', 'order_vs_products.product_id')
                ->select(
                    'products.id as product_id',
                    'products.name as product_name',
                    'order_vs_products.quantity',
                    'products.price as product_price'
                )
                ->where('order_id', '=', $order->id)
                ->get();

            $order->fullname = auth()->user()->fullname;
            $order->order_details = $orderDetails;

            foreach ($orderVsProducts as $orderVsProduct){
                $orderVsProduct->delete();
            }

            $order->delete();

            return response()->json([
                "data" => $order,
                "message" => 'La orden fue eliminada correctamente'
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

}
