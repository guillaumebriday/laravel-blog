<?php

namespace App\Observers;

use App\Media;

class MediaObserver
{
    /**
     * Listen to the Media creating event.
     *
     * @param  Media $medium
     * @return void
     */
    public function creating(Media $medium)
    {
        $medium->posted_at = now();
    }
}
