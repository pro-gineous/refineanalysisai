<?php
// Test script for AI chat functionality

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\OpenAIService;
use Illuminate\Support\Facades\Log;

// Enable detailed error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Starting OpenAI test...\n\n";

try {
    // Create OpenAI service instance
    echo "Creating OpenAI service instance...\n";
    $openAI = new OpenAIService();
    
    // Test simple prompt
    $prompt = "Hello, can you help me with a project idea?";
    echo "Sending test prompt: {$prompt}\n\n";
    
    // Send request to OpenAI
    $response = $openAI->generateResponse($prompt, [
        'system_message' => 'You are a helpful assistant for project planning.',
        'temperature' => 0.7,
        'request_type' => 'test'
    ]);
    
    echo "Received response from OpenAI:\n\n";
    echo $response . "\n\n";
    echo "Test completed successfully!\n";
    
    // Check for any requests logged in the database
    $count = \App\Models\AIRequest::count();
    echo "Total AI requests in database: {$count}\n";
    
    // Get the most recent request
    $latestRequest = \App\Models\AIRequest::latest()->first();
    if ($latestRequest) {
        echo "Latest request details:\n";
        echo "  - Time: " . $latestRequest->created_at . "\n";
        echo "  - Model: " . $latestRequest->model . "\n";
        echo "  - Tokens: " . $latestRequest->total_tokens . "\n";
        echo "  - Success: " . ($latestRequest->success ? 'Yes' : 'No') . "\n";
        
        if (!$latestRequest->success && $latestRequest->error_message) {
            echo "  - Error: " . $latestRequest->error_message . "\n";
        }
    }
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
