<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Post as PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;

class PostsThumbnailController extends ApiController
{
    /**
    * Unset the post's thumbnail.
    *
    * @param  Post $post
    * @return \Illuminate\Http\Response
    */
    public function destroy(Post $post)
    {
        $this->authorize('update', $post);

        $post->update(['thumbnail_id' => null]);

        return new PostResource($post);
    }
}
