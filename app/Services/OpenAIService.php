<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use OpenAI;

class OpenAIService
{
    protected $apiKey;
    protected $model;
    protected $maxTokens;
    protected $temperature;
    protected $client;
    
    /**
     * Initialize OpenAI service with configuration from database or environment
     */
    public function __construct()
    {
        // Try to get settings from database first
        $dbSettings = $this->getSettingsFromDatabase();
        
        // Set API credentials and default parameters with safer fallbacks
        $this->apiKey = $dbSettings['openai_api_key'] ?? config('openai.api_key', env('OPENAI_API_KEY', 'sk-'));
        
        // Use safe model fallbacks - gpt-3.5-turbo is more widely available than gpt-4o
        $configuredModel = $dbSettings['default_model'] ?? config('openai.model', env('OPENAI_MODEL', 'gpt-3.5-turbo'));
        $this->model = $this->getSafeModel($configuredModel);
        
        // Ensure sensible parameter values
        $this->maxTokens = $this->getSafeMaxTokens($dbSettings['max_tokens'] ?? config('openai.max_tokens', 2048));
        $this->temperature = $this->getSafeTemperature($dbSettings['temperature'] ?? config('openai.temperature', 0.7));
        
        // Log values before client initialization for debugging
        Log::info('OpenAI initialization parameters:', [
            'api_key_length' => strlen($this->apiKey),
            'model' => $this->model,
            'max_tokens' => $this->maxTokens,
            'temperature' => $this->temperature
        ]);
        
        // Initialize OpenAI client with API key, with additional error handling
        try {
            // Validate API key format before attempting to create client
            if (empty($this->apiKey) || $this->apiKey === 'sk-' || strlen($this->apiKey) < 20) {
                Log::warning('API key appears to be invalid or missing');
                throw new \Exception('OpenAI API key is missing or invalid');
            }
            
            // Inicializar el cliente con configuración explícita
            $options = [
                'api_key' => $this->apiKey,
                'organization' => env('OPENAI_ORGANIZATION', null),
                'base_uri' => 'https://api.openai.com/v1',
                'timeout' => 30, // Aumentar tiempo de espera a 30 segundos
                'http_errors' => false
            ];
            
            // Crear cliente con opciones avanzadas
            $this->client = \OpenAI::factory()
                ->withApiKey($this->apiKey)
                ->withHttpClient(new \GuzzleHttp\Client(['timeout' => 30]))
                ->make();
                
            // Log explicit success message
            Log::info('OpenAI client initialized successfully with model: ' . $this->model . ' and timeout: 30 seconds');
        } catch (\Exception $e) {
            Log::error('Failed to initialize OpenAI client: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            // We'll throw the error when an actual API call is made
        }
    }
    
    /**
     * Get AI settings from database
     * @return array
     */
    protected function getSettingsFromDatabase(): array
    {
        // Cache settings for 5 minutes to reduce database queries
        return Cache::remember('openai_settings', 300, function () {
            try {
                // First try the settings table
                $settings = [];
                $dbSettings = \DB::table('settings')->where('group', 'ai')->get();
                
                foreach ($dbSettings as $setting) {
                    $settings[$setting->key] = $setting->value;
                }
                
                // If no settings found and the table might not exist, return fallback settings
                if (empty($settings)) {
                    Log::warning('No OpenAI settings found in database, using env values');
                    return [
                        'openai_api_key' => env('OPENAI_API_KEY', ''),
                        'default_model' => env('OPENAI_MODEL', 'gpt-3.5-turbo'),
                        'max_tokens' => env('OPENAI_MAX_TOKENS', 2048),
                        'temperature' => env('OPENAI_TEMPERATURE', 0.7)
                    ];
                }
                
                return $settings;
            } catch (\Exception $e) {
                Log::error('Error fetching OpenAI settings: ' . $e->getMessage());
                // Return values from .env file as fallback
                return [
                    'openai_api_key' => env('OPENAI_API_KEY', ''),
                    'default_model' => env('OPENAI_MODEL', 'gpt-3.5-turbo'),
                    'max_tokens' => env('OPENAI_MAX_TOKENS', 2048),
                    'temperature' => env('OPENAI_TEMPERATURE', 0.7)
                ];
            }
        });
    }
    
    /**
     * Generate a response using OpenAI GPT model
     *
     * @param string $prompt The prompt to send to OpenAI
     * @param array $options Additional options for the request
     * @return string The generated response
     */
    public function generateResponse(string $prompt, array $options = []): string
    {
        $success = true;
        $errorMessage = null;
        $totalTokens = 0;
        $tokensInput = 0;
        $tokensOutput = 0;
        $estimatedCost = 0;
        $responseText = '';
        
        // Extract request-specific options
        $systemMessage = $options['system_message'] ?? null;
        $requestType = $options['request_type'] ?? 'general';
        $userId = auth()->id() ?? 0;
        $model = $options['model'] ?? $this->model;
        $temperature = $options['temperature'] ?? $this->temperature;
        $maxTokens = $options['max_tokens'] ?? $this->maxTokens;
        
        // Debug log for tracking API usage
        Log::info('AI Journey Request', [
            'user_id' => $userId,
            'model' => $model,
            'request_type' => $requestType,
            'prompt_length' => strlen($prompt),
        ]);
        
        try {
            // Enhanced API key validation with more specific error message
            if (empty($this->apiKey) || $this->apiKey === 'sk-' || strlen($this->apiKey) < 20) {
                throw new \Exception('OpenAI API key is invalid or missing. Please check your API key in .env file or database settings.');
            }
            
            // Build message history
            $messages = [];
            
            // Add system message if provided
            if ($systemMessage) {
                $messages[] = [
                    'role' => 'system',
                    'content' => $systemMessage
                ];
                
                // Log system message length for debugging
                Log::debug('AI Journey system message', [
                    'length' => strlen($systemMessage),
                    'first_20_chars' => substr($systemMessage, 0, 20) . '...'
                ]);
            }
            
            // Add previous messages if provided
            if (isset($options['previous_messages']) && is_array($options['previous_messages'])) {
                $messageCount = 0;
                foreach ($options['previous_messages'] as $msg) {
                    if (isset($msg['role']) && isset($msg['content'])) {
                        $messages[] = [
                            'role' => $msg['role'],
                            'content' => $msg['content']
                        ];
                        $messageCount++;
                    }
                }
                
                // Log message count for debugging
                Log::debug('AI Journey previous messages', ['count' => $messageCount]);
            }
            
            // Add current user message
            $messages[] = [
                'role' => 'user',
                'content' => $prompt
            ];
            
            // Debug log API call attempt
            Log::info('OpenAI API call attempt', [
                'model' => $model,
                'message_count' => count($messages),
                'temperature' => $temperature,
                'max_tokens' => $maxTokens
            ]);
            
            // Call OpenAI API with retry logic
            $attempts = 0;
            $maxAttempts = 2;
            
            while ($attempts < $maxAttempts) {
                try {
                    // Initiate connection timeout with explicit handle
                    $startTime = microtime(true);
                    
                    // Explicit client initialization check before API call
                    if (!$this->client) {
                        throw new \Exception('OpenAI client is not initialized correctly.');
                    }
                    
                    Log::debug('Making OpenAI API request with parameters:', [
                        'model' => $model,
                        'messages_count' => count($messages),
                        'max_tokens' => $maxTokens,
                        'temperature' => $temperature,
                    ]);
                    
                    // IMPORTANTE: Usamos la sintaxis más compatible con todas las versiones de la biblioteca
                    $response = $this->client->chat()->create([
                        'model' => $model,
                        'messages' => $messages,
                        'max_tokens' => $maxTokens,
                        'temperature' => $temperature,
                    ]);
                    
                    $apiCallTime = microtime(true) - $startTime;
                    
                    // Extract response text con validación para evitar errores
                    $responseText = isset($response->choices[0]->message->content) 
                        ? $response->choices[0]->message->content 
                        : 'No response content available';
                        
                    // Extraer información de tokens con compatibilidad para diferentes versiones
                    $tokensInput = $response->usage->prompt_tokens ?? 0;
                    $tokensOutput = $response->usage->completion_tokens ?? 0;
                    
                    // Calcular total tokens - algunas versiones no proporcionan total_tokens
                    $totalTokens = isset($response->usage->total_tokens)
                        ? $response->usage->total_tokens
                        : ($tokensInput + $tokensOutput);
                    
                    // Registrar estructura de respuesta para diagnóstico
                    Log::debug('OpenAI Response Structure', [
                        'response_keys' => is_object($response) ? array_keys((array)$response) : [],
                        'has_usage' => isset($response->usage),
                        'usage_keys' => isset($response->usage) ? array_keys((array)$response->usage) : []
                    ]);
                    
                    // Calculate estimated cost based on current OpenAI pricing
                    $estimatedCost = $this->calculateCost($model, $tokensInput, $tokensOutput);
                    
                    // Log successful response
                    Log::info('OpenAI API Response', [
                        'tokens' => $totalTokens,
                        'model' => $model,
                        'success' => true,
                        'cost' => $estimatedCost,
                        'response_time_ms' => round($apiCallTime * 1000)
                    ]);
                    
                    break; // Success, exit the retry loop
                } catch (\Exception $e) {
                    $attempts++;
                    
                    // Enhanced error logging with specific exception details
                    Log::error('OpenAI API Error on attempt ' . $attempts, [
                        'exception' => get_class($e),
                        'message' => $e->getMessage(),
                        'code' => $e->getCode(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine()
                    ]);
                    
                    // If we've hit max attempts, rethrow
                    if ($attempts >= $maxAttempts) {
                        throw $e;
                    }
                    
                    // Otherwise wait before retry
                    sleep(1);
                }
            }
        } catch (\Exception $e) {
            // Log error and update variables for error case
            Log::error('OpenAI API Error: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $success = false;
            $errorMessage = $e->getMessage();
            
            // More specific error handling for different scenarios
            if (strpos($e->getMessage(), 'rate limit') !== false) {
                $responseText = 'خدمة الذكاء الاصطناعي تواجه طلبًا كبيرًا حاليًا. يرجى المحاولة مرة أخرى بعد قليل.';
            } elseif (strpos($e->getMessage(), 'authenticate') !== false || strpos($e->getMessage(), 'api key') !== false) {
                $responseText = 'كانت هناك مشكلة في المصادقة مع خدمة الذكاء الاصطناعي. يرجى الاتصال بالمسؤول لتحديث مفتاح API.';
            } elseif (strpos($e->getMessage(), 'timed out') !== false || strpos($e->getMessage(), 'timeout') !== false) {
                $responseText = 'انتهت مهلة الاتصال بخدمة الذكاء الاصطناعي. يرجى المحاولة مرة أخرى لاحقًا عندما يكون الخادم أقل انشغالاً.';
            } elseif (strpos($e->getMessage(), 'curl') !== false || strpos($e->getMessage(), 'network') !== false) {
                $responseText = 'حدثت مشكلة في الشبكة أثناء الاتصال بخدمة الذكاء الاصطناعي. يرجى التحقق من اتصالك بالإنترنت والمحاولة مرة أخرى.';
            } else {
                // Generic error with specific error code for tracing
                $errorCode = 'ERR' . substr(md5($e->getMessage()), 0, 6);
                $responseText = 'عذرًا، واجهت خطأ أثناء معالجة طلبك (رمز: ' . $errorCode . '). يرجى المحاولة مرة أخرى لاحقًا.';
            }
        }
        
        // Record the request in database with improved error handling
        try {
            // Sanitize metadata to prevent JSON serialization issues
            $sanitizedMetadata = [];
            if (is_array($options)) {
                foreach ($options as $key => $value) {
                    if ($key !== 'system_message' && $key !== 'previous_messages') {
                        $sanitizedMetadata[$key] = is_scalar($value) ? $value : json_encode($value);
                    }
                }
            }
            
            // Truncate long text fields to prevent database issues
            $truncatedPrompt = mb_substr($prompt, 0, 15000); // Limit prompt length
            $truncatedResponse = mb_substr($responseText, 0, 15000); // Limit response length
            $truncatedError = $errorMessage ? mb_substr($errorMessage, 0, 1000) : null;
            
            // Check if AIRequest model exists, if not skip database logging
            if (class_exists('App\\Models\\AIRequest')) {
                // Create the record with sanitized data
                \App\Models\AIRequest::create([
                    'user_id' => $userId,
                    'request_type' => $requestType,
                    'model' => $model,
                    'tokens_input' => (int)$tokensInput,
                    'tokens_output' => (int)$tokensOutput,
                    'total_tokens' => (int)$totalTokens,
                    'estimated_cost' => (float)$estimatedCost,
                    'prompt' => $truncatedPrompt,
                    'response' => $truncatedResponse,
                    'metadata' => $sanitizedMetadata,
                    'success' => (bool)$success,
                    'error_message' => $truncatedError,
                    'ip_address' => request()->ip() ?: '127.0.0.1',
                ]);
                
                Log::info('AI request recorded successfully');
            } else {
                Log::warning('AIRequest model not found, skipping database logging');
            }
        } catch (\Exception $dbError) {
            // Just log the database error, don't change the response
            Log::error('Error recording AI request: ' . $dbError->getMessage(), [
                'file' => $dbError->getFile(),
                'line' => $dbError->getLine()
            ]);
        }
        
        return $responseText;
    }
    
    /**
     * Get safe model name that is guaranteed to be available
     * @param string $configuredModel The configured model name
     * @return string Safe model name to use
     */
    protected function getSafeModel(string $configuredModel): string
    {
        // Whitelist of supported models
        $supportedModels = [
            'gpt-4o',
            'gpt-4-turbo',
            'gpt-4-0125-preview',
            'gpt-4',
            'gpt-3.5-turbo',
            'gpt-3.5-turbo-0125',
            'gpt-3.5-turbo-1106',
            'gpt-3.5-turbo-0613',
            'gpt-3.5-turbo-16k'
        ];
        
        // Log the requested model
        Log::info('OpenAI model requested: ' . $configuredModel);
        
        // If configured model is in the whitelist, use it
        if (in_array($configuredModel, $supportedModels)) {
            return $configuredModel;
        }
        
        // If the model starts with a supported prefix, allow it (for future versions)
        foreach ($supportedModels as $supportedModel) {
            if (strpos($configuredModel, $supportedModel) === 0) {
                Log::info('Using model with supported prefix: ' . $configuredModel);
                return $configuredModel;
            }
        }
        
        // Otherwise use a safe default that is guaranteed to exist
        Log::warning('Unknown model requested: ' . $configuredModel . '. Using gpt-3.5-turbo instead.');
        return 'gpt-3.5-turbo';
    }
    
    /**
     * Get a safe max tokens value
     * @param int|string $maxTokens The configured max tokens value
     * @return int Safe max tokens value to use
     */
    protected function getSafeMaxTokens($maxTokens): int
    {
        $tokens = intval($maxTokens);
        
        // Ensure max tokens is between 100 and 4000
        if ($tokens < 100) {
            return 100;
        }
        
        if ($tokens > 4000) {
            return 4000;
        }
        
        return $tokens;
    }
    
    /**
     * Get a safe temperature value
     * @param float|string $temperature The configured temperature value
     * @return float Safe temperature value to use
     */
    protected function getSafeTemperature($temperature): float
    {
        $temp = floatval($temperature);
        
        // Ensure temperature is between 0 and 1
        if ($temp < 0) {
            return 0.0;
        }
        
        if ($temp > 1) {
            return 1.0;
        }
        
        return $temp;
    }
    
    /**
     * Calculate the estimated cost for an OpenAI API request
     * 
     * @param string $model The model used
     * @param int $inputTokens Number of input tokens
     * @param int $outputTokens Number of output tokens
     * @return float Estimated cost in USD
     */
    protected function calculateCost(string $model, int $inputTokens, int $outputTokens): float
    {
        // Current OpenAI pricing (May 2025)
        $pricing = [
            'gpt-4o' => ['input' => 0.00005, 'output' => 0.00015],
            'gpt-4-turbo' => ['input' => 0.00003, 'output' => 0.00006],
            'gpt-4' => ['input' => 0.00003, 'output' => 0.00006],
            'gpt-3.5-turbo' => ['input' => 0.0000005, 'output' => 0.0000015],
            'gpt-3.5-turbo-16k' => ['input' => 0.0000010, 'output' => 0.0000020],
            // Default fallback rates
            'default' => ['input' => 0.00001, 'output' => 0.00002]
        ];
        
        // Get pricing for the model or use default
        $modelPricing = $pricing[$model] ?? $pricing['default'];
        
        // Calculate cost
        $inputCost = $inputTokens * $modelPricing['input'];
        $outputCost = $outputTokens * $modelPricing['output'];
        
        return round($inputCost + $outputCost, 5);
    }
}
