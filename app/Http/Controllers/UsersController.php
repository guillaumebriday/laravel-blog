<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UsersRequest;
use App\User;

class UsersController extends Controller
{
  /**
   * Display the specified resource.
   */
  public function show(Request $request, User $user)
  {
    $posts = $user->posts()->orderBy('posted_at', 'desc')->limit(5)->get();
    $comments = $user->comments()->orderBy('posted_at', 'desc')->limit(5)->get();

    return view('users.show')->withUser($user)->withPosts($posts)->withComments($comments);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Request $request, User $user)
  {
    $this->authorize('update', $user);

    return view('users.edit', $user)->withUser($user);
  }
}
