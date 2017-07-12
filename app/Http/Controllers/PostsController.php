<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Post;

class PostsController extends Controller
{
    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('posts.index')->with([
            'posts' => Post::with('author')->latest()->paginate(20)
        ]);
    }

    /**
    * Show the rss feed of posts.
    *
    * @return Response
    */
    public function feed()
    {
        $posts = Cache::remember('feed-posts', 60, function () {
            return Post::latest()->limit(20)->get();
        });

        return response()->view('posts.feed', [
            'posts' => $posts
        ], 200)->header('Content-Type', 'text/xml');
    }

    /**
    * Display the specified resource.
    */
    public function show(Request $request, Post $post)
    {
        return view('posts.show')->with([
            'post' => $post,
            'comments' => $post->comments()->with('author')->latest()->paginate(50)
        ]);
    }
}
