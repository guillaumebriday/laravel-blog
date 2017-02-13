<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Comment;
use App\User;

class CommentsController extends Controller
{
    /**
    * Show the application comments index.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $comments = Comment::orderBy('posted_at', 'desc')->paginate(50);

        return view('admin.comments.index')->withComments($comments);
    }

    /**
    * Display the specified resource edit form.
    */
    public function edit(Comment $comment)
    {
        $users = User::pluck('name', 'id');
        return view('admin.comments.edit')->withComment($comment)->withUsers($users);
    }
}
