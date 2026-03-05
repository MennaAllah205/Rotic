<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResources extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'images' => $this->getMedia('images')->map(function ($media) {
                return [
                    'id' => $media->id,
                    'file_name' => $media->file_name,
                    'original_url' => $media->getUrl(),
                    'original_size' => $media->size,
                    'original_size_kb' => round($media->size / 1024, 2),
                    'thumb_url' => $media->getUrl('thumb'),
                    'small_thumb_url' => $media->getUrl('small-thumb'),
                    'mime_type' => $media->mime_type,
                ];
            }),
        ];
    }
}
