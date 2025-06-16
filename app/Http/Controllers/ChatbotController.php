<?php

namespace App\Http\Controllers;

use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $message = $request->input('message');

        $prevAssistantReply = session('chat_history', []);

        $history = [];
        if (!empty($prevAssistantReply)) {
            $history[] = $prevAssistantReply; // role: assistant
        }

        $history[] = ['role' => 'user', 'content' => $message];
        $result = $this->processMessage($message, $history);

        session(['chat_history' => ['role' => 'assistant', 'content' => $result['reply'] ?? '']]);

        return response()->json([
            'message' => $result,
            'status' => 'success'
        ]);
    }


    public function processMessage($message, $history)
    {
        $apiUrl = 'http://localhost:8001/chat/';

        try {
            $response = Http::post($apiUrl, [
                'user_input' => $message,
                'history' => $history
            ]);

            if ($response->successful()) {
                return $response->json()['answer'];
            } else {
                return [
                    'error' => 'API Error',
                    'status' => $response->status(),
                    'body' => $response->body()
                ];
            }
        } catch (\Exception $e) {
            return [
                'error' => 'Request failed',
                'message' => $e->getMessage()
            ];
        }
    }
}
