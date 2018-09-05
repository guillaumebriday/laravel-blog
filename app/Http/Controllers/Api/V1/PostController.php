<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostsRequest;
use App\Http\Resources\Post as PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Return the posts.
     */
    public function index(Request $request): ResourceCollection
    {
        return PostResource::collection(
            Post::search($request->input('q'))->withCount('comments')->latest()->paginate($request->input('limit', 20))
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostsRequest $request, Post $post): PostResource
    {
        $this->authorize('update', $post);

        $post->update($request->only(['title', 'content', 'posted_at', 'author_id', 'thumbnail_id']));

        return new PostResource($post);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostsRequest $request): PostResource
    {
        $this->authorize('store', Post::class);

        return new PostResource(
            Post::create($request->only(['title', 'content', 'posted_at', 'author_id', 'thumbnail_id']))
        );
    }

    /**
     * Return the specified resource.
     */
    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): Response
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->noContent();
    }
}
