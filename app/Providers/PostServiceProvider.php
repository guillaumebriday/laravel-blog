<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Post;
use Carbon\Carbon;

class PostServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Post::creating(function ($post) {
            $post->posted_at = Carbon::now();
        });
    }
}
