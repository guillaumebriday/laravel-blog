<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostLikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request, Post $post)
    {
        return $post->like();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Post $post)
    {
        return $post->dislike();
    }
}
