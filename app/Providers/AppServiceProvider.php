<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // 1. 引用 Gate
use App\Models\User;                   // 2. 引用 User Model

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 3. 在 boot() 方法中定義我們的權限
        Gate::define('access-admin-panel', function (User $user) {
            return $user->role->name === 'Admin';
        });
    }
}