<?php

use App\Http\Controllers\Backend\v1\UserController;
use App\Http\Controllers\Frontend\JobController as FrontendJobController;
use App\Http\Controllers\Backend\v1\JobController as BackendJobController;
use App\Http\Controllers\Backend\v1\TaskController as BackendTaskController;
use App\Http\Controllers\Frontend\TaskController as FrontendTaskController;
use App\Http\Controllers\Frontend\AuthController as FrontendAuthController;
use App\Http\Controllers\Backend\v1\AuthController as BackendAuthController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return redirect()->route('login');
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [FrontendAuthController::class, 'login'])->name('login');
    Route::controller(BackendAuthController::class)->group(function () {
        Route::post('/login', 'login')->name('login');
        Route::post('/logout', 'logout')->name('logout')->middleware('auth');
    });
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::prefix('users')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::post('/{id?}', 'storeUser')->name('users.store');
            Route::post('/password/{id}', 'changePassword')->name('users.password');
            Route::delete('/{id}', 'deleteUser')->name('users.delete');
        });
    });
    Route::prefix('jobs')->group(function () {
        Route::controller(FrontendJobController::class)->group(function () {
            Route::get('/{id}', 'detail')->name('jobs.detail');
        });
        Route::controller(BackendJobController::class)->group(function () {
            Route::post('/{id?}', 'storeJob')->name('jobs.store');
            Route::delete('/{id}', 'deleteJob')->name('jobs.delete');
        });
        Route::prefix('tasks')->group(function () {
            Route::controller(FrontendTaskController::class)->group(function () {
                Route::get('/{id}', 'detail')->name('tasks.detail');
            });
            Route::controller(BackendTaskController::class)->group(function () {
                Route::post('/store/{id?}', 'storeTask')->name('tasks.store');
                Route::post('/status{id}', 'updateStatus')->name('tasks.status');
                Route::post('/submit', 'submitTasks')->name('tasks.submit');
                Route::delete('/{id}', 'deleteTask')->name('tasks.delete');
            });
            Route::prefix('users')->group(function () {
                Route::controller(BackendTaskController::class)->group(function () {
                    Route::post('/{id}', 'storeUserTask')->name('tasks.users.store');
                    Route::delete('/{id}', 'deleteUserTask')->name('tasks.users.delete');
                });
            });
        });
    });
});

Route::prefix('data')->group(function () {
    Route::get('/users/{id?}', [UserController::class, 'users']);
    Route::get('/tasks', [BackendTaskController::class, 'tasks']);
});
