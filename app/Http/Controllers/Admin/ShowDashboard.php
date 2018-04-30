<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class ShowDashboard extends Controller
{
    /**
     * Show the application admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view('admin.dashboard.index', [
            'comments' =>  Comment::lastWeek()->get(),
            'posts' => Post::lastWeek()->get(),
            'users' => User::lastWeek()->get(),
        ]);
    }
}
