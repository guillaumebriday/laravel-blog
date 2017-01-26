<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user is admin for all authorization.
     */
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $current_user, User $user)
    {
        return $current_user->id === $user->id;
    }

    /**
     * Determine whether the user can update the user's roles.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function update_roles(User $user)
    {
        return $user->isAdmin();
    }
}
