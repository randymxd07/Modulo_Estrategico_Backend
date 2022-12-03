<?php

use App\Http\Controllers\OrderTypeController;
use Illuminate\Support\Facades\Route;

/*-------------------------------------------------
    Route: http://localhost:8000/api/order-types
---------------------------------------------------*/
Route::group([
    'middleware' => 'jwt.verify',
],function () {
    Route::group([
        'prefix' => 'order-types',
    ], function () {
        Route::get('/', [OrderTypeController::class, 'index']);
        Route::post('/', [OrderTypeController::class, 'store']);
        Route::get('/{id}', [OrderTypeController::class, 'show']);
        Route::put('/{id}', [OrderTypeController::class, 'update']);
        Route::delete('/{id}', [OrderTypeController::class, 'destroy']);
    });
});
