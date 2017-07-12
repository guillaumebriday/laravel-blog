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
        return view('users.show')->with([
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

        return view('users.edit', $user)->with([
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

        $user->update($request->intersect(['name', 'email', 'password']));

        return redirect()->route('users.show', $user)->withSuccess(__('users.updated'));
    }

    /**
    * Generate a personnal access token for the specified resource in storage.
    */
    public function api_token(Request $request, User $user)
    {
        $this->authorize('api_token', $user);

        $user->update(['api_token' => User::generateApiToken()]);

        return redirect()->route('users.edit', $user)->withSuccess(__('users.api_token_generated'));
    }

    /**
    * Destroy a personnal access token for the specified resource in storage.
    */
    public function destroy_api_token(Request $request, User $user)
    {
        $this->authorize('api_token', $user);

        $user->update(['api_token' => null]);

        return redirect()->route('users.edit', $user)->withSuccess(__('users.api_token_deleted'));
    }
}
