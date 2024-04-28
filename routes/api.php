<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login', [App\Http\Controllers\Auth\ApiAuthController::class,'login'])->name('login.api'); // tak perlu login
    Route::post('/register', [App\Http\Controllers\Auth\ApiAuthController::class,'register'])->name('register.api'); // tak perlu login
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [App\Http\Controllers\Auth\ApiAuthController::class,'logout'])->name('logout.api');
});

Route::get('/restaurant-main', [App\Http\Controllers\API\RestaurantController::class,'main']); // tak perlu login
Route::get('/restaurant-display/{id}', [App\Http\Controllers\API\RestaurantController::class,'display']); // tak perlu login
Route::post('/restaurant-search', [App\Http\Controllers\API\RestaurantController::class,'search'])->name('restaurant-search');

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/restaurant', App\Http\Controllers\API\RestaurantController::class);
    Route::resource('/food', App\Http\Controllers\API\FoodController::class);
    Route::resource('/user-order', App\Http\Controllers\API\UserOrderController::class);
    Route::get('/user-order', [App\Http\Controllers\API\UserOrderController::class, 'orderList']);
    Route::resource('/admin-order', App\Http\Controllers\API\OrderController::class);
    Route::post('/order/{id}/reject', [App\Http\Controllers\API\OrderController::class,'reject']);
    Route::resource('/report', App\Http\Controllers\API\ReportController::class);
});