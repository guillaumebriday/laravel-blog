<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Return the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return UserResource::collection(
            User::withCount(['comments', 'posts'])->with('roles')->latest()->paginate($request->input('limit', 20))
        );
    }

    /**
     * Return the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UsersRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update(array_filter($request->only(['name', 'email', 'password'])));

        return new UserResource($user);
    }
}
