<?php
namespace App\Models;

use App\Traits\HandlesOptimizedMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Blog extends Model implements HasMedia
{
    use HandlesOptimizedMedia, InteractsWithMedia;

    protected $fillable = [
        'category_id',
        'title',
        'content',
        'slug',
        'meta',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('image')
            ->width(800)
            ->height(800)
            ->quality(70)
            ->sharpen(10)
            ->nonQueued();
    }

    protected $casts = [
        'title'   => 'array',
        'content' => 'array',
        'meta'    => 'array',
    ];

    public function addOptimizedMediaToCollection(UploadedFile $file, string $collection = 'image')
    {
        return $this->addOptimizedMedia($this, $file, $collection);
    }

    // category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
