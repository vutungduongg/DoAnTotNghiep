<?php

namespace App\Services;

use App\Models\ChatMessage;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiChatService
{
    public function reply(string $userMessage, string $sessionId, ?int $userId = null): array
    {
        $suggestions = $this->suggestProducts($userMessage);

        if (!$this->aiEnabled()) {
            return [
                'reply' => $this->fallbackReply($userMessage, $suggestions),
                'suggestions' => $suggestions,
            ];
        }

        try {
            $reply = $this->callAi($userMessage, $sessionId, $userId);

            return [
                'reply' => $reply,
                'suggestions' => $suggestions,
            ];
        } catch (\Throwable $e) {
            Log::warning('AI chat failed, using fallback.', [
                'error' => $e->getMessage(),
            ]);

            return [
                'reply' => $this->fallbackReply($userMessage, $suggestions),
                'suggestions' => $suggestions,
            ];
        }
    }

    private function aiEnabled(): bool
    {
        return (bool) config('services.ai.enabled') && (string) config('services.ai.api_key') !== '';
    }

    private function callAi(string $userMessage, string $sessionId, ?int $userId): string
    {
        $baseUrl = rtrim((string) config('services.ai.base_url'), '/');
        $apiKey = (string) config('services.ai.api_key');
        $model = (string) config('services.ai.model');
        $timeout = (int) config('services.ai.timeout', 20);

        $recent = ChatMessage::query()
            ->when($userId !== null, fn ($q) => $q->where('user_id', $userId))
            ->where('session_id', $sessionId)
            ->orderByDesc('id')
            ->limit(12)
            ->get(['role', 'content'])
            ->reverse()
            ->values();

        $catalog = Product::query()
            ->where('is_active', true)
            ->with('category:id,name,slug')
            ->orderByDesc('id')
            ->limit(30)
            ->get(['id', 'name', 'base_price', 'category_id', 'slug'])
            ->map(fn ($p) => [
                'name' => $p->name,
                'price' => (float) $p->base_price,
                'category' => $p->category?->name,
                'url' => route('products.show', $p),
            ])
            ->all();

        $system = "Bạn là trợ lý tư vấn mua sắm đồ bóng đá.\n"
            ."Mục tiêu: hiểu nhu cầu (loại: áo đấu/giày, size, ngân sách), rồi gợi ý sản phẩm phù hợp, trả lời ngắn gọn bằng tiếng Việt.\n"
            ."Nếu thiếu thông tin, hãy hỏi tối đa 1-2 câu để làm rõ.\n"
            ."Danh sách sản phẩm tham khảo (name, price, category, url):\n".json_encode($catalog, JSON_UNESCAPED_UNICODE);

        $messages = [
            ['role' => 'system', 'content' => $system],
        ];

        foreach ($recent as $m) {
            if (!in_array($m->role, ['user', 'assistant', 'system'], true)) {
                continue;
            }
            $messages[] = ['role' => $m->role, 'content' => $m->content];
        }

        $messages[] = ['role' => 'user', 'content' => $userMessage];

        $response = Http::withToken($apiKey)
            ->timeout($timeout)
            ->post($baseUrl.'/chat/completions', [
                'model' => $model,
                'messages' => $messages,
                'temperature' => 0.7,
            ])
            ->throw();

        $content = (string) data_get($response->json(), 'choices.0.message.content', '');
        $content = trim($content);

        if ($content === '') {
            throw new \RuntimeException('Empty AI response');
        }

        return $content;
    }

    private function suggestProducts(string $message): array
    {
        $normalized = mb_strtolower($message);

        $query = Product::query()
            ->where('is_active', true)
            ->with('category');

        if (str_contains($normalized, 'giày') || str_contains($normalized, 'giay')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', 'giay-bong-da'));
        } elseif (str_contains($normalized, 'áo') || str_contains($normalized, 'ao')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', 'ao-the-thao'));
        }

        // Price hint: capture first number and treat as max price (very simple heuristic)
        if (preg_match('/(\d+[\d\.,]*)\s*(tr|triệu|trieu)?/ui', $message, $m)) {
            $raw = str_replace([',', '.'], '', $m[1]);
            if (is_numeric($raw)) {
                $max = (float) $raw;
                if (!empty($m[2])) {
                    // "tr" / "triệu" means millions VND
                    $max *= 1_000_000;
                }
                if ($max > 0) {
                    $query->where('base_price', '<=', $max);
                }
            }
        }

        return $query
            ->orderByDesc('id')
            ->limit(6)
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'price' => (float) $p->base_price,
                'image' => $p->image_path ? asset('storage/'.$p->image_path) : null,
                'url' => route('products.show', $p),
                'category' => $p->category?->name,
            ])
            ->all();
    }

    private function fallbackReply(string $userMessage, array $suggestions): string
    {
        if (empty($suggestions)) {
            return "Mình chưa tìm thấy sản phẩm phù hợp theo mô tả này. Bạn cho mình biết bạn cần Áo đấu hay Giày, size và khoảng giá mong muốn nhé?";
        }

        $names = array_slice(array_map(fn ($s) => $s['name'] ?? null, $suggestions), 0, 3);
        $names = array_values(array_filter($names));

        $intro = "Mình gợi ý vài sản phẩm có thể hợp nhu cầu của bạn:";
        if (!empty($names)) {
            $intro .= ' '.implode(', ', $names).'.';
        }

        return $intro."\nBạn muốn mình ưu tiên loại (áo đấu/giày), size và tầm giá bao nhiêu?";
    }
}
