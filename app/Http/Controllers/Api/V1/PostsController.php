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
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $posts = Post::withCount('comments')->latest()->paginate($request->input('limit', 20));
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
}
