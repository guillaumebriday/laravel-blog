<?php

namespace App\Http\Controllers\Api\V1;

use App\Transformers\CommentTransformer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Comment;

class CommentsController extends ApiController
{
    /**
    * Return the comments.
    *
    * @param  Request $request
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $comments = Comment::latest()->paginate($request->input('limit', 20));

        return $this->paginatedCollection($comments, new CommentTransformer, 'comments');
    }

    /**
    * Return the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $comment = Comment::find($id);

        if (! $comment) {
            return $this->respondNotFound();
        }

        return $this->item($comment, new CommentTransformer, 'comments');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $comment = Comment::find($id);

        if (! $comment) {
            return $this->respondNotFound();
        }

        if (! Auth::user()->can('delete', $comment)) {
            return $this->respondUnauthorized();
        }

        $comment->delete();

        return $this->respondNoContent();
    }
}
