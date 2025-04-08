<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('worker', function ($user) {
            return $user->role == 'worker';
        });

        Gate::define('tasker', function ($user) {
            return $user->role == 'tasker';
        });

        Gate::define('admin', function ($user) {
            return $user->role == 'admin';
        });
    }
}
