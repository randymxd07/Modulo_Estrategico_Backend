<?php

use App\Http\Controllers\ProductCategoryController;
use Illuminate\Support\Facades\Route;

/*--------------------------------------------------------
    Route: http://localhost:8000/api/product-categories
----------------------------------------------------------*/
Route::group([
    'middleware' => 'jwt.verify',
],function () {
    Route::group([
        'prefix' => 'product-categories',
    ], function () {
        Route::get('/', [ProductCategoryController::class, 'index']);
        Route::post('/', [ProductCategoryController::class, 'store']);
        Route::get('/{id}', [ProductCategoryController::class, 'show']);
        Route::put('/{id}', [ProductCategoryController::class, 'update']);
        Route::delete('/{id}', [ProductCategoryController::class, 'destroy']);
    });
});
