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
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::with('author')->latest()->paginate(20)
        ]);
    }

    /**
    * Display the specified resource.
    */
    public function show(Request $request, Post $post)
    {
        return view('posts.show', [
            'post' => $post,
            'comments' => $post->comments()->with('author')->latest()->paginate(50)
        ]);
    }
}
