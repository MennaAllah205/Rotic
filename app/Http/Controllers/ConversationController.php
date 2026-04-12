<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConversationRequest;
use App\Http\Requests\MessageFromLeadRequest;
use App\Http\Requests\ParticipantsRequest;
use App\Models\Conversation;
use App\Models\Lead;
use App\Models\User;
use App\Models\Agent;
use App\Services\ConversationService;
use App\Ai\Agents\ChatbotAssistant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    protected $service;

    public function __construct(ConversationService $service)
    {
        $this->service = $service;
    }

    public function sendLeadMessage(MessageFromLeadRequest $request, ChatbotAssistant $assistant)
    {
        $data = $request->validated();

        $lead = Lead::findOrFail($data['lead_id']);

        $conversation = $lead->conversation ?? $this->service->getOrCreateConversation($lead);
        $this->service->addParticipantToConversation($conversation, $lead);

        $message = $this->service->sendMessage(
            $conversation,
            $lead,
            $data['content']
        );

        if ($conversation->auto) {
            $aiResponse = $assistant->chat($data['content']);

            if ($aiResponse !== 'OUT_OF_CONTEXT') {
                $this->service->sendMessage(
                    $conversation,
                    $assistant,
                    $aiResponse,
                    true
                );
            }
        }

        return response()->json($message->load('sender'));
    }

    public function sendUserMessage(ConversationRequest $request)
    {
        $data = $request->validated();

        $user = Auth::user();

        $conversation = Conversation::findOrFail($data['conversation_id']);

        if (
            $conversation->status === 'closed' &&
            ! $conversation->participants()
                ->where('participant_id', $user->id)
                ->where('participant_type', get_class($user))
                ->exists()
        ) {
            return response()->json([
                'message' => 'you cannot send message to this conversation contact support to add you to this conversation',
            ], 403);
        }

        $this->service->addParticipantToConversation($conversation, $user);

        $message = $this->service->sendMessage(
            $conversation,
            $user,
            $data['content']
        );

        return response()->json($message->load('sender'));
    }

    public function addParticipants(ParticipantsRequest $request)
    {
        $data = $request->validated();

        $conversation = Conversation::findOrFail($data['conversation_id']);

        $participant = User::findOrFail($data['participant_id']);

        $this->service->addParticipantToConversation($conversation, $participant);

        return response()->json([
            'message' => 'User added to conversation successfully',
            'user' => $participant,
        ]);
    }

    public function removeParticipant(ParticipantsRequest $request)
    {
        $request->validated();
        $conversation = Conversation::findOrFail($request->conversation_id);

        $user = User::findOrFail($request->participant_id);

        $result = $this->service->removeParticipantFromConversation($conversation, $user);

        return response()->json([
            'message' => 'User removed successfully from conversation',
            'result' => $result,
        ]);
    }

    public function editMessage(Request $request, $messageId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $message = $this->service->editMessage($messageId, $request->input('content'));

        return response()->json($message);
    }

    public function deleteMessage(Request $request, $messageId)
    {
        $request->validate([
            'delete_type' => 'required|in:soft,hard',
        ]);

        $result = $this->service->deleteMessage(
            $messageId,
            $request->delete_type,
            Auth::id()
        );

        return response()->json($result);
    }
}
