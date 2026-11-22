<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class PostFeedController extends Controller
{
    /**
     * Show the rss feed of posts.
     */
    public function index(): Response
    {
        $feed = Cache::remember('posts-feed', now()->addHour(), fn () => view('posts_feed.index', [
            'posts' => Post::latest()->limit(20)->get(),
        ])->render());

        return response($feed)->header('Content-Type', 'text/xml');
    }
}
