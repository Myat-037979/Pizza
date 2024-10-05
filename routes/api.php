<?php

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RouteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!

 localhost:8000/api/category/delete (post)

 localhost:8000/api/category/details (post)

 localhost:8000/api/category/update (post)

 key
 {
    category_name
    category_id
 }
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('product/list',[RouteController::class,'productList']);
Route::get('category/list',[RouteController::class,'categoryList']);
Route::get('cart/list',[RouteController::class,'cartList']);
Route::get('contact/list',[RouteController::class,'contactList']);
Route::get('order/list',[RouteController::class,'orderList']);
Route::get('orderlist/list',[RouteController::class,'orderlistList']);
Route::get('user/list',[RouteController::class,'userList']); //read *

Route::post('create/category',[RouteController::class,'categoryCreate']);
Route::post('create/contact',[RouteController::class,'categoryContact']); //create


Route::post('category/delete',[RouteController::class,'deleteCategory']); //delete

Route::post('category/details',[RouteController::class,'categoryDetails']); // read

Route::post('category/update',[RouteController::class,'categoryUpdate']); // update
