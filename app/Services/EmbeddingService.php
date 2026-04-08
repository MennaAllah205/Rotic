<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmbeddingService
{
    private string $apiKey;

    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1/models';

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY', '');
    }

    public function generateEmbedding(string $text): ?array
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer '.$this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post("{$this->baseUrl}/embeddings", [
                    'model' => 'text-embedding-3-small',
                    'input' => $text,
                    'encoding_format' => 'float',
                ]);
            Log::info('Embedding API Response', ['response' => $response->json()]);

            return $response->successful()
                ? $response->json('data.0.embedding')
                : null;

        } catch (\Exception $e) {
            Log::error('Embedding Service Error: '.$e->getMessage());

            return null;
        }
    }

    public function calculateCosineSimilarity(array $a, array $b): float
    {
        if (count($a) !== count($b) || empty($a) || empty($b)) {
            return 0;
        }

        $dot = array_sum(array_map(fn ($x, $y) => $x * $y, $a, $b));
        $magA = sqrt(array_sum(array_map(fn ($x) => $x ** 2, $a)));
        $magB = sqrt(array_sum(array_map(fn ($y) => $y ** 2, $b)));

        return ($magA && $magB) ? $dot / ($magA * $magB) : 0;
    }
}
