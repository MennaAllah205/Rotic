<?php

namespace App\Http\Controllers;

use App\Ai\Agents\ChatbotAssistant;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat(Request $request, ChatbotAssistant $assistant)
    {
        $request->validate([
            'message' => 'required|string|min:2|max:200',
        ]);

        $message = $request->input('message');

        $response = $assistant->chat($message);

        return response()->json(['reply' => $response]);
    }
}
