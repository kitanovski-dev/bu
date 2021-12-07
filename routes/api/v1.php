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

Route::get('/ping', function () {
    return response()->json([
        'pong'  =>  time()
    ]);
});

// Public routes
Route::group(['namespace' => 'Auth'], function () {
    Route::post('/register', RegisterUserAction::class);
    Route::post('/login', LoginUserAction::class);
});

// Private routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['namespace' => 'Order'], function () {
        Route::post('/order', CreateOrderAction::class);
        Route::post('/cancel', CreateOrderAction::class);
    });
});
