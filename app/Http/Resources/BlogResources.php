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
            'id'          => $this->id,
            'name'        => $this->name,
            'title[ar]'   => $this->title['ar'] ?? null,
            'title[en]'   => $this->title['en'] ?? null,
            'content[ar]' => $this->content['ar'] ?? null,
            'content[en]' => $this->content['en'] ?? null,
            'image'       => $this->getFirstMediaUrl('image'),

            'meta[ar]'    => $this->meta['ar'] ?? null,
            'meta[en]'    => $this->meta['en'] ?? null,
        ];
    }
}
