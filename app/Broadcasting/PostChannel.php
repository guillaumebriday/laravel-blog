<?php

namespace App\Broadcasting;

use App\Models\Post;
use App\Models\User;

class PostChannel
{
    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return array|bool
     */
    public function join(User $user, Post $post)
    {
        return true;
    }
}
