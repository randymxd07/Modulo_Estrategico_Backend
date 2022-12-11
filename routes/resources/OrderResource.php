<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*--------------------------------------------
    Route: http://localhost:8000/api/orders
----------------------------------------------*/
Route::group([
    'middleware' => 'jwt.verify',
],function () {
    Route::group([
        'prefix' => 'orders',
    ], function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::get('/getLastFour', [OrderController::class, 'getLastFour']);
        Route::post('/', [OrderController::class, 'store']);
        Route::post('/sendOrderInPreparationEmail/{id}', [OrderController::class, 'sendOrderInPreparationEmail']);
        Route::post('/sendOrderFinishedEmail/{id}', [OrderController::class, 'sendOrderFinishedEmail']);
        Route::get('/{id}', [OrderController::class, 'show']);
        Route::put('/{id}', [OrderController::class, 'update']);
        Route::delete('/{id}', [OrderController::class, 'destroy']);
    });
});
