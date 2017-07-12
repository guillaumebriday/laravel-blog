<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsersRequest;
use App\User;
use App\Role;

class UsersController extends Controller
{
    /**
    * Show the application users index.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('admin.users.index')->with([
            'users' => User::withCount('posts')->latest()->paginate(50)
        ]);
    }

    /**
    * Display the specified resource edit form.
    */
    public function edit(User $user)
    {
        return view('admin.users.edit')->with([
            'user' => $user,
            'roles' => Role::all()
        ]);
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(UsersRequest $request, User $user)
    {
        $user->update($request->intersect(['name', 'email', 'password']));

        $role_ids = array_values($request->get('roles', []));
        $user->roles()->sync($role_ids);

        return redirect()->route('admin.users.edit', $user)->withSuccess(__('users.updated'));
    }
}
