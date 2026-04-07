<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories first
        $categories = $this->createCategories();
        
        // Create sample blogs
        $this->createBlogs($categories);
    }

    private function createCategories(): array
    {
        $categories = [
            [
                'name' => [
                    'en' => 'Technology',
                    'ar' => 'التقنية'
                ],
                'description' => [
                    'en' => 'Latest in technology and innovation',
                    'ar' => 'أحدث التقنيات والابتكارات'
                ]
            ],
            [
                'name' => [
                    'en' => 'Business',
                    'ar' => 'الأعمال'
                ],
                'description' => [
                    'en' => 'Business insights and strategies',
                    'ar' => 'رؤى الأعمال والاستراتيجيات'
                ]
            ],
            [
                'name' => [
                    'en' => 'Lifestyle',
                    'ar' => 'نمط الحياة'
                ],
                'description' => [
                    'en' => 'Tips for better living',
                    'ar' => 'نصائح لحياة أفضل'
                ]
            ]
        ];

        $createdCategories = [];
        foreach ($categories as $categoryData) {
            $createdCategories[] = Category::create($categoryData);
        }

        return $createdCategories;
    }

    private function createBlogs(array $categories): void
    {
        $blogs = [
            [
                'title' => [
                    'en' => 'Getting Started with Laravel AI',
                    'ar' => 'البدء مع Laravel AI'
                ],
                'content' => [
                    'en' => 'Laravel AI provides a unified, expressive API for interacting with AI providers such as OpenAI, Anthropic, Gemini, and more. In this article, we\'ll explore how to integrate AI into your Laravel applications.',
                    'ar' => 'يوفر Laravel AI واجهة برمجية موحدة وواضحة للتفاعل مع مقدمي الخدمات الذكاء الاصطناعي مثل OpenAI و Anthropic و Gemini وغيرها. في هذا المقال، سوف نستكشف كيفية دمج الذكاء الاصطناعي في تطبيقات Laravel الخاصة بك.'
                ],
                'meta' => [
                    'en' => [
                        'description' => 'Learn how to integrate AI into Laravel applications using the Laravel AI SDK',
                        'keywords' => 'Laravel, AI, Machine Learning, OpenAI, Gemini'
                    ],
                    'ar' => [
                        'description' => 'تعلم كيفية دمج الذكاء الاصطناعي في تطبيقات Laravel باستخدام Laravel AI SDK',
                        'keywords' => 'Laravel, الذكاء الاصطناعي, تعلم الآلة, OpenAI, Gemini'
                    ]
                ],
                'category_name' => 'Technology'
            ],
            [
                'title' => [
                    'en' => 'Building Scalable Web Applications',
                    'ar' => 'بناء تطبيقات ويق قابلة للتوسع'
                ],
                'content' => [
                    'en' => 'Scalability is crucial for modern web applications. Learn about the best practices for building applications that can handle growth and increased traffic.',
                    'ar' => 'قابلية التوسع أمر حاسم لتطبيقات الويق الحديثة. تعرف على أفضل الممارسات لبناء تطبيقات يمكنها التعامل مع النمو وزيادة حركة المرور.'
                ],
                'meta' => [
                    'en' => [
                        'description' => 'Best practices for building scalable web applications',
                        'keywords' => 'Scalability, Web Development, Architecture, Performance'
                    ],
                    'ar' => [
                        'description' => 'أفضل الممارسات لبناء تطبيقات ويق قابلة للتوسع',
                        'keywords' => 'قابلية التوسع, تطوير الويق, البنية, الأداء'
                    ]
                ],
                'category_name' => 'Business'
            ],
            [
                'title' => [
                    'en' => 'The Future of Remote Work',
                    'ar' => 'مستقبل العمل عن بعد'
                ],
                'content' => [
                    'en' => 'Remote work has transformed the way we approach our careers. Discover the trends and tools shaping the future of distributed teams.',
                    'ar' => 'لقد حوّل العمل عن بعد الطريقة التي نتعامل بها مع مساراتنا المهنية. اكتشف الاتجاهات والأدوات التي تشكل مستقبل الفرق الموزعة.'
                ],
                'meta' => [
                    'en' => [
                        'description' => 'Exploring trends and tools for remote work and distributed teams',
                        'keywords' => 'Remote Work, Distributed Teams, Future of Work, Collaboration'
                    ],
                    'ar' => [
                        'description' => 'استكشاف الاتجاهات والأدوات للعمل عن بعد والفرق الموزعة',
                        'keywords' => 'العمل عن بعد, الفرق الموزعة, مستقبل العمل, التعاون'
                    ]
                ],
                'category_name' => 'Lifestyle'
            ],
            [
                'title' => [
                    'en' => 'Introduction to Machine Learning',
                    'ar' => 'مقدمة في تعلم الآلة'
                ],
                'content' => [
                    'en' => 'Machine Learning is revolutionizing industries across the globe. This beginner-friendly guide will help you understand the fundamentals and get started with ML.',
                    'ar' => 'تعلم الآلة يحدث ثورة في الصناعات حول العالم. هذا الدليل المناسب للمبتدئين سيساعدك على فهم الأساسيات والبدء في تعلم الآلة.'
                ],
                'meta' => [
                    'en' => [
                        'description' => 'A beginner\'s guide to understanding machine learning concepts',
                        'keywords' => 'Machine Learning, AI, Data Science, Algorithms'
                    ],
                    'ar' => [
                        'description' => 'دليل للمبتدئين لفهم مفاهيم تعلم الآلة',
                        'keywords' => 'تعلم الآلة, الذكاء الاصطناعي, علم البيانات, الخوارزميات'
                    ]
                ],
                'category_name' => 'Technology'
            ],
            [
                'title' => [
                    'en' => 'Digital Marketing Strategies',
                    'ar' => 'استراتيجيات التسويق الرقمي'
                ],
                'content' => [
                    'en' => 'Effective digital marketing is essential for business growth in today\'s competitive landscape. Learn proven strategies to boost your online presence.',
                    'ar' => 'التسويق الرقمي الفعال ضروري لنمو الأعمال في المشهد التنافسي اليوم. تعلم الاستراتيجيات المثبتة لتعزيز وجودك على الإنترنت.'
                ],
                'meta' => [
                    'en' => [
                        'description' => 'Proven digital marketing strategies for business growth',
                        'keywords' => 'Digital Marketing, SEO, Social Media, Business Growth'
                    ],
                    'ar' => [
                        'description' => 'استراتيجيات تسويق رقمي مثبتة لنمو الأعمال',
                        'keywords' => 'التسويق الرقمي, SEO, وسائل التواصل الاجتماعي, نمو الأعمال'
                    ]
                ],
                'category_name' => 'Business'
            ],
            [
                'title' => [
                    'en' => 'Healthy Living in the Digital Age',
                    'ar' => 'العيش الصحي في العصر الرقمي'
                ],
                'content' => [
                    'en' => 'Balancing technology use with healthy lifestyle choices is more important than ever. Discover tips for maintaining wellness in our connected world.',
                    'ar' => 'موازنة استخدام التكنولوجيا مع خيارات نمط الحياة الصحي أكثر أهمية من أي وقت مضى. اكتشف نصائح للحفاظ على الصحة في عالمنا المتصل.'
                ],
                'meta' => [
                    'en' => [
                        'description' => 'Tips for maintaining health and wellness in the digital age',
                        'keywords' => 'Health, Wellness, Digital Balance, Lifestyle'
                    ],
                    'ar' => [
                        'description' => 'نصائح للحفاظ على الصحة والعافية في العصر الرقمي',
                        'keywords' => 'الصحة, العافية, التوازن الرقمي, نمط الحياة'
                    ]
                ],
                'category_name' => 'Lifestyle'
            ]
        ];

        foreach ($blogs as $blogData) {
            // Find the category
            $category = collect($categories)->first(function ($cat) use ($blogData) {
                return $cat->name['en'] === $blogData['category_name'];
            });

            // Create the blog
            $blog = Blog::create([
                'category_id' => $category?->id,
                'title' => $blogData['title'],
                'content' => $blogData['content'],
                'slug' => Str::slug($blogData['title']['en']),
                'meta' => $blogData['meta'],
            ]);

            // Add sample image if needed (you can uncomment this if you have images)
            // $this->addSampleImage($blog);
        }
    }

    private function addSampleImage(Blog $blog): void
    {
        // This is a placeholder for adding sample images
        // You can implement this method to add actual images to your blogs
        
        // Example: if you have sample images in storage
        // $imagePath = 'sample-images/blog-' . $blog->id . '.jpg';
        // if (Storage::disk('public')->exists($imagePath)) {
        //     $blog->addMediaFromDisk($imagePath, 'public')
        //         ->toMediaCollection('image');
        // }
    }
}
