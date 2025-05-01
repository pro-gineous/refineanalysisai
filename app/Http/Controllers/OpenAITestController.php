<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenAI;
use Illuminate\Support\Facades\Cache;

class OpenAITestController extends Controller
{
    /**
     * Test direct connection to OpenAI API
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function testConnection(Request $request)
    {
        $responseData = [
            'success' => false,
            'message' => '',
            'details' => []
        ];
        
        try {
            // Get API key directly from env or request
            $apiKey = env('OPENAI_API_KEY');
            $model = env('OPENAI_MODEL', 'gpt-3.5-turbo');
            
            // Log test attempt
            Log::info('Testing OpenAI API connection', [
                'model' => $model,
                'key_length' => strlen($apiKey),
            ]);
            
            // Validate key
            if (empty($apiKey) || strlen($apiKey) < 20) {
                return response()->json([
                    'success' => false,
                    'message' => 'API key is missing or invalid',
                    'details' => ['key_length' => strlen($apiKey)]
                ]);
            }
            
            // Create client directly without service class
            $client = OpenAI::client($apiKey);
            
            // Simple request with minimal content
            $result = $client->chat()->create([
                'model' => $model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                    ['role' => 'user', 'content' => 'Say hello in Arabic with translation']
                ],
                'max_tokens' => 50,
                'temperature' => 0.7,
            ]);
            
            // Extract response
            $content = $result->choices[0]->message->content;
            $tokensUsed = $result->usage->total_tokens;
            
            // Successful response
            return response()->json([
                'success' => true,
                'message' => 'Connection successful',
                'response' => $content,
                'tokens' => $tokensUsed,
                'model' => $model
            ]);
            
        } catch (\Exception $e) {
            // Log detailed error
            Log::error('OpenAI Test Error: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return error details
            return response()->json([
                'success' => false,
                'message' => 'Error connecting to OpenAI: ' . $e->getMessage(),
                'details' => [
                    'exception' => get_class($e),
                    'file' => basename($e->getFile()),
                    'line' => $e->getLine()
                ]
            ]);
        }
    }
}
