<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        return view('users.show', [
            'user' => $user,
            'posts_count' => $user->posts()->count(),
            'comments_count' => $user->comments()->count(),
            'likes_count' => $user->likes()->count(),
            'posts' => $user->posts()->withCount('likes', 'comments')->latest()->limit(5)->get(),
            'comments' => $user->comments()->with('post.author')->latest()->limit(5)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        return view('users.edit', [
            'user' => $user,
            'roles' => Role::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UsersRequest $request)
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        $user->update(array_filter($request->only(['name', 'email'])));

        return redirect()->route('users.edit')->withSuccess(__('users.updated'));
    }
}
