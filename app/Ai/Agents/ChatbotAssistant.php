<?php

namespace App\Ai\Agents;

use App\Models\Blog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotAssistant
{
    private string $baseUrl = 'http://localhost:11434/api/generate';

    private string $model = 'tinyllama';

    public function chat(string $message): string
    {
        $blogs = $this->getBlogs();

        $response = $this->generateResponse($blogs, $message);

        if ($response === 'عذراً، أنا أجيب فقط على الأسئلة المتعلقة بالمدونات المتاحة.') {
            return 'OUT_OF_CONTEXT';
        }

        return $response;
    }

    private function generateResponse(string $blogs, string $message): string
    {
        try {
            $response = Http::timeout(60)->post($this->baseUrl, [
                'model' => $this->model,
                'prompt' => $this->buildPrompt($blogs, $message),
                'stream' => false,
                'options' => ['num_predict' => 100],
            ]);

            return $response->successful()
                ? ($response->json()['response'] ?? 'لا توجد إجابة.')
                : 'المحرك لا يستجيب.';
        } catch (\Exception $e) {
            Log::error('Ollama Error: '.$e->getMessage());

            return 'خطأ في الاتصال بالذكاء الاصطناعي.';
        }
    }

    private function buildPrompt(string $blogs, string $message): string
    {
        $context = $this->getBlogsContext();

        return "
You are an AI assistant that answers questions ONLY based on the provided data.

Available Data:
- Blogs:
{$blogs}

-Context:
{$context}

Instructions:
1. Carefully read the user question.
2. Try to find the answer ONLY from the context and use blogs above.
3. If you find a relevant answer:
   - Respond briefly and clearly.
   - Use the SAME language as the user (Arabic or English).
4. If the answer is NOT found in the provided data:
   - DO NOT guess or use external knowledge.
   - ONLY reply with:
   'عذراً، أنا أجيب فقط على الأسئلة المتعلقة بالمدونات المتاحة.'

User Question:
{$message}

Answer:
";
    }

    private function getBlogs(): string
    {
        return Cache::remember('blogs_context', 600, function () {
            return Blog::latest()->take(5)->get()->map(function ($b) {
                return 'Blog: '.($b->title['ar'] ?? $b->title['en'] ?? '');
            })->implode(' - ');
        });
    }

    public function getBlogsContext(): string
    {
        $contextPath = public_path('app/Ai/context.json');

        if (file_exists($contextPath)) {
            $contextContent = file_get_contents($contextPath);
            $contextData = json_decode($contextContent, true);

            return $contextData['context'] ?? '';
        }

        return '';
    }

    private function forwardToHumanChat(string $message): string
    {
        return 'OUT_OF_CONTEXT';
    }
}
