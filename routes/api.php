<?php

use App\Http\Controllers\AdvertiseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VoucherCodeController;
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


Route::post('/register',[AuthController::class ,'register']);
Route::post('/login',[AuthController::class ,'login']);
Route::post('/update',[AuthController::class ,'update']);
Route::post('/forgot-password',[NewPasswordController::class ,'forgotPassword']);
Route::post('/reset-password',[NewPasswordController::class ,'reset'])->name('password.reset');
Route::get('/popular' , [OrderController::class , 'top']);
Route::resource('advertises' , AdvertiseController::class);



//Protected by auth:sanctum
// Route::group(['middleware' => ['auth:sanctum']], function () {
    //categories
    Route::resource('categories' , CategoryController::class);
    //products
    Route::resource('products' , ProductController::class);
    Route::get('/products/search/{name}',[ProductController::class ,'search']);
    Route::get('/products/searchByCategory/{cid}',[ProductController::class ,'searchByCategory']);
    //Favorite
    Route::resource('favorites' , FavoriteController::class);
    Route::delete('/favorites/delete' , [FavoriteController::class , 'destroy']);
    //Cart
    Route::resource('carts' , CartController::class);
    Route::delete('/carts/delete' , [CartController::class , 'destroy']);
    //Order
    Route::resource('orders' , OrderController::class);
    Route::delete('/orders/delete' , [OrderController::class , 'destroy']);
    //Voucher Code
    Route::get('/voucher-code/search/{code}',[VoucherCodeController::class ,'search']);
    //logout
    Route::post('/logout',[AuthController::class ,'logout']);
// });