<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResources extends JsonResource
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
            'description[ar]' => $this->description['ar'] ?? null,
            'description[en]' => $this->description['en'] ?? null,
        ];
    }
}
