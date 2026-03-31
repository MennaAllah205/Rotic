<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'name' => $this->name,

            'about_us' => $this->about_us,
            'contacts' => [
                'email' => $this->email,
                'phone' => $this->phone,
                'second_phone' => $this->second_phone,
            ],

            'social_media' => [
                'facebook' => $this->facebook,
                'youtube' => $this->youtube,
                'instagram' => $this->instagram,
                'twitter' => $this->twitter,
            ],

            'logo' => $this->getFirstMediaUrl('logo'),
            'meta' => $this->meta,

        ];
    }
}
