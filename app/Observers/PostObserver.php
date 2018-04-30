<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
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
