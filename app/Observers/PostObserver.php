<?php

namespace App\Observers;

use App\Post;
use Carbon\Carbon;

class PostObserver
{
    /**
     * Listen to the Post creating event.
     *
     * @param  Post  $post
     * @return void
     */
    public function creating(Post $post)
    {
        $post->posted_at = Carbon::now();
    }

    /**
     * Listen to the Post saving event.
     *
     * @param  Post $post
     * @return void
     */
    public function saving(Post $post)
    {
        $post->slug = str_slug($post->title, '-');
    }
}
