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
    * @param  Post $post
    * @return \Illuminate\Http\Response
    */
    public function update(PostsRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->only(['title', 'content', 'posted_at', 'author_id']));

        if ($request->hasFile('thumbnail')) {
            $post->storeAndSetThumbnail($request->file('thumbnail'));
        }

        return $this->item($post);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(PostsRequest $request)
    {
        $this->authorize('store', Post::class);

        $post = Post::create($request->only(['title', 'content', 'posted_at', 'author_id']));

        if ($request->hasFile('thumbnail')) {
            $post->storeAndSetThumbnail($request->file('thumbnail'));
        }

        return $this->setStatusCode(201)->item($post);
    }

    /**
    * Return the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
    public function show(Post $post)
    {
        return $this->item($post);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  Post $post
    * @return \Illuminate\Http\Response
    */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return $this->respondNoContent();
    }
}
