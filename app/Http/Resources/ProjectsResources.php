<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectsResources extends JsonResource
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
            'client_id' => $this->client_id,
            'title[ar]' => $this->title['ar'] ?? null,
            'title[en]' => $this->title['en'] ?? null,
            'description[ar]' => $this->description['ar'] ?? null,
            'description[en]' => $this->description['en'] ?? null,
            'features' => $this->features,
            'link' => $this->link,
            'image' => $this->getFirstMediaUrl('image'),
            'meta' => $this->meta,
            'keywords' => $this->keywords,
        ];
    }
}
