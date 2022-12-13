<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponStoreRequest;
use App\Http\Requests\CouponUpdateRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{

    public function getInactiveCoupons()
    {

        try {

            $coupons = Coupon::where('status', '=', false)->get();

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

            $coupons = Coupon::where('status', '=', true)->get();

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

    public function store(CouponStoreRequest $request)
    {

        try {

            DB::beginTransaction();

            $coupon = Coupon::create($request->validated());

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

            $coupon = Coupon::where('id', '=', $id)->update($request->all());

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
