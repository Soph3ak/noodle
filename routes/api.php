<?php

use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\TableController;
use App\Http\Controllers\API\ShopController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\API\ReportController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//==========/ CategoryController /==========//
Route::apiResource('category',CategoryController::class); //Category.vue
Route::get('/getCategoriesSelect2',[CategoryController::class,'getCategoriesSelect2'])->name('category.getCategoriesSelect2'); //Product.vue


//==========/ CustomerController /==========//
Route::apiResource('customer',CustomerController::class); //Customer.vue
Route::get('/getCustomers',[CustomerController::class,'getCustomers'])->name('customer.getCustomer'); //Customer.vue
Route::get('/getCustomerOrders',[CustomerController::class,'getCustomerOrders']); //Customer.vue


//==========/ ProductController /==========//
Route::apiResource('product',ProductController::class);
Route::get('/getProduct',[ProductController::class,'getProduct'])->name('product.getProduct');

//==========/ ShopController /==========//
Route::apiResource('shop',ShopController::class);
Route::get('/getShop',[ShopController::class, 'getShop']);
Route::get('/getPhones',[ShopController::class, 'getPhones']);
Route::put('/phones',[ShopController::class, 'test']);
Route::delete('/phones',[ShopController::class, 'destroy_phone']);



//-------------/ ImageUploadController /----------------//
Route::post('/files', [ImageUploadController::class,'fileStore']);
Route::delete('/files/{file}', [ImageUploadController::class,'deleteFile']);

//-------------/ SellController /----------------//
Route::get('/loadCategoriesSell',[SellController::class,'loadCategoriesSell']);
Route::get('/loadAllProducts',[SellController::class,'loadAllProducts']);
Route::get('/loadProductsByCategory/{cate}',[SellController::class,'loadProductsByCategory']);

//-------------/ OrderController /----------------//
Route::post('/save-order', [OrderController::class,'saveOrder']);

//-------------/ TableController /----------------//
Route::apiResource('seat',TableController::class);
Route::get('/loadSeats',[TableController::class,'loadSeats']); //Seat.vue , Report.vue
Route::get('/getSeatTable',[TableController::class,'getSeatTable']); //SeatTable.vue

//==========/ ReportController /==========//
Route::get('/getReport',[ReportController::class,'getReport'])->name('report.getReport');
Route::get('/getPaymentType',[ReportController::class,'getPaymentType']);
Route::get('/getSellers',[ReportController::class,'getSellers']);
Route::get('/getCustomersHasOrders',[ReportController::class,'getCustomers']);
Route::get('/getOrderProducts',[ReportController::class,'getOrderProducts']);


















