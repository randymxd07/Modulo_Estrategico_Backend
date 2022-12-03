<?php

use App\Http\Controllers\PaymentMethodController;
use Illuminate\Support\Facades\Route;

/*-----------------------------------------------------
    Route: http://localhost:8000/api/payment-methods
-------------------------------------------------------*/
Route::group([
    'middleware' => 'jwt.verify',
],function () {
    Route::group([
        'prefix' => 'payment-methods',
    ], function () {
        Route::get('/', [PaymentMethodController::class, 'index']);
        Route::post('/', [PaymentMethodController::class, 'store']);
        Route::get('/{id}', [PaymentMethodController::class, 'show']);
        Route::put('/{id}', [PaymentMethodController::class, 'update']);
        Route::delete('/{id}', [PaymentMethodController::class, 'destroy']);
    });
});
