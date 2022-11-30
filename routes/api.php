<?php

use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\TransactionController;
use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\User\MyOrderController;
use App\Http\Controllers\Api\User\OrderProductController;
use App\Http\Controllers\Api\User\ProductController as UserProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::prefix('admin')->group(function () {
        Route::resource('product', ProductController::class);
        Route::resource('transaction', TransactionController::class);
    });

    Route::get('my-order', [MyOrderController::class, 'index']);
    Route::post('process-payment', [MyOrderController::class, 'processPaymentOrder']);
    Route::post('order-product/{id}', [OrderProductController::class, 'store']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('products', [UserProductController::class, 'index']);
Route::get('product/{id}', [UserProductController::class, 'show']);