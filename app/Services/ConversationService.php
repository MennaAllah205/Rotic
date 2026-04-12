<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Message;

class ConversationService
{
    public function getOrCreateConversation($lead, $source = null)
    {

        if ($lead->conversation_id) {
            return Conversation::find($lead->conversation_id);
        }
        $conversation = Conversation::create([
            'name' => 'Chat',
            'type' => 'group',
            'source' => $source,
        ]);
        $conversation->participants()->create([
            'participant_id' => $lead->id,
            'participant_type' => get_class($lead),
        ]);

        $lead->update([
            'conversation_id' => $conversation->id,
        ]);

        return $conversation;
    }

    public function addParticipantToConversation(Conversation $conversation, $participant)
    {
        $exists = $conversation->participants()
            ->where('participant_id', $participant->id)
            ->where('participant_type', get_class($participant))
            ->exists();

        if (! $exists) {
            $conversation->participants()->create([
                'participant_id' => $participant->id,
                'participant_type' => get_class($participant),
            ]);
        }

        return $conversation;
    }

    public function sendMessage(Conversation $conversation, $sender, $content, $isAi = false)
    {
        return Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $isAi ? null : $sender->id,
            'sender_type' => $isAi ? 'ai' : get_class($sender),
            'content' => $content,
            'is_read' => false,
        ]);
    }

    public function editMessage($messageId, $content)
    {
        $message = Message::findOrFail($messageId);

        $message->update([
            'content' => $content,
        ]);

        return $message->load('sender');
    }

    public function deleteMessage($messageId, $deleteType, $userId)
    {
        $message = Message::findOrFail($messageId);
        $message->delete();

        return [
            'message' => 'Message deleted successfully',
        ];
    }

    public function removeParticipantFromConversation(Conversation $conversation, $participant)
    {
        $conversation->participants()
            ->where('participant_id', $participant->id)
            ->where('participant_type', get_class($participant))
            ->delete();

        return [
            'message' => 'Participant removed successfully',
        ];
    }
}
