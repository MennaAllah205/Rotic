<?php

namespace App\Ai\Agents;

use App\Models\Blog;
use App\Models\FAQ; // تأكد من استدعاء موديل الـ FAQ
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotAssistant
{
    private string $apiKey;

    private string $model = 'gemini-2.5-flash-lite';

    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1/models';

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY', '');
    }

    public function chat(string $message): string
    {
        $normalizedMessage = trim(mb_strtolower($message));

        Log::info('Chat Started', [
            'original_message' => $message,
            'normalized_message' => $normalizedMessage,
        ]);

        $faqAnswer = $this->findInDatabaseFaq($normalizedMessage);
        if ($faqAnswer) {
            Log::info('FAQ Answer Returned', [
                'answer' => $faqAnswer,
            ]);

            return $faqAnswer;
        }

        Log::info('No FAQ found, falling back to AI', [
            'message' => $normalizedMessage,
        ]);

        $cacheKey = 'ai_answer_'.md5($normalizedMessage);

        return Cache::remember($cacheKey, now()->addDays(7), function () use ($normalizedMessage) {
            $blogs = $this->getRelevantBlogs($normalizedMessage);

            return $this->generateResponse($blogs, $normalizedMessage);
        });
    }

    private function findInDatabaseFaq(string $message): ?string
    {
        // Trim whitespace and normalize the message
        $trimmedMessage = trim($message);

        // Log the search process
        Log::info('FAQ Search Started', [
            'original_message' => $message,
            'trimmed_message' => $trimmedMessage,
            'message_length' => strlen($trimmedMessage),
        ]);

        $faq = FAQ::query()
            ->where(function ($q) use ($trimmedMessage) {
                $q->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(question, '$.ar'))) LIKE LOWER(?)", ["%{$trimmedMessage}%"])
                    ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(question, '$.en'))) LIKE LOWER(?)", ["%{$trimmedMessage}%"]);
            })
            ->first();

        Log::info('FAQ Search Result', [
            'found' => $faq ? true : false,
            'faq_id' => $faq ? $faq->id : null,
            'search_term' => $trimmedMessage,
        ]);

        if ($faq) {
            Log::info('FAQ Answer Found', [
                'faq_id' => $faq->id,
                'question' => $faq->question,
                'answer_ar' => $faq->answer['ar'] ?? 'missing',
                'answer_en' => $faq->answer['en'] ?? 'missing',
            ]);

            return $faq->answer['ar'].'|'.$faq->answer['en'];
        }

        Log::warning('FAQ Not Found', [
            'searched_message' => $trimmedMessage,
            'total_faqs_in_db' => FAQ::count(),
        ]);

        return null;
    }

    private function generateResponse(string $blogs, string $message): string
    {
        try {
            $prompt = $this->buildPrompt($blogs, $message);
            $url = "{$this->baseUrl}/{$this->model}:generateContent?key={$this->apiKey}";

            $requestPayload = [
                'contents' => [['parts' => [['text' => $prompt]]]],
                'generationConfig' => [
                    'maxOutputTokens' => 150,
                ],
            ];

            // تسجيل الطلب قبل الإرسال
            Log::info('Sending API request', [
                'url' => $url,
                'payload' => $requestPayload,
            ]);

            $response = Http::timeout(20)->post($url, $requestPayload);

            // تسجيل الرد بعد الاستلام
            Log::info('API response received', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'body' => $response->body(),
                'headers' => $response->headers(),
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                return $responseData['candidates'][0]['content']['parts'][0]['text'] ?? 'عذراً، حدث خطأ ما.';
            }

            return 'تستطيع السؤال عن مواضيع المدونة فقط !';
        } catch (\Exception $e) {
            Log::error('AI request failed', [
                'message' => $e->getMessage(),
                'blogs' => $blogs,
                'user_message' => $message,
            ]);

            return 'الخدمة غير متاحة حالياً، يرجى المحاولة لاحقاً.';
        }
    }

    private function buildPrompt(string $blogs, string $message): string
    {
        return "Context: You are an ai assistant. Respond in user's language.
Facts: Only use these blogs: {$blogs}
Rule: If the question is not about these blogs but about general topics respond in general but in same topic.
Rule: If the question is not related to these context say 'تستطيع السؤال عن مواضيع المدونة فقط !' or 'You can only ask about blog topics!' in the same language of the question.


User: {$message}
AI:";
    }

    private function getRelevantBlogs(string $userQuery): string
    {
        $keywords = explode(' ', $userQuery);

        return Blog::latest()
            ->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    if (mb_strlen($word) > 3) {
                        $q->orWhere('title->ar', 'LIKE', "%$word%")
                            ->orWhere('title->en', 'LIKE', "%$word%");
                    }
                }
            })
            ->limit(3)
            ->get()
            ->map(fn ($b) => 'Title: '.$b->title['ar'] ?? $b->title['en'])
            ->implode(' | ');
    }
}
