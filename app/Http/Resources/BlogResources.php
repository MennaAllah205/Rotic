<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name[ar]' => $this->name['ar'] ?? null,
            'name[en]' => $this->name['en'] ?? null,
            'title[ar]' => $this->title['ar'] ?? null,
            'title[en]' => $this->title['en'] ?? null,
            'content[ar]' => $this->content['ar'] ?? null,
            'content[en]' => $this->content['en'] ?? null,
            'image' => $this->getFirstMediaUrl('image'),
            'meta_title[ar]' => $this->meta['ar'] ?? null,
            'meta_title[en]' => $this->meta['en'] ?? null,
            'meta_description[ar]' => $this->meta_description['ar'] ?? null,
            'meta_description[en]' => $this->meta_description['en'] ?? null,
        ];
    }
}
