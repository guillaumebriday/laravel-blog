<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Response;

class PostThumbnailController extends Controller
{
    /**
     * Unset the post's thumbnail.
     */
    public function destroy(Post $post): Response
    {
        $post->update(['thumbnail_id' => null]);

        return redirect()->route('admin.posts.edit', $post)->withSuccess(__('posts.updated'));
    }
}
