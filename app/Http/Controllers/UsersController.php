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
        $posts = $user->posts()->withCount('comments')->latest()->limit(5)->get();
        $comments = $user->comments()->latest()->limit(5)->get();
        $roles = Role::all();

        return view('users.show')->with([
                                    'user' => $user,
                                    'posts' => $posts,
                                    'comments' => $comments,
                                    'roles' => $roles
                                ]);
    }

    /**
    * Show the form for editing the specified resource.
    */
    public function edit(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $roles = Role::all();

        return view('users.edit', $user)->withUser($user)->withRoles($roles);
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(UsersRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->input('password') != '') {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

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
