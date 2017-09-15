<?php

namespace App\Http\Controllers\Api\V1;

use App\Transformers\CommentTransformer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Comment;

class CommentsController extends ApiController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->transformer = new CommentTransformer;
        $this->resourceKey = 'comments';
    }

    /**
    * Return the comments.
    *
    * @param  Request $request
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $comments = Comment::latest()->paginate($request->input('limit', 20));

        return $this->paginatedCollection($comments);
    }

    /**
    * Return the specified resource.
    *
    * @param  Comment $comment
    * @return \Illuminate\Http\Response
    */
    public function show(Comment $comment)
    {
        return $this->item($comment);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  Comment $comment
    * @return \Illuminate\Http\Response
    */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return $this->respondNoContent();
    }
}
