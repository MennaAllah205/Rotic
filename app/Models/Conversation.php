<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'name',
        'type',
        'status',
        'auto',
    ];

    public function participants()
    {
        return $this->hasMany(ConversationParticipant::class);
    }

    public function lead()
    {
        return $this->hasOne(Lead::class, 'conversation_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
