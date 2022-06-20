<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class PostCommentController extends Controller
{
    /**
     * Show the post's comments.
     */
    public function index(Post $post): View
    {
        return view('comments.index', [
            'comments' => $post->comments()->with('author')->latest()->get()
        ]);
    }
}
