<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostThumbnailController extends Controller
{
    /**
     * Unset the post's thumbnail.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->update(['thumbnail_id' => null]);

        return redirect()->route('admin.posts.edit', $post)->withSuccess(__('posts.updated'));
    }
}
