<?php

namespace App\Http\Controllers\Api\V1;

use App\Transformers\PostTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\PostsRequest;
use App\Post;
use App\User;

class PostsController extends ApiController
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
    * Return the posts.
    *
    * @param  Request $request
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $posts = Post::withCount('comments')->latest()->paginate($request->input('limit', 20));

        return $this->paginatedCollection($posts);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  App\Http\Requests\Admin\PostsRequest $request
    * @param  $id
    * @return \Illuminate\Http\Response
    */
    public function update(PostsRequest $request, $id)
    {
        $post = Post::find($id);

        if (! $post) {
            return $this->respondNotFound();
        }

        if (! Auth::user()->can('update', $post)) {
            return $this->respondUnauthorized();
        }

        $post->update($request->only(['title', 'content', 'posted_at', 'author_id']));

        if ($request->hasFile('thumbnail')) {
            $post->storeAndSetThumbnail($request->file('thumbnail'));
        }

        return $this->item($post);
    }

    /**
    * Return the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $post = Post::withCount('comments')->find($id);

        if (! $post) {
            return $this->respondNotFound();
        }

        return $this->item($post);
    }
}
