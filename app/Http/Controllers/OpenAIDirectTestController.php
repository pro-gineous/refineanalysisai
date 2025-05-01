<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenAI;

class OpenAIDirectTestController extends Controller
{
    /**
     * Test direct connection to OpenAI API with detailed debugging
     */
    public function testDirectConnection(Request $request)
    {
        try {
            // 1. Get API key and model directly from env
            $apiKey = env('OPENAI_API_KEY');
            $model = env('OPENAI_MODEL', 'gpt-3.5-turbo');
            
            // 2. Log details (length of key, model name)
            Log::info('OpenAI Direct Test', [
                'api_key_length' => strlen($apiKey),
                'model' => $model,
                'timestamp' => now()->toDateTimeString()
            ]);
            
            // 3. Create OpenAI client directly
            $client = OpenAI::client($apiKey);
            
            // 4. Make a simple API request
            $result = $client->chat()->create([
                'model' => $model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                    ['role' => 'user', 'content' => 'Say hello']
                ],
                'max_tokens' => 50
            ]);
            
            // 5. Verificar la estructura de respuesta
            $message = isset($result->choices[0]->message->content) 
                ? $result->choices[0]->message->content 
                : 'No content in response';
                
            // La estructura de usage ha cambiado en versiones recientes
            $tokensInfo = [];
            if (isset($result->usage)) {
                // Intentar obtener todas las propiedades de uso posibles
                $tokensInfo = [
                    'prompt_tokens' => $result->usage->prompt_tokens ?? 0,
                    'completion_tokens' => $result->usage->completion_tokens ?? 0,
                    // Para compatibilidad con diferentes versiones
                    'total' => isset($result->usage->total_tokens) 
                        ? $result->usage->total_tokens 
                        : (($result->usage->prompt_tokens ?? 0) + ($result->usage->completion_tokens ?? 0))
                ];
            }
            
            // Registrar la estructura completa para debug
            Log::info('OpenAI response structure', [
                'has_choices' => isset($result->choices),
                'has_usage' => isset($result->usage),
                'result_keys' => array_keys((array)$result)
            ]);
            
            // Return the result as JSON
            return response()->json([
                'success' => true,
                'message' => $message,
                'model' => $model,
                'tokens_info' => $tokensInfo,
                'response_time' => now()->toDateTimeString(),
                'debug' => [
                    'response_keys' => array_keys((array)$result)
                ]
            ]);
            
        } catch (\Exception $e) {
            // 6. Log the error with complete details
            Log::error('OpenAI Direct Test Error: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // 7. Return error details
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'error_type' => get_class($e),
                'file' => basename($e->getFile()),
                'line' => $e->getLine(),
                'debug_info' => [
                    'api_key_length' => strlen($apiKey ?? ''),
                    'model' => $model ?? 'undefined',
                    'php_version' => PHP_VERSION
                ]
            ], 500);
        }
    }
}
