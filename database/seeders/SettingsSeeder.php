<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // تعريف الإعدادات الافتراضية للموقع
        $defaultSettings = [
            // إعدادات عامة
            [
                'key' => 'site_name',
                'value' => 'Executive Dashboard',
                'group' => 'general',
                'type' => 'text',
                'name' => 'اسم الموقع',
                'description' => 'الاسم الرئيسي للموقع المستخدم في العنوان وفي أماكن أخرى',
                'is_public' => true,
                'sort_order' => 1
            ],
            [
                'key' => 'site_description',
                'value' => 'منصة متكاملة لإدارة المشاريع والأفكار',
                'group' => 'general',
                'type' => 'text',
                'name' => 'وصف الموقع',
                'description' => 'وصف قصير للموقع يستخدم في محركات البحث وفي الميتا تاج',
                'is_public' => true,
                'sort_order' => 2
            ],
            [
                'key' => 'contact_email',
                'value' => 'admin@example.com',
                'group' => 'general',
                'type' => 'text',
                'name' => 'البريد الإلكتروني للتواصل',
                'description' => 'عنوان البريد الإلكتروني المستخدم للتواصل',
                'is_public' => true,
                'sort_order' => 3
            ],
            
            // إعدادات الشعارات والصور
            [
                'key' => 'site_logo',
                'value' => 'logos/default-logo.png', // سيتم نسخه لاحقًا من مجلد public
                'group' => 'branding',
                'type' => 'image',
                'name' => 'شعار الموقع',
                'description' => 'الشعار الرئيسي للموقع (المفضل: 200 × 60 بكسل)',
                'is_public' => true,
                'sort_order' => 1
            ],
            [
                'key' => 'admin_logo',
                'value' => 'logos/default-admin-logo.png',
                'group' => 'branding',
                'type' => 'image',
                'name' => 'شعار لوحة التحكم',
                'description' => 'الشعار المستخدم في لوحة تحكم المشرف (المفضل: 160 × 50 بكسل)',
                'is_public' => false,
                'sort_order' => 2
            ],
            [
                'key' => 'user_dashboard_logo',
                'value' => 'logos/default-user-logo.png',
                'group' => 'branding',
                'type' => 'image',
                'name' => 'شعار لوحة تحكم المستخدم',
                'description' => 'الشعار المستخدم في لوحة تحكم المستخدم (المفضل: 160 × 50 بكسل)',
                'is_public' => true,
                'sort_order' => 3
            ],
            [
                'key' => 'favicon',
                'value' => 'logos/favicon.ico',
                'group' => 'branding',
                'type' => 'image',
                'name' => 'أيقونة الموقع (Favicon)',
                'description' => 'أيقونة الموقع التي تظهر في المتصفح (المفضل: 32 × 32 بكسل، بامتداد ico)',
                'is_public' => true,
                'sort_order' => 4
            ],
            
            // إعدادات الفوتر
            [
                'key' => 'footer_text',
                'value' => '© ' . date('Y') . ' Executive Dashboard. جميع الحقوق محفوظة',
                'group' => 'footer',
                'type' => 'text',
                'name' => 'نص حقوق النشر',
                'description' => 'نص حقوق النشر الذي يظهر في أسفل الصفحة',
                'is_public' => true,
                'sort_order' => 1
            ],
            [
                'key' => 'footer_links',
                'value' => json_encode([
                    ['title' => 'سياسة الخصوصية', 'url' => '/privacy-policy'],
                    ['title' => 'شروط الاستخدام', 'url' => '/terms'],
                    ['title' => 'تواصل معنا', 'url' => '/contact']
                ]),
                'group' => 'footer',
                'type' => 'json',
                'name' => 'روابط الفوتر',
                'description' => 'الروابط التي تظهر في الفوتر',
                'is_public' => true,
                'sort_order' => 2
            ],
            [
                'key' => 'social_links',
                'value' => json_encode([
                    ['platform' => 'twitter', 'url' => 'https://twitter.com/example'],
                    ['platform' => 'linkedin', 'url' => 'https://linkedin.com/company/example'],
                    ['platform' => 'github', 'url' => 'https://github.com/example']
                ]),
                'group' => 'footer',
                'type' => 'json',
                'name' => 'روابط التواصل الاجتماعي',
                'description' => 'روابط صفحات التواصل الاجتماعي التي تظهر في الفوتر',
                'is_public' => true,
                'sort_order' => 3
            ],
            
            // إعدادات متقدمة
            [
                'key' => 'enable_registration',
                'value' => '1',
                'group' => 'advanced',
                'type' => 'boolean',
                'name' => 'تفعيل التسجيل',
                'description' => 'السماح للمستخدمين الجدد بالتسجيل في الموقع',
                'is_public' => false,
                'sort_order' => 1
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'group' => 'advanced',
                'type' => 'boolean',
                'name' => 'وضع الصيانة',
                'description' => 'تفعيل وضع الصيانة لمنع الوصول للموقع باستثناء المشرفين',
                'is_public' => false,
                'sort_order' => 2
            ],
            [
                'key' => 'google_analytics_id',
                'value' => '',
                'group' => 'advanced',
                'type' => 'text',
                'name' => 'معرف Google Analytics',
                'description' => 'معرف حساب Google Analytics لتتبع زيارات الموقع',
                'is_public' => false,
                'sort_order' => 3
            ]
        ];
        
        // حفظ الإعدادات الافتراضية
        foreach ($defaultSettings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
        
        // إنشاء دليل الشعارات والملفات الافتراضية إذا لم تكن موجودة
        $storageLogosPath = storage_path('app/public/logos');
        if (!File::exists($storageLogosPath)) {
            File::makeDirectory($storageLogosPath, 0755, true);
        }
        
        // نسخ الصور الافتراضية من مجلد public إلى مجلد التخزين إذا لم تكن موجودة
        $defaultImages = [
            'default-logo.png',
            'default-admin-logo.png',
            'default-user-logo.png',
            'favicon.ico'
        ];
        
        foreach ($defaultImages as $image) {
            $sourcePath = public_path('img/defaults/' . $image);
            $destinationPath = $storageLogosPath . '/' . $image;
            
            // إنشاء صورة افتراضية إذا لم تكن موجودة في مجلد المصدر
            if (!File::exists($sourcePath)) {
                $this->command->info("إنشاء صورة افتراضية: {$image}");
                // سنقوم بإنشاء ملفات الصور الافتراضية لاحقًا
            }
            
            // نسخ الصورة إلى مجلد التخزين
            if (File::exists($sourcePath) && !File::exists($destinationPath)) {
                File::copy($sourcePath, $destinationPath);
            }
        }
        
        // تنظيف ذاكرة التخزين المؤقت للإعدادات
        Setting::clearCache();
    }
}
