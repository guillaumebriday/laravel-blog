<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CommentsRequest;
use App\Http\Resources\Comment as CommentResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class PostCommentController extends Controller
{
    /**
     * Return the post's comments.
     */
    public function index(Request $request, Post $post): ResourceCollection
    {
        return CommentResource::collection(
            $post->comments()->with('author')->latest('posted_at')->paginate($request->input('limit', 20))
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentsRequest $request, Post $post): CommentResource
    {
        return new CommentResource(
            Auth::user()->comments()->create([
                'post_id' => $post->id,
                'content' => $request->input('content')
            ])
        );
    }
}
