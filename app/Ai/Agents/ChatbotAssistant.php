<?php

namespace App\Ai\Agents;

use App\Models\Blog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotAssistant
{
    private string $apiKey;

    private string $model = 'gemini-2.5-flash';

    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1/models';

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY', '');
    }

    public function chat(string $message): string
    {
        $blogs = $this->getBlogs();

        return $this->generateResponse($blogs, $message);
    }

    private function generateResponse(string $blogs, string $message)
    {
        try {
            if (empty($this->apiKey)) {
                return 'خطأ: مفتاح API غير موجود. يرجى إعداد GEMINI_API_KEY في ملف .env';
            }

            $prompt = $this->buildPrompt($blogs, $message);
            $url = "{$this->baseUrl}/{$this->model}:generateContent?key={$this->apiKey}";

            $response = Http::timeout(30)
                ->post($url, [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]],
                    ],
                ]);

            if ($response->successful()) {
                return $response->json()['candidates'][0]['content']['parts'][0]['text']
                    ?? 'لم أجد إجابة مناسبة.';
            }

        } catch (\Exception $e) {
            Log::error('Error generating chatbot response', ['error' => $e->getMessage()]);

            return 'Something went wrong while generating the response. Please try again later.';
        }
    }

    private function buildPrompt(string $blogs, string $message): string
    {
        $projectContext = $this->getProjectContext();

        return "
You are a Laravel assistant with full knowledge of the project structure.

[Project Context]
{$projectContext}

[Blogs Data]
{$blogs}

User Question:
{$message}

Instructions:
- FIRST check the FAQ data in Project Context for direct answers
- If FAQ contains relevant answer, use it directly
- If no FAQ answer, then use project knowledge and blogs data
- Provide concise, accurate answers based on the above information
- If answer not found in FAQ or data, answer based on general based on the context
- Answer in the same language as the user's question
- Prioritize FAQ answers over general explanations

IMPORTANT: The FAQ data contains questions and answers about blogs in both Arabic and English. Use these answers directly when relevant.
";
    }

    private function getProjectContext(): string
    {
        return Cache::remember('project_context', now()->addHours(24), function () {
            $path = base_path('app/Ai/context.json');

            if (! file_exists($path)) {
                Log::error('Context file not found at: '.$path);

                return '';
            }

            $content = file_get_contents($path);
            Log::info('Context file loaded successfully', ['path' => $path]);

            return $content;
        });
    }

    private function getBlogs(): string
    {
        return Cache::remember('blogs_simple', now()->addMinutes(10), function () {
            return Blog::latest()
                ->take(10)
                ->get()
                ->map(function ($b) {
                    $title = ($b->title['ar'] ?? '').' | '.($b->title['en'] ?? '');

                    return "Title: {$title}";
                })
                ->implode(' | ');
        });
    }
}
