<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CommentsRequest;
use App\Comment;
use App\User;
use Carbon\Carbon;

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

    /**
    * Update the specified resource in storage.
    */
    public function update(CommentsRequest $request, Comment $comment)
    {
        $request['posted_at'] = Carbon::createFromFormat('d/m/Y H:i:s', $request->input('posted_at'));
        $comment->update($request->only(['content', 'posted_at', 'author_id']));

        return redirect()->route('admin.comments.edit', $comment)->withSuccess(__('comments.updated'));
    }
}
