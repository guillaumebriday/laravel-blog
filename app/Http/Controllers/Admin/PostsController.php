<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use App\User;

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

    /**
    * Display the specified resource edit form.
    */
    public function edit(Post $post)
    {
        $users = User::pluck('name', 'id');
        return view('admin.posts.edit')->withPost($post)->withUsers($users);
    }
}
