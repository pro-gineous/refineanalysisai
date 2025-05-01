<?php

// This file is for testing OpenAI configuration
require_once __DIR__ . '/vendor/autoload.php';

use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Get API key from environment or use test key
$apiKey = $_ENV['OPENAI_API_KEY'] ?? 'YOUR_TEST_KEY';

echo "OpenAI API Key (first few chars): " . substr($apiKey, 0, 5) . "...\n";

// Create a temporary OpenAI client for testing
$client = OpenAI::client($apiKey);

try {
    // Try to list models as a basic connectivity test
    echo "Testing OpenAI API connection...\n";
    $models = $client->models()->list();
    
    echo "Connection successful! Available models:\n";
    foreach ($models->data as $model) {
        echo "- " . $model->id . "\n";
    }
    
    echo "\nTest complete. If you see models listed above, your OpenAI API connection is working.\n";
} catch (\Exception $e) {
    echo "Error connecting to OpenAI API: " . $e->getMessage() . "\n";
    echo "Please verify your API key and network connection.\n";
}
