<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();



Route::middleware('add.token')->group(function () {
    Route::get('/', [App\Http\Controllers\User\RestaurantController::class,'index']);
    Route::resource('/user/restaurant', App\Http\Controllers\User\RestaurantController::class);
    Route::resource('/user/payment', App\Http\Controllers\User\PaymentController::class);
    Route::resource('/user/allorder', App\Http\Controllers\User\OrderController::class);
    Route::get('/payment/{id}', [App\Http\Controllers\User\RestaurantController::class,'payment']);
});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['add.token','role:admin|Manager|Super Administrator']
],function() {
    Route::resource('/order', App\Http\Controllers\Admin\OrderController::class);
    Route::resource('/report', App\Http\Controllers\Admin\ReportController::class);
    Route::resource('restaurant', App\Http\Controllers\Admin\RestaurantController::class);
});

Route::post('/pay', [App\Http\Controllers\User\PayPalController::class,'pay'])->name('payment');
Route::get('success', [App\Http\Controllers\User\PayPalController::class,'success'])->name('success');
Route::get('error', [App\Http\Controllers\User\PayPalController::class,'error'])->name('error');