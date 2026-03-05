<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>روتك | حلول ذكية لنقاء المياه</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        body { font-family: 'Cairo', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); }
        .gradient-text {
            background: linear-gradient(to right, #2563eb, #06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 overflow-x-hidden">

    <nav class="fixed w-full z-50 glass border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                    <i data-lucide="droplets"></i>
                </div>
                <span class="text-2xl font-black text-blue-900 tracking-tighter">ROTIC <span class="text-blue-500">روتك</span></span>
            </div>
            <div class="hidden md:flex gap-8 font-semibold text-slate-600">
                <a href="#home" class="hover:text-blue-600 transition-colors">الرئيسية</a>
                <a href="#features" class="hover:text-blue-600 transition-colors">مميزاتنا</a>
                <a href="#products" class="hover:text-blue-600 transition-colors">المنتجات</a>
                <a href="#contact" class="hover:text-blue-600 transition-colors">تواصل معنا</a>
            </div>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full font-bold transition-all shadow-md">
                اطلب الآن
            </button>
        </div>
    </nav>

    <section id="home" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute top-0 right-0 -z-10 w-1/2 h-full bg-blue-50 rounded-bl-[200px]"></div>
        <div class="max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center gap-12">
            <div class="flex-1 text-right" data-aos="fade-left">
                <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm font-bold mb-6 inline-block">مستقبل المياه النقية بين يديك</span>
                <h1 class="text-5xl lg:text-7xl font-black text-slate-900 leading-tight mb-6">
                    اشرب مياه <br> <span class="gradient-text">نقية وصحية</span> <br> مع أنظمة روتك
                </h1>
                <p class="text-lg text-slate-600 mb-10 max-w-xl leading-relaxed">
                    نحن في روتك نقدم أحدث تقنيات الفلترة العالمية لنضمن لك ولعائلتك كوب مياه خالي من الشوائب والمعادن الثقيلة. جودة، أمان، واستدامة.
                </p>
                <div class="flex flex-wrap gap-4">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-bold text-lg flex items-center gap-3 shadow-xl shadow-blue-200 transition-transform hover:scale-105">
                        اكتشف المنتجات
                        <i data-lucide="arrow-left"></i>
                    </button>
                    <button class="bg-white border border-slate-200 text-slate-700 px-8 py-4 rounded-2xl font-bold text-lg hover:bg-slate-50 transition-all">
                        مشاهدة الفيديو
                    </button>
                </div>
            </div>
            <div class="flex-1 relative" data-aos="fade-right">
                <div class="relative z-10 w-full aspect-square rounded-[40px] bg-gradient-to-tr from-blue-200 to-cyan-100 overflow-hidden shadow-2xl border-8 border-white">
                    <img src="https://images.unsplash.com/photo-1585704032915-c3400ca199e7?auto=format&fit=crop&q=80&w=800" alt="Water Filter" class="w-full h-full object-cover">
                </div>
                <div class="absolute -bottom-6 -right-6 bg-white p-6 rounded-2xl shadow-2xl z-20 flex items-center gap-4 border border-blue-50" data-aos="zoom-in" data-aos-delay="400">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                        <i data-lucide="check-circle-2"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-bold">نسبة النقاء</p>
                        <p class="text-xl font-black text-slate-900">99.9% مضمونة</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-black mb-16" data-aos="fade-up">لماذا يختار الجميع <span class="text-blue-600">روتك</span>؟</h2>
            <div class="grid md:grid-cols-3 gap-10">
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:shadow-xl transition-all group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <i data-lucide="shield-check" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">أعلى معايير الجودة</h3>
                    <p class="text-slate-600 leading-relaxed">فلاتر حاصلة على شهادات الجودة العالمية لضمان سلامة مياه الشرب.</p>
                </div>
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:shadow-xl transition-all group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <i data-lucide="wrench" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">صيانة دورية</h3>
                    <p class="text-slate-600 leading-relaxed">فريق فني متخصص لخدمات التركيب والصيانة المبرمجة لضمان استمرارية الأداء.</p>
                </div>
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:shadow-xl transition-all group" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <i data-lucide="zap" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">توفير اقتصادي</h3>
                    <p class="text-slate-600 leading-relaxed">وداعاً لشراء زجاجات المياه المكلفة، محطة روتك توفر لك مياه نقية بتكلفة أقل.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="py-20 bg-blue-900 text-white overflow-hidden relative">
        <div class="max-w-5xl mx-auto px-6 text-center relative z-10">
            <h2 class="text-4xl font-black mb-8" data-aos="zoom-in">جاهز لتغيير جودة حياتك؟</h2>
            <p class="text-blue-200 text-xl mb-12">اترك رقمك وسنقوم بالتواصل معك لتقديم استشارة مجانية وفحص جودة مياهك.</p>
            <form class="flex flex-col md:flex-row gap-4 max-w-2xl mx-auto" data-aos="fade-up">
                <input type="text" placeholder="رقم الهاتف" class="flex-1 px-6 py-4 rounded-2xl text-slate-900 focus:ring-4 focus:ring-blue-500 outline-none">
                <button class="bg-blue-500 hover:bg-blue-400 text-white px-10 py-4 rounded-2xl font-black text-lg transition-all shadow-lg">
                    اطلب استشارة مجانية
                </button>
            </form>
        </div>
        <div class="absolute top-0 left-0 w-64 h-64 bg-blue-500 rounded-full opacity-10 -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-500 rounded-full opacity-10 translate-x-1/3 translate-y-1/3"></div>
    </section>

    <footer class="py-10 border-t border-slate-200 text-center text-slate-500 font-semibold">
        <p>© 2026 روتك (Rotic) لتقنيات المياه. جميع الحقوق محفوظة.</p>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize Icons
        lucide.createIcons();
        // Initialize Animations
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });
    </script>
</body>
</html>