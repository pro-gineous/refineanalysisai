<?php
// صفحة بسيطة لاختبار اتصال OpenAI بشكل مباشر

// استيراد الإعدادات
require_once '../vendor/autoload.php';

// تعيين معالج الخطأ
error_reporting(E_ALL);
ini_set('display_errors', 1);

// الحصول على المفتاح من ملف .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// معلومات API
$apiKey = $_ENV['OPENAI_API_KEY'] ?? '';
$model = $_ENV['OPENAI_MODEL'] ?? 'gpt-3.5-turbo';

// فحص المفتاح
if (empty($apiKey) || strlen($apiKey) < 20) {
    die("مفتاح API غير صالح أو مفقود. يرجى التحقق من ملف .env");
}

try {
    // إنشاء عميل OpenAI مباشرة
    $client = OpenAI::client($apiKey);
    
    // طلب API بسيط
    $result = $client->chat()->create([
        'model' => $model,
        'messages' => [
            ['role' => 'system', 'content' => 'أنت مساعد مفيد.'],
            ['role' => 'user', 'content' => 'قل مرحباً باللغة العربية والإنجليزية.']
        ],
        'max_tokens' => 50,
        'temperature' => 0.7,
    ]);
    
    // استخراج الرد
    $content = isset($result->choices[0]->message->content) ? $result->choices[0]->message->content : 'No content received';
    $tokensUsed = isset($result->usage->total_tokens) ? $result->usage->total_tokens : 0;
    
    // عرض النتائج
    echo "<h1>اختبار OpenAI API</h1>";
    echo "<div style='direction: rtl; text-align: right; font-family: Arial;'>";
    echo "<p style='color: green; font-weight: bold;'>✅ الاتصال ناجح!</p>";
    echo "<p><strong>النموذج المستخدم:</strong> $model</p>";
    echo "<p><strong>الرموز المستخدمة:</strong> $tokensUsed</p>";
    echo "<p><strong>الرد:</strong><br> $content</p>";
    echo "<p><strong>طول مفتاح API:</strong> " . strlen($apiKey) . " حرف</p>";
    echo "<hr>";
    echo "<h2>بيانات JSON كاملة:</h2>";
    echo "<pre dir='ltr' style='background: #f5f5f5; padding: 10px; border-radius: 5px;'>" . json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
    echo "</div>";
    
} catch (Exception $e) {
    // عرض الخطأ
    echo "<h1>اختبار OpenAI API</h1>";
    echo "<div style='direction: rtl; text-align: right; font-family: Arial;'>";
    echo "<p style='color: red; font-weight: bold;'>❌ فشل الاتصال!</p>";
    echo "<p><strong>رسالة الخطأ:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>الملف:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>السطر:</strong> " . $e->getLine() . "</p>";
    echo "<p><strong>النموذج المطلوب:</strong> $model</p>";
    echo "<p><strong>طول مفتاح API:</strong> " . strlen($apiKey) . " حرف</p>";
    echo "<p><strong>PHP منفذ:</strong> " . phpversion() . "</p>";
    echo "</div>";
    
    // عرض المزيد من التفاصيل للمطورين
    echo "<hr>";
    echo "<h2>تفاصيل الخطأ:</h2>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px;'>";
    echo "Exception Type: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "Code: " . $e->getCode() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n\n";
    echo "Trace:\n" . $e->getTraceAsString();
    echo "</pre>";
}
?>
