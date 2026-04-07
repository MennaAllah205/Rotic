<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Services\EmbeddingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateBlogEmbeddings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog-embeddings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate embeddings for all blogs using OpenAI API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to generate embeddings for blogs...');

        $embeddingService = new EmbeddingService();
        $blogs = Blog::whereNull('embedding')->get();

        if ($blogs->isEmpty()) {
            $this->info('No blogs without embeddings found.');
            return 0;
        }

        $this->info("Found {$blogs->count()} blogs without embeddings.");

        $progressBar = $this->output->createProgressBar($blogs->count());
        $progressBar->start();

        $successCount = 0;
        $errorCount = 0;

        foreach ($blogs as $blog) {
            try {
                $title = $blog->title['ar'] ?? $blog->title['en'] ?? '';
                $content = $blog->content['ar'] ?? $blog->content['en'] ?? '';
                $text = trim("{$title}\n\n{$content}");

                if (empty($text)) {
                    $errorCount++;
                    $progressBar->advance();
                    continue;
                }

                $embedding = $embeddingService->generateEmbedding($text);

                if ($embedding) {
                    $blog->embedding = $embedding;
                    $blog->save();
                    $successCount++;
                } else {
                    $errorCount++;
                    Log::warning("Failed to generate embedding for blog ID: {$blog->id}");
                }
            } catch (\Exception $e) {
                $errorCount++;
                Log::error("Error processing blog ID {$blog->id}: " . $e->getMessage());
            }

            $progressBar->advance();

            usleep(100000);
        }

        $progressBar->finish();
        $this->newLine();

        $this->info("Embedding generation completed!");
        $this->info("Success: {$successCount} blogs");
        $this->info("Errors: {$errorCount} blogs");

        return 0;
    }
}
