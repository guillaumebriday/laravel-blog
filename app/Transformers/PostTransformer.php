<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Post;

class PostTransformer extends TransformerAbstract
{
    /**
     * Transform a post.
     *
     * @param Post $post
     * @return array
     */
    public function transform(Post $post): array
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'content' => $post->content,
            'posted_at' => $post->posted_at->toIso8601String(),
            'author_id' => $post->author_id,
            'has_thumbnail' => $post->hasThumbnail(),
            'thumbnail_url' => $post->hasThumbnail() ? $post->thumbnail()->url : null,
            'comments_count' => $post->comments_count ?? $post->comments()->count()
        ];
    }
}
