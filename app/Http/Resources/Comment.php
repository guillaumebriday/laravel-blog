<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class Comment extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $user = Auth::guard('sanctum')->user();

        return [
            'id' => $this->id,
            'content' => $this->content,
            'posted_at' => $this->posted_at->toIso8601String(),
            'humanized_posted_at' => humanize_date($this->posted_at),
            'author_id' => $this->author_id,
            'post_id' => $this->post_id,
            'author_name' => $this->author->name,
            'author_url' => route('users.show', $this->author),
            'can_delete' => $user ? $user->can('delete', $this->resource) : false
        ];
    }
}
