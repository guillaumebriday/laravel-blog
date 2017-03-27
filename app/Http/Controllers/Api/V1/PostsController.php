<?php

namespace App\Http\Controllers\Api\V1;

use App\Transformers\PostTransformer;
use Illuminate\Http\Request;
use App\Post;

class PostsController extends ApiController
{
    /**
    * Return the posts.
    *
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
}
