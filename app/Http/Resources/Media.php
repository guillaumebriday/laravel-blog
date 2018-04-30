<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Media extends Resource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => url($this->getUrl()),
            'thumb_url' => url($this->getUrl('thumb')),
        ];
    }
}
