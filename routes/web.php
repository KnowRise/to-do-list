<?php

use App\Http\Controllers\Frontend\AuthController as FrontendAuthController;
use App\Http\Controllers\Backend\v1\AuthController as BackendAuthController;
use App\Http\Controllers\Frontend\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [FrontendAuthController::class, 'login'])->name('login');
    Route::controller(BackendAuthController::class)->group(function () {
        Route::post('/login', 'login')->name('backend.login');
        Route::post('/logout', 'logout')->name('backend.logout')->middleware('auth');
    });
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});
