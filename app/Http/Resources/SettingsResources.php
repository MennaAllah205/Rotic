<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingsResources extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'name_ar' => $this->name['ar'] ?? null,
            'name_en' => $this->name['en'] ?? null,

            'contacts' => [
                'email' => $this->email,
                'phone' => $this->phone,
                'second_phone' => $this->second_phone,
            ],
            'social_media' => [
                'facebook' => $this->facebook,
                'youtube' => $this->youtube,
                'instagram' => $this->instagram,
            ],
            'logo' => $this->logo,
            'meta' => $this->meta,
        ];
    }
}
