<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;

class PostsController extends Controller
{
    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        return view('posts.index', [
            'posts' => Post::search($request->input('q'))
                             ->with('author', 'media')
                             ->withCount('comments')
                             ->latest()
                             ->paginate(20)
        ]);
    }

    /**
    * Display the specified resource.
    */
    public function show(Request $request, Post $post)
    {
        $post->comments_count = $post->comments()->count();
        return view('posts.show', [
            'post' => $post
        ]);
    }
}
