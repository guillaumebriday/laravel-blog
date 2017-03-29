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
    * Return the posts.
    *
    * @param  Request $request
    * @param  int|null $id
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request, $id = null)
    {
        $builder = $this->buildPosts($id);

        if (! $builder) {
            return $this->respondNotFound();
        }

        $posts = $builder->withCount('comments')->latest()->paginate($request->input('limit', 20));
        $resource = $this->paginatedCollection($posts, new PostTransformer, 'posts');

        return $this->respond($resource);
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

        $resource = $this->item($post, new PostTransformer, 'posts');

        return $this->respond($resource);
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

        $resource = $this->item($post, new PostTransformer, 'posts');

        return $this->setStatusCode(201)->respond($resource);
    }

    /**
     * Build posts query for posts or nested user's posts
     *
     * @param  int|null $userId
     * @return \Illuminate\Database\Query\Builder
     */
    private function buildPosts($userId)
    {
        if (! $userId) {
            return Post::query();
        }

        $user = User::find($userId);

        if ($user) {
            return $user->posts();
        }

        return false;
    }
}
