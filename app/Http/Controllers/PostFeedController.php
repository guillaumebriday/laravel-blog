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
        $posts = Cache::remember('feed-posts', 60, function () {
            return Post::latest()->limit(20)->get();
        });

        return response()->view('posts_feed.index', [
            'posts' => $posts
        ], 200)->header('Content-Type', 'text/xml');
    }
}
