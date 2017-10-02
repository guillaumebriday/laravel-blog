<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Auth;

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
        // We need to create an App\Comment because the registred policy in
        // AuthServiceProvider is App\Comment and not App\Http\Resources\Comment.
        // I didn't find another way to make this cleaner.
        $comment = new \App\Comment($this->getAttributes());
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
