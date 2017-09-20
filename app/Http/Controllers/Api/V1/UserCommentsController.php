<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Http\Request;
use App\User;

class UserCommentsController extends Controller
{
    /**
    * Return the user's comments.
    *
    * @param  Request $request
    * @param  User $user
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request, User $user)
    {
        return CommentResource::collection(
            $user->comments()->latest()->paginate($request->input('limit', 20))
        );
    }
}
