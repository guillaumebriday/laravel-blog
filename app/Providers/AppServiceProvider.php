<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        Schema::defaultStringLength(191);

        $this->app->bind('path.public', function () {
            return base_path().'/../'.config('hosting.root_folder_name');
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
