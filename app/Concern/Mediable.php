<?php

namespace App\Concern;

use App\Media;

trait Mediable
{

    /**
     * Check if the resource has a media
     *
     * @param integer $media_id
     * @return boolean
     */
    public function hasMedia($media_id): bool
    {
        return $this->media->where('id', $media_id)->isNotEmpty();
    }

    /**
     * Get all of the resource's media.
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
