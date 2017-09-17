<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Comment extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'posted_at' => $this->posted_at->toIso8601String(),
            'author_id' => $this->author_id,
            'post_id' => $this->post_id
        ];
    }
}
