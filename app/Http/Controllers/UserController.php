<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Log;

class UserController extends Controller
{

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = auth()->user();

        return response()->json([
            "token" => $token,
            "user" => $user
        ]);

    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json([
            'user' => $user,
            "token" => JWTAuth::fromUser($user)
        ]);

    }


    public function register(Request $request)
    {

        Log::info($request);
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $user = User::create([
            'fullname' => $request['fullname'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        $random_product_category_id = rand(1, 15);

        $product_category = ProductCategory::findOrFail($random_product_category_id)->name;

        $couponData = [
            "coupon_id" => strtoupper(uuid_create()),
            "description" => "Cupon de bienvenida para comprar ".strtolower($product_category),
            "percent" => 30,
            "product_category_id" => $random_product_category_id,
            "number_of_days" => 3,
            "color" => "warning",
            "status" => false,
            "show_coupon" => false,
        ];

        Coupon::create($couponData);

        Mail::send('emails.SendCouponByRegisterEmail', compact(["couponData"]),
        function($message){
            $message->to('randym0624@gmail.com')
            ->subject('Aquí te va un regalo!!!');
        });

        return response()->json(compact('user','token'),201);

    }

}

