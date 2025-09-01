<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    return view('admin.auth.login');
})->name('admin.login');

Route::get('/', function () {
    return view('landingPage');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {
    Route::resource('banner', BannerController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class);
    Route::get('/settings', [AuthController::class, 'settingList'])->name('settings.index');

    
    Route::get('/admin/policy/{key}/edit', [AuthController::class, 'policyEdit'])->name('policy.edit');
    Route::put('/admin/policy/{key}', [AuthController::class, 'policyUpdate'])->name('policy.update');

});

Route::get('/termsAndCondition', [AuthController::class, 'termsAndConditions']);

Route::get('/privacy', [AuthController::class, 'privacyPolicy'])->name('privacy');
