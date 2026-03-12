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
            
            'id'          => $this->id,

            'client'      => $this->whenLoaded('client', fn() => [
                'id'   => $this->client->id,
                'name' => $this->client->name,
            ]),

            'title'       => $this->title,
            'description' => $this->description,

            'features'    => $this->features,
            'link'        => $this->link,
            'image'       => $this->getFirstMediaUrl('image'),
            'meta'        => $this->meta,
            'keywords'    => $this->keywords,
        ];
    }
}
