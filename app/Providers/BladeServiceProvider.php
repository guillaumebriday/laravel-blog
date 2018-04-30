<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        Blade::if('admin', function () {
            return Auth::check() && Auth::user()->isAdmin();
        });

        Blade::if('profile', function ($user) {
            return Auth::check() && Auth::user()->id == $user->id;
        });
    }
}
