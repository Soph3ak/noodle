<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\API\CategoryController;

use App\Http\Controllers\SellController;
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

Route::post('/files', [ImageUploadController::class,'fileStore']);
Route::delete('/files/{file}', [ImageUploadController::class,'deleteFile']);

Route::apiResource('category',CategoryController::class);
Route::get('/getCategoriesSelect2',[CategoryController::class,'getCategoriesSelect2'])->name('category.getCategoriesSelect2');

Route::get('/loadCategoriesSell',[SellController::class,'loadCategoriesSell']);
Route::get('/loadAllProducts',[SellController::class,'loadAllProducts']);
Route::get('/loadProductsByCategory/{cate}',[SellController::class,'loadProductsByCategory']);





