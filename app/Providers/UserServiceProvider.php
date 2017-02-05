<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\User;
use Carbon\Carbon;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        User::creating(function ($user) {
            $user->registered_at = Carbon::now();
        });
    }
}
