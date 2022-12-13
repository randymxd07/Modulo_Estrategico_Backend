<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponStoreRequest;
use App\Http\Requests\CouponUpdateRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    public function index()
    {

        try {

            $coupons = Coupon::all();

            if($coupons->count() == 0)
                return response()->json([
                    "data" => null,
                    "message" => "No hay cupones en la base de datos"
                ], 404);

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
        $coupon = Coupon::create($request->validated());

        $request->session()->flash('coupon.id', $coupon->id);

        return redirect()->route('coupon.index');
    }

    public function show(Request $request, Coupon $coupon)
    {
        return view('coupon.show', compact('coupon'));
    }

    public function update(CouponUpdateRequest $request, Coupon $coupon)
    {
        $coupon->update($request->validated());

        $request->session()->flash('coupon.id', $coupon->id);

        return redirect()->route('coupon.index');
    }

    public function destroy(Request $request, Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('coupon.index');
    }

}
