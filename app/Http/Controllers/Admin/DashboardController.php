<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
    * Show the application admin dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
