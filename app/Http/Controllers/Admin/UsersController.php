<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $users = User::orderBy('registered_at', 'desc')->paginate(50);

        return view('admin.users.index')->withUsers($users);
    }

    /**
    * Display the specified resource edit form.
    */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit')->withUser($user)->withRoles($roles);
    }
}
