<?php
// Simple cURL test for OpenAI API

// API Key - use this one for testing
$apiKey = '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';

echo "Testing OpenAI API with key: " . substr($apiKey, 0, 10) . "...\n\n";

// Initialize cURL session
$ch = curl_init('https://api.openai.com/v1/models');

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);

// Execute cURL session
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Check for cURL errors
if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch) . "\n";
    curl_close($ch);
    exit(1);
}

// Close cURL session
curl_close($ch);

// Process response
echo "HTTP Status Code: " . $httpCode . "\n\n";

if ($httpCode == 200) {
    $data = json_decode($response, true);
    echo "Connection successful! Available models:\n";
    
    foreach ($data['data'] as $model) {
        echo "- " . $model['id'] . "\n";
    }
    
    echo "\nYour OpenAI API connection is working properly!\n";
} else {
    $error = json_decode($response, true);
    echo "Error connecting to OpenAI API:\n";
    echo "Message: " . ($error['error']['message'] ?? 'Unknown error') . "\n";
    echo "Type: " . ($error['error']['type'] ?? 'Unknown type') . "\n";
    echo "Raw Response: " . $response . "\n";
}
