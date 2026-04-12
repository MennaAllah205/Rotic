<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class agent extends Model
{
    protected $table = 'agents';
    protected $fillable = ['name'];
}
