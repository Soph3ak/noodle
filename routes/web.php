<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\PrintController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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



Auth::routes();

Route::get('/dashboard', [HomeController::class, 'index']);
Route::get('/sell', [SellController::class, 'index']);
Route::get('/print/{id}',[PrintController::class,'print']);
Route::post('image/upload/store',[ImageUploadController::class, 'fileStore']);


//======= Prevent error when user refresh page, or let VueRouter handle the routes =====
Route::get('/{any}', function () {
    return view('dashboard');
})->where('any', '.*');




