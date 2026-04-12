<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConversationParticipant extends Model
{
    protected $fillable = ['conversation_id', 'participant_id', 'participant_type'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function participant()
    {
        return $this->morphTo();
    }
}
