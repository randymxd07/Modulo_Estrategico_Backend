<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use App\Models\OrderVsProduct;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index()
    {

        try {

            $orders = DB::table('orders')->orderBy('id', 'desc')->get();

            foreach ($orders as $order){

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

            $lastFourOrders = Order::latest()->take(4)->get();

            foreach ($lastFourOrders as $order){

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
                    "quantity" => $order_detail['quantity']
                ];

                OrderVsProduct::create($orderDetails);

            }

            if(!$order)
                return response()->json([
                    "data" => null,
                    "message" => "No se pudo crear la orden"
                ], 400);

            DB::commit();

            return response()->json([
                "data" => $order,
                "message" => "Orden creada correctamente"
            ], 201);

        } catch (\Exception $e){

            DB::rollBack();

            throw new \Exception($e);

        }

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
                    'products.price as product_price'
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
