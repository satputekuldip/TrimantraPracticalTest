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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>'auth'],function () {


    Route::delete('product-categories/destroy', [App\Http\Controllers\CategoryController::class, 'massDestroy'])->name('categories.massDestroy');
    Route::post('product-categories/media', [App\Http\Controllers\CategoryController::class, 'storeMedia'])->name('categories.storeMedia');
    Route::resource('categories', App\Http\Controllers\CategoryController::class);

    Route::delete('products/destroy', [App\Http\Controllers\ProductController::class, 'massDestroy'])->name('products.massDestroy');
    Route::post('products/media', [App\Http\Controllers\ProductController::class, 'storeMedia'])->name('products.storeMedia');
    Route::resource('products', App\Http\Controllers\ProductController::class);
});


