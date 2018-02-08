<?php

namespace App\Broadcasting;

use App\Post;
use App\User;

class PostChannel
{
    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return array|bool
     */
    public function join(User $user, Post $post)
    {
        return true;
    }
}
