<?php

namespace App\Observers;

use App\Comment;

class CommentObserver
{
    /**
     * Listen to the Comment creating event.
     *
     * @param  Comment $comment
     * @return void
     */
    public function creating(Comment $comment)
    {
        $comment->posted_at = now();
    }
}
