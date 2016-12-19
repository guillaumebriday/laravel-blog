<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
