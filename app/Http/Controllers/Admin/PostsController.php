<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;

class PostsController extends Controller
{
    /**
    * Show the application posts index.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $posts = Post::orderBy('posted_at', 'desc')->paginate(50);

        return view('admin.posts.index')->withPosts($posts);
    }
}
