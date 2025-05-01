<?php
// Script to update OpenAI settings in the database

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// API Key from our test
$apiKey = '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';

// Define settings
$settings = [
    'openai_api_key' => $apiKey,
    'default_model' => 'gpt-4o',
    'max_tokens' => 2048,
    'temperature' => 0.7,
    'enable_ai_journey' => true,
    'enable_idea_generation' => true,
    'enable_project_analysis' => true,
    'daily_usage_limit' => 500,
    'usage_per_request' => 1
];

// Update or create settings
foreach ($settings as $key => $value) {
    echo "Updating setting: $key... ";
    
    try {
        // Check if setting exists
        $setting = DB::table('settings')->where('key', $key)->first();
        
        if ($setting) {
            // Update existing setting
            DB::table('settings')->where('key', $key)->update([
                'value' => $value,
                'group' => 'ai'
            ]);
            echo "Updated successfully.\n";
        } else {
            // Create new setting
            DB::table('settings')->insert([
                'key' => $key,
                'value' => $value,
                'group' => 'ai'
            ]);
            echo "Created successfully.\n";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

// Add the OPENAI_API_KEY to .env file to ensure it's available for command-line operations
try {
    $envFile = file_get_contents(__DIR__ . '/.env');
    
    // Check if OPENAI_API_KEY already exists
    if (preg_match('/OPENAI_API_KEY=/', $envFile)) {
        // Replace existing key
        $envFile = preg_replace('/OPENAI_API_KEY=.*/', 'OPENAI_API_KEY=' . $apiKey, $envFile);
    } else {
        // Add new key
        $envFile .= "\nOPENAI_API_KEY=" . $apiKey;
    }
    
    // Write back to .env file
    file_put_contents(__DIR__ . '/.env', $envFile);
    echo "Updated OPENAI_API_KEY in .env file.\n";
} catch (Exception $e) {
    echo "Error updating .env file: " . $e->getMessage() . "\n";
}

echo "\nOpenAI settings updated successfully. Your AI-Journey should now be fully functional.\n";
echo "To test it, visit: http://localhost:8000/user/ai-journey/data-gathering\n";
