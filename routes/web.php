<?php

use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\PromotionController;
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



Auth::routes();

Route::get('/print/{id}',[PrintController::class,'print']);

Route::post('image/upload/store',[ImageUploadController::class, 'fileStore']);
Route::get('/sell', [SellController::class, 'index']);
Route::get('/loadUser', [SellController::class, 'loadUser']);

//=======

Route::apiResource('shop',ShopController::class);
Route::get('/getShop',[ShopController::class, 'getShop']);
Route::get('/getPhones',[ShopController::class, 'getPhones']);
Route::put('/phones',[ShopController::class, 'test']);
Route::delete('/phones',[ShopController::class, 'destroy_phone']);


//Route::get('/reports',[ReportController::class,'index'])->name('report.index');
Route::get('/getReport',[ReportController::class,'getReport'])->name('report.getReport');
Route::get('/getPaymentType',[ReportController::class,'getPaymentType']);
Route::get('/getSellers',[ReportController::class,'getSellers']);
Route::get('/getCustomers',[ReportController::class,'getCustomers']);
Route::get('/getOrderProducts',[ReportController::class,'getOrderProducts']);


//======= Prevent error when user refresh page, or let VueRouter handle the routes =====
Route::get('/{any}', function () {
    return view('dashboard');
})->where('any', '.*');




