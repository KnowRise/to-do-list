<?php

use App\Http\Controllers\Frontend\JobController as FrontendJobController;
use App\Http\Controllers\Backend\v1\JobController as BackendJobController;
use App\Http\Controllers\Backend\v1\TaskController;
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
    Route::prefix('jobs')->group(function () {
        Route::controller(FrontendJobController::class)->group(function () {
            Route::get('/{id}', 'detail')->name('jobs.detail');
        });
        Route::controller(BackendJobController::class)->group(function () {
            Route::post('/{id?}', 'storeJob')->name('jobs.store');
        });
        Route::prefix('tasks')->group(function () {
            Route::controller(TaskController::class)->group(function () {
                Route::post('/submit', 'submitTasks')->name('tasks.submit');
            });
        });
    });
});
