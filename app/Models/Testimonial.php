<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Testimonial extends Model
{
    protected $fillable = [
        'client_name',
        'title',
        'body',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'meta'        => 'array',
            'client_name' => 'array',
            'title'       => 'array',
            'body'        => 'array',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
    }

    public function registerMediaConversions(Media | null $media = null): void
    {
        $this->addMediaConversion('image')
            ->width(800)
            ->height(800)
            ->quality(70)
            ->sharpen(10)
            ->nonQueued();
    }

}
