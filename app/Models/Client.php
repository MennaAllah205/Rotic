<?php

namespace App\Models;

use App\Traits\HandlesOptimizedMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Client extends Model implements HasMedia
{
    use InteractsWithMedia , HandlesOptimizedMedia;
    protected $fillable = [
        'name',
        'description',
        'testimonial',
        'logo',
        'meta',
        'keywords',
    ];

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

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'description' => 'array',
            'testimonial' => 'array',
            'meta' => 'array',
            'keywords' => 'array',
        ];
    }

    // Relationship with projects

    public function projects()
    {
        return $this->hasMany(Project::class);
    }


}
