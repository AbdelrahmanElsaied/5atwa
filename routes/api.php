<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
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

Route::resources([
    "products"=>"ProductController",
    "categories"=>"CategoryController",
    "orders"=>"OrderController",
    "carts"=>"CartController",
    "wishlists"=>"WishlistController"

]);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
