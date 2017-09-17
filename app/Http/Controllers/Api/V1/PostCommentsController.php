<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Comment as CommentResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\Api\CommentsRequest;
use App\Post;

class PostCommentsController extends ApiController
{
    /**
    * Return the post's comments.
    *
    * @param  Request $request
    * @param  Post $post
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request, Post $post)
    {
        return CommentResource::collection(
            $post->comments()->latest()->paginate($request->input('limit', 20))
        );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  CommentsRequest $request
    * @param  Post $post
    * @return \Illuminate\Http\Response
    */
    public function store(CommentsRequest $request, Post $post)
    {
        return new CommentResource(
            Auth::user()->comments()->create([
                'post_id' => $post->id,
                'content' => $request->input('content')
            ])
        );
    }
}
