<?php

use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageUploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TableController;
use App\Http\Controllers\API\ShopController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\ReportController;

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
Route::get('/tables',[TableController::class,'index']);
Route::get('/customer',[CustomerController::class,'index']);
Route::get('/product',[ProductController::class,'index']);
Route::get('/promotion',[PromotionController::class,'index']);








Route::post('image/upload/store',[ImageUploadController::class, 'fileStore']);


Route::get('/sell', [SellController::class, 'index']);
Route::get('/loadUser', [SellController::class, 'loadUser']);

Route::post('/invoice', [OrderController::class, 'invoice']);
Route::get('/invoice', [OrderController::class, 'invoice']);

//=======

Route::apiResource('shop',ShopController::class);
Route::get('/getShop',[ShopController::class, 'getShop']);
Route::get('/getPhones',[ShopController::class, 'getPhones']);
Route::put('/phones',[ShopController::class, 'test']);
Route::delete('/phones',[ShopController::class, 'destroy_phone']);


Route::get('/reports',[ReportController::class,'index'])->name('report.index');
Route::get('/getReport',[ReportController::class,'getReport'])->name('report.getReport');
Route::get('/getPaymentType',[ReportController::class,'getPaymentType']);
Route::get('/getSellers',[ReportController::class,'getSellers']);
Route::get('/getCustomers',[ReportController::class,'getCustomers']);
Route::get('/getOrderProducts',[ReportController::class,'getOrderProducts']);




