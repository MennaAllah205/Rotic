<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimonialClient extends Model
{
    protected $fillable = [
        'client_id',
        'testimonial',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
