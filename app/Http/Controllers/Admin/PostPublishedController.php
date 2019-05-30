<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\PostPublishedRequest;


class PostPublishedController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(PostPublishedRequest $request, Post $post): RedirectResponse
    {
        $post->update($request->only(['published']));

        return redirect()->route('admin.posts.index')->withSuccess(__('postpublish.changed'));
    }
}
