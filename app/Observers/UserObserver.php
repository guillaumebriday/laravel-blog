<?php

namespace App\Observers;

use App\Token;
use App\User;

class UserObserver
{
    /**
     * Listen to the User creating event.
     *
     * @param  User $user
     * @return void
     */
    public function creating(User $user)
    {
        $user->registered_at = now();
        $user->api_token = Token::generate();
    }
}
