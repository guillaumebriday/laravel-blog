<?php

namespace App\Http\Controllers\Api\V1;

use App\Transformers\UserTransformer;
use App\Transformers\CommentTransformer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use App\User;

class UsersController extends ApiController
{
    /**
    * Return the users.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $users = User::withCount(['comments', 'posts'])->latest()->paginate($request->input('limit', 20));
        $resource = $this->paginatedCollection($users, new UserTransformer, 'users');

        return $this->respond($resource);
    }

    /**
    * Return the user's comments.
    *
    * @param  Request $request
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
    public function comments(Request $request, $id)
    {
        $user = User::find($id);

        if (! $user) {
            return $this->respondNotFound();
        }

        $comments = $user->comments()->latest()->paginate($request->input('limit', 20));
        $resource = $this->paginatedCollection($comments, new CommentTransformer, 'comments');

        return $this->respond($resource);
    }

    /**
    * Return the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $user = User::withCount(['comments', 'posts'])->find($id);

        if (! $user) {
            return $this->respondNotFound();
        }

        $resource = $this->item($user, new UserTransformer, 'users');

        return $this->respond($resource);
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(UsersRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update($request->intersect(['name', 'email', 'password']));

        $resource = $this->item($user, new UserTransformer, 'users');

        return $this->respond($resource);
    }
}
