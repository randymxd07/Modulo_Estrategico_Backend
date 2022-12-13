<?php

use App\Http\Controllers\CouponController;
use Illuminate\Support\Facades\Route;

/*---------------------------------------------
    Route: http://localhost:8000/api/coupons
-----------------------------------------------*/
Route::group([
    'middleware' => 'jwt.verify',
],function () {
    Route::group([
        'prefix' => 'coupons',
    ], function () {
        Route::get('/getInactiveCoupons', [CouponController::class, 'getInactiveCoupons']);
        Route::get('/getActiveCoupons', [CouponController::class, 'getActiveCoupons']);
        Route::post('/', [CouponController::class, 'store']);
        Route::get('/{id}', [CouponController::class, 'show']);
        Route::put('/{id}', [CouponController::class, 'update']);
        Route::delete('/{id}', [CouponController::class, 'destroy']);
    });
});
