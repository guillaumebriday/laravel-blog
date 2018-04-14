<?php

namespace App\Providers;

use App\Comment;
use App\Media;
use App\Observers\CommentObserver;
use App\Observers\MediaObserver;
use App\Observers\PostObserver;
use App\Observers\UserObserver;
use App\Post;
use App\User;
use Illuminate\Support\ServiceProvider;

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
        Media::observe(MediaObserver::class);
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
