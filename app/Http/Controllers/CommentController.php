<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentsRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Tonysm\TurboLaravel\Http\MultiplePendingTurboStreamResponse;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentsRequest $request): MultiplePendingTurboStreamResponse
    {
        $comment = Auth::user()->comments()->create($request->validated());

        return response()->turboStream([
            response()->turboStream()->prepend('comments')->view('comments._comment', ['comment' => $comment]),
            response()->turboStream()->replace('comments_form')->view('comments._form', ['post' => $comment->post]),
            response()->turboStream()->update('comments_count', trans_choice('comments.count', $comment->post->comments()->count()))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): MultiplePendingTurboStreamResponse
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->turboStream([
            response()->turboStream()->remove($comment),
            response()->turboStream()->update('comments_count', trans_choice('comments.count', $comment->post->comments()->count()))
        ]);
    }
}
