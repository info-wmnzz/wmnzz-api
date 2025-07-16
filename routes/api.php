<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomePage\CustomerHomePageController;
use App\Http\Controllers\Api\PeriodController;
use Illuminate\Support\Facades\Route;

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


Route::middleware('auth:api')->group(function () {
    Route::post('/periods', [PeriodController::class, 'store'])->name('add-periods-detail');
    Route::get('/getUserDetails', [AuthController::class, 'getUserDetails'])->name('get-user-detail');
    Route::post('/updatePeriodsRection', [PeriodController::class, 'updatePeriodsRection'])->name('update-periods-rection');
    Route::post('/updateProfile', [AuthController::class, 'updateProfile'])->name('update-profile');
    Route::get('/periodsHistory', [PeriodController::class, 'previousPeriods'])->name('periods-history');
    Route::post('/delteAccount', [AuthController::class, 'deleteAccount'])->name('delete-account');
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/login-mobile', [AuthController::class, 'loginWithMobile']);

// Register apis

Route::post('/signup', [AuthController::class, 'signUpWithMobile']);
Route::post('/otp-verification', [AuthController::class, 'otpVerification']);

Route::get('/catgroy-list', [CustomerHomePageController::class, 'getCatgorys']);
Route::get('/products-list', [CustomerHomePageController::class, 'getProducts']);
Route::get('/category-with-products', [CustomerHomePageController::class, 'getCategoryWithProducts']);
