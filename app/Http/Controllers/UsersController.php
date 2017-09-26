<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UsersRequest;
use App\User;
use App\Role;

class UsersController extends Controller
{
    /**
    * Display the specified resource.
    */
    public function show(Request $request, User $user)
    {
        return view('users.show', [
            'user' => $user,
            'posts' => $user->posts()->withCount('comments')->latest()->limit(5)->get(),
            'comments' => $user->comments()->with('post.author')->latest()->limit(5)->get(),
            'roles' => Role::all()
        ]);
    }

    /**
    * Show the form for editing the specified resource.
    */
    public function edit(Request $request, User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', $user, [
            'user' => $user,
            'roles' => Role::all()
        ]);
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(UsersRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update(array_filter($request->only(['name', 'email', 'password'])));

        return redirect()->route('users.show', $user)->withSuccess(__('users.updated'));
    }
}
