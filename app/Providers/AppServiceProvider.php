<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        URL::forceScheme('https');
        if (!app()->environment('local')) {
            URL::forceScheme('https');
        }
        //gates en Laravel
        Gate::define('ver-admin', function (User $user){
            return $user->rol === 'admin';
        });
        Gate::define('ver-ventas', function (User $user){
            return in_array($user->rol, ['admin', 'docente']);
        });
    }
}
