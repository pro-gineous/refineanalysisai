<?php

// This file is for testing OpenAI configuration directly
require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Http;

// Try to get key from .env file
$envFile = file_get_contents(__DIR__ . '/.env');
$apiKey = '';

// Extract API key if it exists in .env
if (preg_match('/OPENAI_API_KEY=([^\s]+)/', $envFile, $matches)) {
    $apiKey = $matches[1];
}

// Get from database if not in .env
if (empty($apiKey)) {
    // Connect to database and get from settings table
    $db = new PDO('mysql:host=localhost;dbname=ai_crm', 'root', '');
    $stmt = $db->query("SELECT value FROM settings WHERE `key` = 'openai_api_key'");
    if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $apiKey = $result['value'];
    }
}

// Use fallback if still empty
if (empty($apiKey)) {
    $apiKey = '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';
}

echo "OpenAI API Key (first few chars): " . substr($apiKey, 0, 10) . "...\n";

// Test connection using simple HTTP request
try {
    echo "Testing OpenAI API connection...\n";
    
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
    ])->get('https://api.openai.com/v1/models');

    if ($response->successful()) {
        echo "Connection successful! Available models:\n";
        $models = $response->json()['data'];
        
        foreach ($models as $model) {
            echo "- " . $model['id'] . "\n";
        }
        
        echo "\nTest complete. If you see models listed above, your OpenAI API connection is working.\n";
    } else {
        echo "Error connecting to OpenAI API: " . $response->json()['error']['message'] . "\n";
        echo "HTTP Status: " . $response->status() . "\n";
    }
} catch (\Exception $e) {
    echo "Exception occurred: " . $e->getMessage() . "\n";
    echo "Please verify your API key and network connection.\n";
}
