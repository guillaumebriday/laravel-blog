<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Post;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Post::creating(function ($post) {
            $post->posted_at = Carbon::now();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
