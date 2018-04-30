<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Comment as CommentResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCommentController extends Controller
{
    /**
     * Return the user's comments.
     */
    public function index(Request $request, User $user): ResourceCollection
    {
        return CommentResource::collection(
            $user->comments()->latest()->paginate($request->input('limit', 20))
        );
    }
}
