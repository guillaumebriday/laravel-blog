<?php

namespace App\Http\Controllers\Api\V1;

use App\Transformers\UserTransformer;
use App\Transformers\CommentTransformer;
use App\Transformers\PostTransformer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use App\User;

class UsersController extends ApiController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->transformer = new UserTransformer;
        $this->resourceKey = 'users';
    }

    /**
    * Return the users.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $users = User::withCount(['comments', 'posts'])->latest()->paginate($request->input('limit', 20));

        return $this->paginatedCollection($users);
    }

    /**
    * Return the user's comments.
    *
    * @param  Request $request
    * @param  User $user
    * @return \Illuminate\Http\Response
    */
    public function comments(Request $request, User $user)
    {
        $comments = $user->comments()->latest()->paginate($request->input('limit', 20));

        return $this
                ->setTransformer(new CommentTransformer)
                ->setResourceKey('comments')
                ->paginatedCollection($comments);
    }

    /**
    * Return the user's posts.
    *
    * @param  Request $request
    * @param  User $user
    * @return \Illuminate\Http\Response
    */
    public function posts(Request $request, User $user)
    {
        $posts = $user->posts()->latest()->paginate($request->input('limit', 20));

        return $this
                ->setTransformer(new PostTransformer)
                ->setResourceKey('posts')
                ->paginatedCollection($posts);
    }

    /**
    * Return the specified resource.
    *
    * @param  User $user
    * @return \Illuminate\Http\Response
    */
    public function show(User $user)
    {
        return $this->item($user);
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(UsersRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update(array_filter($request->only(['name', 'email', 'password'])));

        return $this->item($user);
    }
}
