<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Auth;

class Comment extends Resource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        // We need to create an App\Models\Comment because the registred policy in
        // AuthServiceProvider is App\Models\Comment and not App\Http\Resources\Comment.
        // I didn't find another way to make this cleaner.
        $comment = new \App\Models\Comment($this->getAttributes());
        $user = Auth::guard('api')->user();

        return [
            'id' => $this->id,
            'content' => $this->content,
            'posted_at' => $this->posted_at->toIso8601String(),
            'humanized_posted_at' => humanize_date($this->posted_at),
            'author_id' => $this->author_id,
            'post_id' => $this->post_id,
            'author_name' => $this->author->name,
            'author_url' => route('users.show', $this->author),
            'can_delete' => $user ? $user->can('delete', $comment) : false
        ];
    }
}
