<?php
// Script to diagnose and fix AI Journey issues

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\OpenAIService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

echo "=== AI Journey System Diagnostics ===\n\n";

// Check OpenAI API connection
echo "1. Testing OpenAI API connection...\n";
try {
    $curl = curl_init("https://api.openai.com/v1/models");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $apiKey = config('openai.api_key', env('OPENAI_API_KEY', ''));
    
    // Try to get from database if not in config
    if (empty($apiKey)) {
        $setting = DB::table('settings')->where('key', 'openai_api_key')->first();
        if ($setting) {
            $apiKey = $setting->value;
        }
    }
    
    echo "   Using API Key: " . substr($apiKey, 0, 5) . "...\n";
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $apiKey",
        "Content-Type: application/json"
    ]);
    
    $response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    
    if ($status === 200) {
        echo "   ✓ API connection successful\n";
    } else {
        echo "   ✗ API connection failed (HTTP $status)\n";
        echo "   Response: " . substr($response, 0, 200) . "...\n";
    }
} catch (\Exception $e) {
    echo "   ✗ API connection test failed: " . $e->getMessage() . "\n";
}

// Check for empty openai_api_key in database
echo "\n2. Checking database settings...\n";
try {
    $dbSettings = DB::table('settings')->where('group', 'ai')->get();
    echo "   Found " . count($dbSettings) . " AI settings in database\n";
    
    $hasMissingKeys = false;
    foreach ($dbSettings as $setting) {
        echo "   Setting: {$setting->key} = ";
        if (empty($setting->value) && $setting->key === 'openai_api_key') {
            echo "EMPTY (CRITICAL ERROR)\n";
            $hasMissingKeys = true;
        } else if ($setting->key === 'openai_api_key') {
            echo substr($setting->value, 0, 5) . "... (OK)\n";
        } else {
            echo "{$setting->value}\n";
        }
    }
    
    if ($hasMissingKeys) {
        echo "   ✗ Missing critical API settings\n";
    } else {
        echo "   ✓ All required settings found\n";
    }
} catch (\Exception $e) {
    echo "   ✗ Database check failed: " . $e->getMessage() . "\n";
}

// Check route definition
echo "\n3. Checking route definition...\n";
try {
    $routes = app('router')->getRoutes();
    $chatRoute = $routes->getByName('user.ai-journey.chat');
    
    if ($chatRoute) {
        echo "   ✓ Found chat route: " . $chatRoute->uri() . "\n";
        echo "   Controller: " . $chatRoute->getActionName() . "\n";
    } else {
        echo "   ✗ Chat route 'user.ai-journey.chat' not found\n";
    }
} catch (\Exception $e) {
    echo "   ✗ Route check failed: " . $e->getMessage() . "\n";
}

// Fix common issues
echo "\n4. Applying fixes...\n";

// Fix 1: Ensure API key is set correctly
$apiKey = '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';
try {
    $updated = DB::table('settings')
        ->where('key', 'openai_api_key')
        ->where('group', 'ai')
        ->update(['value' => $apiKey]);
    
    if ($updated) {
        echo "   ✓ Updated API key in database\n";
    } else {
        echo "   - API key already up to date\n";
    }
    
    // Clear cache
    Cache::forget('openai_settings');
    echo "   ✓ Cleared settings cache\n";
} catch (\Exception $e) {
    echo "   ✗ API key update failed: " . $e->getMessage() . "\n";
}

// Fix 2: Test direct OpenAI call through our service
echo "\n5. Testing OpenAI service directly...\n";
try {
    $openAI = new OpenAIService();
    $testMessage = "Hi, this is a test message.";
    
    echo "   Sending test message to OpenAI...\n";
    $response = $openAI->generateResponse($testMessage, [
        'system_message' => 'You are a helpful assistant.',
        'request_type' => 'diagnostic_test'
    ]);
    
    if (!empty($response)) {
        echo "   ✓ Received response successfully!\n";
        echo "   First 100 chars: " . substr($response, 0, 100) . "...\n";
    } else {
        echo "   ✗ Empty response received from OpenAI\n";
    }
} catch (\Exception $e) {
    echo "   ✗ OpenAI service test failed: " . $e->getMessage() . "\n";
    echo "   " . $e->getTraceAsString() . "\n";
}

echo "\nDiagnostics completed. Please check the results above to identify and fix any issues.\n";
echo "If everything looks good, try using the AI Journey chat feature again.\n";
