<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'name' => [
                'ar' => 'اسم المتجر بالعربي',
                'en' => 'Store Name in English'
            ],
            'facebook' => 'https://facebook.com/my-page',
            'youtube' => 'https://youtube.com/my-channel',
            'meta' => [
                'title' => 'My SEO Title',
                'description' => 'My SEO Description'
            ],
            'email' => 'admin@example.com',
            'first_phone_number' => '0123456789',
            'second_phone_number' => '0987654321',
            // 'logo' => 'default_logo.png', // يفضل رفع الصورة يدوياً أو تركها نل

        ]);
    }
}
