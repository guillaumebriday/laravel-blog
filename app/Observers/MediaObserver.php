<?php

namespace App\Observers;

use App\Models\Media;

class MediaObserver
{
    /**
     * Listen to the Media creating event.
     */
    public function creating(Media $medium): void
    {
        $medium->posted_at = now();
    }
}
