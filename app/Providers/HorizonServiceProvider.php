<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class HorizonServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if (!app()->environment('local')) {
            Horizon::auth(fn ($request): bool => auth()->check() && auth()->user()->isAdmin());
        }
    }
}
