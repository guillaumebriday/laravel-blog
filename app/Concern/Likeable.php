<?php

namespace App\Concern;

use App\Like;

trait Likeable
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    protected static function bootLikeable()
    {
        static::deleting(function ($resource) {
            $resource->likes->each->delete();
        });
    }

    /**
     * Get all of the resource's likes.
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * Create a like if it does not exist yet.
     */
    public function like()
    {
        if (! $this->likes()->where('author_id', auth()->id())->exists()) {
            return $this->likes()->create(['author_id' => auth()->id()]);
        }
    }

    /**
     * Check if the resource is liked by the current user
     */
    public function isLiked(): bool
    {
        return $this->likes()->where('author_id', auth()->id())->exists();
    }

    /**
     * Delete like for a resource.
     */
    public function dislike()
    {
        return $this->likes()->where('author_id', auth()->id())->get()->each->delete();
    }
}
