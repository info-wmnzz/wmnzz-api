<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomePage\CustomerHomePageController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login-mobile', [AuthController::class, 'loginWithMobile']);

// Register apis

Route::post('/signup', [AuthController::class, 'signUpWithMobile']);
Route::post('/otp-verification', [AuthController::class, 'otpVerification']);

Route::get('/catgroy-list',[CustomerHomePageController::class,'getCatgorys']);
Route::get('/products-list',[CustomerHomePageController::class,'getProducts']);
Route::get('/category-with-products',[CustomerHomePageController::class,'getCategoryWithProducts']);



