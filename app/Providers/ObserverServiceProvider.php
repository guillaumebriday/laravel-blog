<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Post;
use App\User;
use App\Comment;
use App\Observers\PostObserver;
use App\Observers\UserObserver;
use App\Observers\CommentObserver;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Post::observe(PostObserver::class);
        User::observe(UserObserver::class);
        Comment::observe(CommentObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
