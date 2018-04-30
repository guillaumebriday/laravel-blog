<?php

namespace App\Broadcasting;

use App\Models\Post;
use App\Models\User;

class PostChannel
{
    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, Post $post): bool
    {
        return true;
    }
}
