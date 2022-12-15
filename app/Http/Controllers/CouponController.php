<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivateCouponRequest;
use App\Http\Requests\CouponStoreRequest;
use App\Http\Requests\CouponUpdateRequest;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{

    public function getInactiveCoupons()
    {

        try {

            $coupons = Coupon::where('status', '=', false)->where('show_coupon', '=', true)->get();

//            if($coupons->count() == 0)
//                return response()->json([
//                    "data" => null,
//                    "message" => "No hay inactivos cupones en la base de datos"
//                ], 404);

            return response()->json([
                "data" => $coupons,
                "message" => "Cupones encontrados correctamente"
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

    public function getActiveCoupons()
    {

        try {

            $coupons = Coupon::where('status', '=', true)->where('show_coupon', '=', true)->get();

//            if($coupons->count() == 0)
//                return response()->json([
//                    "data" => null,
//                    "message" => "No hay activos cupones en la base de datos"
//                ], 404);

            return response()->json([
                "data" => $coupons,
                "message" => "Cupones encontrados correctamente"
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

    public function activateCoupon(ActivateCouponRequest $request){

        try {

            DB::beginTransaction();

            $coupon_id = $request->all();

            $coupon = Coupon::where('coupon_id', '=', $coupon_id)->update([
                "show_coupon" => true
            ]);

            if(!$coupon)
                return response()->json([
                    "data" => null,
                    "message" => "El cupon no pudo ser agregado"
                ], 400);

            DB::commit();

            return response()->json([
                "data" => $request->all(),
                "message" => "Cupon agregado correctamente"
            ], 200);

        } catch (\Exception $e){

            DB::rollBack();

            throw new \Exception($e);

        }

    }

    public function store(CouponStoreRequest $request)
    {

        try {

            DB::beginTransaction();

            $object = [
                "coupon_id" => strtoupper(uuid_create()),
                "description" => $request['description'],
                "percent" => $request['percent'],
                "product_category_id" => $request['product_category_id'],
                "number_of_days" => $request['number_of_days'],
                "color" => $request['color'],
                "status" => false,
                "show_coupon" => true
            ];

            $coupon = Coupon::create($object);

            if(!$coupon)
                return response()->json([
                    "data" => null,
                    "message" => "No se pudo crear el cupon"
                ], 400);

            DB::commit();

            return response()->json([
                "data" => $coupon,
                "message" => "Cupon creado correctamente"
            ], 201);

        } catch (\Exception $e){

            DB::rollBack();

            throw new \Exception($e);

        }

    }

    public function show($id)
    {
        try {

            $coupon = Coupon::findOrFail($id);

            if(!$coupon)
                return response()->json([
                    "data" => null,
                    "message" => `El cupon con el id: ${$id} no pudo ser encontrado`
                ], 404);

            return response()->json([
                "data" => $coupon,
                "message" => "Cupon encontrado correctamente"
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }
    }

    public function update($id, CouponUpdateRequest $request)
    {
        try {

            DB::beginTransaction();

            if($request['status'] == false){

                $coupon = Coupon::where('id', '=', $id)->update($request->all());

                $category = Coupon::findOrFail($id)->product_category_id;

                $product_categories = DB::table('product_categories')
                    ->join('products', 'products.product_category_id', '=', 'product_categories.id')
                    ->select('products.id as product_id', 'products.name as product_name', 'products.discount')
                    ->where('product_categories.id', '=', $category)
                    ->get();

                foreach ($product_categories as $productCategory) {

                    Product::where('id', '=', $productCategory->product_id)->update([
                        "discount" => null
                    ]);

                }

            } else {

                $coupon = Coupon::where('id', '=', $id)->update($request->all());

                $discount = Coupon::findOrFail($id)->percent;
                $category = Coupon::findOrFail($id)->product_category_id;

                $product_categories = DB::table('product_categories')
                    ->join('products', 'products.product_category_id', '=', 'product_categories.id')
                    ->select('products.id as product_id', 'products.name as product_name', 'products.discount')
                    ->where('product_categories.id', '=', $category)
                    ->get();

                foreach ($product_categories as $productCategory) {

                    Product::where('id', '=', $productCategory->product_id)->update([
                        "discount" => $discount
                    ]);

                }

            }

            if(!$coupon)
                return response()->json([
                    "data" => null,
                    "message" => "No se pude actualizar el cupon"
                ], 400);

            DB::commit();

            return response()->json([
                "data" => $request->all(),
                "message" => "Cupon actualizado correctamente"
            ], 200);

        } catch (Exception $e){

            DB::rollBack();

            throw new \Exception($e);

        }
    }

    public function destroy($id)
    {
        try {

            $coupon = Coupon::findOrFail($id);

            $coupon->delete();

            return response()->json([
                "data" => $coupon,
                "message" => 'El cupon fue eliminado correctamente'
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }
    }

}
