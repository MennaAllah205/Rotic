<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResources extends JsonResource
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

            'name' => $this->name,

            'description' => $this->description,

            'testimonial' => $this->testimonial,

            'logo' => $this->getFirstMediaUrl('logo'),
            'meta' => $this->meta,

            'projects' => ProjectsResources::collection($this->whenLoaded('projects')),

        ];
    }
}
