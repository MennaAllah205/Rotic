<?php

namespace App\Models;

use App\Traits\HandlesOptimizedMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Project extends Model implements HasMedia
{
    use HandlesOptimizedMedia, InteractsWithMedia;

    protected $fillable = [
        'client_id',
        'title',
        'description',
        'features',
        'link',
        'meta',
        'keywords',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('images')
            ->width(800)
            ->height(800)
            ->quality(70)
            ->sharpen(10)
            ->nonQueued();
    }

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'description' => 'array',
            'features' => 'array',
            'meta' => 'array',
            'keywords' => 'array',
        ];
    }

    public function addOptimizedMediaToCollection(UploadedFile $file, string $collection = 'image')
    {
        return $this->addOptimizedMedia($this, $file, $collection);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
