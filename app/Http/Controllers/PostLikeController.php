<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Tonysm\TurboLaravel\Http\MultiplePendingTurboStreamResponse;

use function Tonysm\TurboLaravel\dom_id;

class PostLikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Post $post): MultiplePendingTurboStreamResponse
    {
        $post->like();

        return response()->turboStream([
            response()->turboStream()->replace(dom_id($post, 'like'))->view('likes._like', ['post' => $post]),
            response()->turboStream()->update(dom_id($post, 'likes_count'), Str::of($post->likes()->count()))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): MultiplePendingTurboStreamResponse
    {
        $post->dislike();

        return response()->turboStream([
            response()->turboStream()->replace(dom_id($post, 'like'))->view('likes._like', ['post' => $post]),
            response()->turboStream()->update(dom_id($post, 'likes_count'), Str::of($post->likes()->count()))
        ]);
    }
}
