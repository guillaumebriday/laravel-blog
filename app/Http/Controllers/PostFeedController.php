<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Facades\Cache;

class PostFeedController extends Controller
{
    /**
     * Show the rss feed of posts.
     *
     * @return Response
     */
    public function index()
    {
        $posts = Cache::remember('feed-posts', 60, function () {
            return Post::latest()->limit(20)->get();
        });

        return response()->view('posts_feed.index', [
            'posts' => $posts
        ], 200)->header('Content-Type', 'text/xml');
    }
}
