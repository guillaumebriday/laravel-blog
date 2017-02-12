<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;

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
}
