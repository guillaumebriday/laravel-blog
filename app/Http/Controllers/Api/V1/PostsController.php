<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Post as PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\PostsRequest;
use App\Post;
use App\User;

class PostsController extends Controller
{
    /**
    * Return the posts.
    *
    * @param  Request $request
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        return PostResource::collection(
            Post::search($request->input('q'))->withCount('comments')->latest()->paginate($request->input('limit', 20))
        );
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

        return new PostResource($post);
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

        return new PostResource($post);
    }

    /**
    * Return the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
    public function show(Post $post)
    {
        return new PostResource($post);
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

        return response()->noContent();
    }
}
