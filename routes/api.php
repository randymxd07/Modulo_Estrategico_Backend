<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'authenticate']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('verify',[UserController::class, 'getAuthenticatedUser']);
});

require __DIR__.'/../routes/resources/ProductCategoryResource.php';

require __DIR__.'/../routes/resources/ProductResource.php';

require __DIR__.'/../routes/resources/OrderTypeResource.php';

require __DIR__.'/../routes/resources/PaymentMethodResource.php';

require __DIR__.'/../routes/resources/OrderResource.php';
