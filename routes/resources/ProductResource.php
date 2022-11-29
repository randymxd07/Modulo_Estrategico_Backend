<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*----------------------------------------------
    Route: http://localhost:8000/api/products
------------------------------------------------*/
Route::group([
    'middleware' => 'jwt.verify',
],function () {
    Route::group([
        'prefix' => 'products',
    ], function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::post('/', [ProductController::class, 'store']);
        Route::get('/{id}', [ProductController::class, 'show']);
        Route::get('/byCategory/{id}', [ProductController::class, 'byCategory']);
        Route::put('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'destroy']);
    });
});
