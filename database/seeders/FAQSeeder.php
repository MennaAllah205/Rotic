<?php

namespace Database\Seeders;

use App\Models\FAQ;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FAQSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing FAQs
        FAQ::query()->delete();

        // Greetings
        $this->createFAQ('مرحبا', 'hi', 'مرحباً! أنا هنا لمساعدتك في الأسئلة المتعلقة بمدوناتنا. لا تتردد في السؤال عن أي موضوع متعلق بالمدونات!', 'تحيات');
        $this->createFAQ('أهلا', 'hello', 'أهلاً بك! أنا هنا لمساعدتك في الأسئلة المتعلقة بمدوناتنا. لا تتردد في السؤال عن أي موضوع متعلق بالمدونات!', 'تحيات');
        $this->createFAQ('سلام', 'hey', 'سلام! أنا هنا لمساعدتك في الأسئلة المتعلقة بمدوناتنا. لا تتردد في السؤال عن أي موضوع متعلق بالمدونات!', 'تحيات');

        // Blog content
        $this->createFAQ('ما هو محتوى المدونة؟', 'What is blog content?', 'محتوى المدونة هو النص الرئيسي للمقالة، متوفر باللغتين العربية والإنجليزية. يمكن أن يحتوي على معلومات مفصلة عن الموضوع ويتم عرضه باللغة التي يختارها المستخدم.', 'محتوى');
        $this->createFAQ('ما هو محتوى المدونة', 'What is blog content', 'Blog content is main text of article, available in both Arabic and English. It can contain detailed information about the topic and is displayed in user\'s chosen language.', 'محتوى');

        // Blog count
        $this->createFAQ('ماهو عدد المدونات', 'how many blogs', 'يوجد حالياً مدونات متعددة في الموقع. يمكنك استكشاف جميع المدونات المتاحة من خلال قائمة المدونات أو البحث عن مواضيع محددة.', 'عدد');
        $this->createFAQ('كم عدد المدونات', 'how many blogs', 'There are currently multiple blogs available on site. You can explore all available blogs through the blog list or search for specific topics.', 'عدد');

        // Blog system
        $this->createFAQ('ما هو نظام المدونات في هذا الموقع؟', 'What is the blog system on this website?', 'نظام المدونات هو نظام متعدد اللغات يدعم العربية والإنجليزية. كل مدونة لها عنوان ومحتوى متعدد اللغات، يمكن تصنيفها ضمن فئات، وتدعم صورة واحدة محسّنة باستخدام Spatie Media Library.', 'عام');
        $this->createFAQ('What is the blog system on this website?', 'ما هو نظام المدونات في هذا الموقع', 'The blog system is a multilingual system supporting Arabic and English. Each blog has a title and content in multiple languages, can be categorized, and supports one optimized image using Spatie Media Library.', 'عام');

        // Search
        $this->createFAQ('كيف يمكنني البحث عن مدونات معينة؟', 'How can I search for specific blogs?', 'يمكن البحث عن المدونات باستخدام الذكاء الاصطناعي الذي يحلل محتوى المدونات ويجد الأكثر صلة بسؤالك. النظام يستخدم تقنية embedding للتشابه الدلالي.', 'بحث');
        $this->createFAQ('How can I search for specific blogs?', 'كيف يمكنني البحث عن مدونات معينة', 'You can search for blogs using AI that analyzes blog content and finds the most relevant to your question. The system uses embedding technology for semantic similarity.', 'بحث');

        // Categories
        $this->createFAQ('هل المدونات منظمة في فئات؟', 'Are blogs organized in categories?', 'نعم، كل مدونة مرتبطة بفئة محددة. هذا يساعد في تنظيم المحتوى وتسهيل الوصول إلى المواضيع المتشابهة.', 'تنظيم');
        $this->createFAQ('Are blogs organized in categories?', 'هل المدونات منظمة في فئات', 'Yes, each blog is associated with a specific category. This helps organize content and facilitate access to similar topics.', 'تنظيم');

        // Media
        $this->createFAQ('ما هي خصائص صور المدونات؟', 'What are the characteristics of blog images?', 'كل مدونة تدعم صورة واحدة فقط. الصور يتم معالجتها تلقائياً بأبعاد 800x800 بكسل وجودة 70% مع تحسين حدة الصورة. النظام يستخدم Spatie Media Library لإدارة الوسائط.', 'وسائط');
        $this->createFAQ('What are the characteristics of blog images?', 'ما هي خصائص صور المدونات', 'Each blog supports only one image. Images are automatically processed at 800x800 pixels with 70% quality and sharpening. The system uses Spatie Media Library for media management.', 'وسائط');

        // Updates
        $this->createFAQ('هل المدونات محدثة بانتظام؟', 'Are blogs updated regularly?', 'النظام يعرض أحدث المدونات أولاً. يتم تخزين المدونات مؤقتاً لمدة 10 دقائق لضمان الأداء السريع مع تحديث المحتوى بانتظام.', 'تحديثات');
        $this->createFAQ('Are blogs updated regularly?', 'هل المدونات محدثة بانتظام', 'The system displays the newest blogs first. Blogs are cached for 10 minutes to ensure fast performance while updating content regularly.', 'تحديثات');

        // Languages
        $this->createFAQ('ما هي اللغات المدعومة في المدونات؟', 'What languages are supported in blogs?', 'النظام يدعم العربية والإنجليزية بشكل كامل. كل مدونة لها عنوان ومحتوى متوفر في كلتا اللغتين، ويمكن للذكاء الاصطناعي الإجابة بنفس لغة المستخدم.', 'لغات');
        $this->createFAQ('What languages are supported in blogs?', 'ما هي اللغات المدعومة في المدونات', 'The system fully supports Arabic and English. Each blog has title and content available in both languages, and AI can respond in the user\'s language.', 'لغات');

        // Titles
        $this->createFAQ('كيف يتم كتابة عناوين المدونات؟', 'How are blog titles written?', 'عناوين المدونات يتم كتابتها باللغتين العربية والإنجليزية. كل عنوان يتم تخزينه كحقل متعدد اللغات يدعم الترجمة الكاملة بين اللغتين.', 'عناوين');
        $this->createFAQ('How are blog titles written?', 'كيف يتم كتابة عناوين المدونات', 'Blog titles are written in both Arabic and English. Each title is stored as a multilingual field supporting full translation between both languages.', 'عناوين');
    }

    private function createFAQ(string $arQuestion, string $enQuestion, string $answer, string $category): void
    {
        FAQ::create([
            'question' => [
                'ar' => $arQuestion,
                'en' => $enQuestion
            ],
            'answer' => $answer,
            'category' => $category,
            'order' => 0,
            'is_active' => true
        ]);
    }
}
