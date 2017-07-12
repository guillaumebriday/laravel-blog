<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Comment;

class CommentTransformer extends TransformerAbstract
{
    /**
     * Transform a comment.
     *
     * @param Comment $comment
     * @return array
     */
    public function transform(Comment $comment): array
    {
        return [
            'id' => $comment->id,
            'content' => $comment->content,
            'posted_at' => $comment->posted_at->toIso8601String(),
            'author_id' => $comment->author_id,
            'post_id' => $comment->post_id
        ];
    }
}
