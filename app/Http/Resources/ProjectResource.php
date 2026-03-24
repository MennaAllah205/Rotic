<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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

            'client' => $this->whenLoaded('client', fn () => [
                'id' => $this->client->id,
                'name' => $this->client->name,
                'description' => $this->client->description,
                'link' => $this->client->link,
                'logo' => $this->client->getFirstMediaUrl('logos'),
                'meta' => $this->client->meta,
                'keywords' => $this->client->keywords,
            ]),

            'title' => $this->title,
            'description' => $this->description,

            'features' => $this->features,
            'link' => $this->link,
'images' => $this->getMedia('images')->map(function ($media) {
    return [
        'id'  => $media->id,
        'url' => $media->getUrl(),
    ];
}),
            'meta' => $this->meta,

            'keywords' => $this->keywords,
        ];
    }
}
