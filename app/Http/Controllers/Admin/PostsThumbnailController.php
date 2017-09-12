<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

class PostsThumbnailController extends Controller
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

        return redirect()->route('admin.posts.edit', $post)->withSuccess(__('posts.updated'));
    }
}
