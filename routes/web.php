<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageUploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TableController;
use App\Http\Controllers\API\ShopController;
use App\Http\Controllers\SellController;

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

Route::get('/test',[ProductController::class, 'test']);

Auth::routes();

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

Route::apiResource('customer',CustomerController::class);
Route::get('/getCustomer',[CustomerController::class,'getCustomer'])->name('customer.getCustomer');

Route::apiResource('seatTable',TableController::class);
Route::get('/getSeatTable',[TableController::class,'getSeatTable']);



Route::apiResource('product',ProductController::class);
Route::get('/getProduct',[ProductController::class,'getProduct'])->name('product.getProduct');

Route::post('image/upload/store',[ImageUploadController::class, 'fileStore']);


Route::get('/sell', [SellController::class, 'index']);
Route::get('/loadUser', [SellController::class, 'loadUser']);

Route::apiResource('shop',ShopController::class);
Route::get('/getShop',[ShopController::class, 'getShop']);
Route::get('/getPhones',[ShopController::class, 'getPhones']);
Route::put('/phones',[ShopController::class, 'test']);
Route::delete('/phones',[ShopController::class, 'destroy_phone']);

