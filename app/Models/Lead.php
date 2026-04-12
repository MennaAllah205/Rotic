<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'company', 'conversation_id'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function participants()
    {
        return $this->morphMany(ConversationParticipant::class, 'participant');
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'sender');
    }
}
