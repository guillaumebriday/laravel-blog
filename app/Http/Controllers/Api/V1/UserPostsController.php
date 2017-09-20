<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Post as PostResource;
use Illuminate\Http\Request;
use App\User;

class UserPostsController extends Controller
{
    /**
    * Return the user's posts.
    *
    * @param  Request $request
    * @param  User $user
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request, User $user)
    {
        return PostResource::collection(
            $user->posts()->latest()->paginate($request->input('limit', 20))
        );
    }
}
