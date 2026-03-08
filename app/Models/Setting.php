<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Setting extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('logo')
            ->width(800)
            ->height(800)
            ->quality(70)
            ->sharpen(10)
            ->nonQueued();
    }

    protected $fillable = [
        'name',
        'logo',
        'facebook',
        'youtube',
        'email',
        'first_phone_number',
        'second_phone_number',
        'meta'
    ];


    protected function casts(): array
    {
        return [
            'name' => 'array',
            'meta' => 'array',
        ];
    }
}
