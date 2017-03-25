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
    public function hasMedia($media_id)
    {
        return $this->media()->where('id', $media_id)->exists();
    }

    /**
     * Get all of the resource's media.
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
