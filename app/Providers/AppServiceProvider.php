<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Post;
use App\User;
use App\Comment;
use App\Observers\PostObserver;
use App\Observers\UserObserver;
use App\Observers\CommentObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Post::observe(PostObserver::class);
        User::observe(UserObserver::class);
        Comment::observe(CommentObserver::class);
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
