<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    protected $casts = [
        'name'        => 'array',
        'description' => 'array',
    ];

    // blogs
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
