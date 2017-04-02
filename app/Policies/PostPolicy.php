<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
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
     * Determine whether the user can update the post.
     *
     * @param  User $user
     * @param  Post $post
     * @return bool
     */
    public function update(User $user, Post $post)
    {
        return $user->id === $post->author_id;
    }
}
