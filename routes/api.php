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

Route::post('login', [\App\Http\Controllers\Api\Auth\LoginController::class, 'login']);
Route::post('refresh', [\App\Http\Controllers\Api\Auth\LoginController::class, 'refresh']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function (){
    Route::post('logout', [\App\Http\Controllers\Api\Auth\LoginController::class, 'logout']);

    Route::resource('categories', App\Http\Controllers\API\CategoryAPIController::class);


});



Route::resource('products', App\Http\Controllers\API\ProductAPIController::class);