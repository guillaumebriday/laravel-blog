<?php

namespace App\Concern;

trait Mediable
{

    /**
     * Get all of the resource's media.
     */
    public function media()
    {
        return $this->morphMany('App\Media', 'mediable');
    }
}
