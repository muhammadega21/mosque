<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::define('pengurus', function (User $user) {
            return $user->role === "pengurus";
        });
        Gate::define('jamaah', function (User $user) {

            return $user->role === "jamaah";
        });
    }
}
