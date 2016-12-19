<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostsRequest;
use App\Post;

class PostsController extends Controller
{
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $posts = Post::orderBy('posted_at', 'desc')->paginate(20);
      return view('home')->withPosts($posts);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create(Request $request)
  {
    return view('posts.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(PostsRequest $request)
  {
    $user = Auth::user();

    $post = $user->posts()->create([
        'title' => $request->input('title'),
        'content' => $request->input('content')
    ]);

    return redirect()->route('posts.show', $post)->with('success', trans('posts.created'));
  }
}
