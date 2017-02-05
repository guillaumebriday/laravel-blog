<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Post;
use App\Comment;

class DashboardController extends Controller
{
    /**
    * Show the application admin dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    public function dashboard()
    {
        $comments = Comment::lastWeek()->get();
        $posts = Post::lastWeek()->get();
        $users = User::lastWeek()->get();

        return view('admin.dashboard.index')->with([
                                                'comments' => $comments,
                                                'posts' => $posts,
                                                'users' => $users,
                                            ]);
    }
}
