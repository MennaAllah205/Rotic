<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimonialClient extends Model
{
    protected $fillable = [
        'client_id',
        'testimonial',
    ];

    protected function casts(): array
    {
        return [
            'testimonial' => 'array',
        ];
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
