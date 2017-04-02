<?php

namespace App\Http\Controllers\Api\V1;

use App\Transformers\PostTransformer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\PostsRequest;
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

        return $this->paginatedCollection($posts, 'posts');
    }

    /**
    * Return the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $post = Post::withCount('comments')->find($id);

        if (! $post) {
            return $this->respondNotFound();
        }

        return $this->item($post, 'posts');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
    public function store(PostsRequest $request)
    {
        $post = Auth::user()->posts()->create($request->only('title', 'content'));

        if ($request->hasFile('thumbnail')) {
            $post->storeAndSetThumbnail($request->file('thumbnail'));
        }

        return $this->setStatusCode(201)->item($post, 'posts');
    }

    /**
    * Update the specified resource in storage.
    *
    * @return \Illuminate\Http\Response
    */
    public function update(PostsRequest $request, Post $post)
    {
        if (! Auth::user()->can('update', $post)) {
            return $this->respondUnauthorized();
        }

        $post->update($request->only(['title', 'content']));

        if ($request->hasFile('thumbnail')) {
            $post->storeAndSetThumbnail($request->file('thumbnail'));
        }

        return $this->item($post, 'posts');
    }

    /**
    * Unset the post's thumbnail.
    *
    * @return \Illuminate\Http\Response
    */
    public function destroy_thumbnail($id)
    {
        $post = Post::find($id);

        if (! $post) {
            return $this->respondNotFound();
        }

        if (! Auth::user()->can('update', $post)) {
            return $this->respondUnauthorized();
        }

        $post->update(['thumbnail_id' => null]);

        return $this->item($post, 'posts');
    }
}
