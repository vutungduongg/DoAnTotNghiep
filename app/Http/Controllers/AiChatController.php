<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Services\AiChatService;
use Illuminate\Http\Request;

class AiChatController extends Controller
{
    public function index(Request $request)
    {
        $sessionId = $request->session()->getId();
        $userId = $request->user()?->id;

        $messages = ChatMessage::query()
            ->when($userId !== null, fn ($q) => $q->where('user_id', $userId))
            ->where('session_id', $sessionId)
            ->orderBy('id')
            ->limit(50)
            ->get(['role', 'content', 'created_at']);

        return view('store.chat.index', [
            'messages' => $messages,
        ]);
    }

    public function message(Request $request, AiChatService $service)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $sessionId = $request->session()->getId();
        $userId = $request->user()?->id;

        $userMessage = trim($validated['message']);

        ChatMessage::query()->create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'role' => 'user',
            'content' => $userMessage,
        ]);

        $result = $service->reply($userMessage, $sessionId, $userId);

        ChatMessage::query()->create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'role' => 'assistant',
            'content' => (string) ($result['reply'] ?? ''),
            'metadata' => [
                'suggestions_count' => is_array($result['suggestions'] ?? null) ? count($result['suggestions']) : 0,
            ],
        ]);

        return response()->json([
            'reply' => (string) ($result['reply'] ?? ''),
            'suggestions' => $result['suggestions'] ?? [],
        ]);
    }
}
