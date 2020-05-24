<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class PostThumbnailController extends Controller
{
    /**
     * Unset the post's thumbnail.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->update(['thumbnail_id' => null]);

        return redirect()->route('admin.posts.edit', $post)->withSuccess(__('posts.updated'));
    }
}
