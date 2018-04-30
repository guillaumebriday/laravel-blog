<?php

namespace App\Policies;

use App\Models\Media;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MediaPolicy
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
     * Determine whether the user can store a medium.
     *
     * @param  User $user
     * @return bool
     */
    public function store(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the medium.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Media  $medium
     * @return mixed
     */
    public function delete(User $user, Media $medium)
    {
        return $user->isAdmin();
    }
}
