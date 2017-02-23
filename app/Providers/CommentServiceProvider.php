<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Comment;
use Carbon\Carbon;

class CommentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Comment::creating(function ($comment) {
            $comment->posted_at = Carbon::now();
        });
    }
}
