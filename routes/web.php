<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\api\TableController;

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

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::apiResource('customer',CustomerController::class);
Route::get('/getCustomer',[CustomerController::class,'getCustomer'])->name('customer.getCustomer');

Route::apiResource('seatTable',TableController::class);
Route::get('/getSeatTable',[TableController::class,'getSeatTable']);



Route::apiResource('product',ProductController::class);
Route::get('/getProduct',[ProductController::class,'getProduct'])->name('product.getProduct');

Route::post('image/upload/store',[App\Http\Controllers\ImageUploadController::class, 'fileStore']);


Route::get('/sell', [App\Http\Controllers\SellController::class, 'index']);

