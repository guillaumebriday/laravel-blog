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
}
