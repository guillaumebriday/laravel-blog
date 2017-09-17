<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Comment;

class CommentsController extends Controller
{
    /**
    * Return the comments.
    *
    * @param  Request $request
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        return CommentResource::collection(
            Comment::latest()->paginate($request->input('limit', 20))
        );
    }

    /**
    * Return the specified resource.
    *
    * @param  Comment $comment
    * @return \Illuminate\Http\Response
    */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
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

        return response()->noContent();
    }
}
