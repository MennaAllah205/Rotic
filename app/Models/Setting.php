<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Setting extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'logo',
        'about_us',
        'facebook',
        'youtube',
        'instagram',
        'twitter',
        'email',
        'phone',
        'second_phone',
        'meta',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('logo')
            ->width(800)
            ->height(800)
            ->quality(70)
            ->sharpen(10)
            ->nonQueued();
    }

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'about_us' => 'array',
            'meta' => 'array',
        ];
    }
}
