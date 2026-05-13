<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ChatMessage;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $sessionId = $request->session()->getId();
        $userId = $request->user()?->id;

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $featuredProducts = Product::query()
            ->where('is_active', true)
            ->with('category')
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        $chatMessages = ChatMessage::query()
            ->when($userId !== null, fn ($q) => $q->where('user_id', $userId))
            ->where('session_id', $sessionId)
            ->orderByDesc('id')
            ->limit(30)
            ->get(['role', 'content', 'created_at'])
            ->reverse()
            ->values();

        return view('store.home', [
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
            'chatMessages' => $chatMessages,
        ]);
    }
}
