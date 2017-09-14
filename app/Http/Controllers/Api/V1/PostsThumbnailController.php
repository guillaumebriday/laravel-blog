<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;

class PostsThumbnailController extends ApiController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->transformer = new PostTransformer;
        $this->resourceKey = 'posts';
    }

    /**
    * Unset the post's thumbnail.
    *
    * @param  Post $post
    * @return \Illuminate\Http\Response
    */
    public function destroy(Post $post)
    {
        if (! Auth::user()->can('update', $post)) {
            return $this->respondUnauthorized();
        }

        $post->update(['thumbnail_id' => null]);

        return $this->item($post);
    }
}
