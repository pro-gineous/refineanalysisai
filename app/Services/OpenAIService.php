<?php

namespace App\Services;

use OpenAI;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use OpenAI\Client;
use App\Models\AIRequest;
use Illuminate\Support\Facades\Auth;

class OpenAIService
{
    protected $client;
    protected $apiKey;
    protected $model;
    protected $maxTokens;
    protected $temperature;

    /**
     * Initialize OpenAI service with settings from config and database
     */
    public function __construct()
    {
        // Try to get settings from database first
        $dbSettings = $this->getSettingsFromDatabase();
        
        // Set API credentials and default parameters
        $this->apiKey = $dbSettings['openai_api_key'] ?? config('openai.api_key', env('OPENAI_API_KEY', ''));
        $this->model = $dbSettings['default_model'] ?? config('openai.model', 'gpt-4o');
        $this->maxTokens = intval($dbSettings['max_tokens'] ?? config('openai.max_tokens', 2048));
        $this->temperature = floatval($dbSettings['temperature'] ?? config('openai.temperature', 0.7));
        
        // Initialize OpenAI client with API key
        try {
            $this->client = OpenAI::client($this->apiKey);
            Log::info('OpenAI client initialized successfully');
        } catch (\Exception $e) {
            Log::error('Failed to initialize OpenAI client: ' . $e->getMessage());
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
                $settings = [];
                $dbSettings = \DB::table('settings')->where('group', 'ai')->get();
                
                foreach ($dbSettings as $setting) {
                    $settings[$setting->key] = $setting->value;
                }
                
                return $settings;
            } catch (\Exception $e) {
                Log::error('Error fetching OpenAI settings: ' . $e->getMessage());
                return [];
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
    /**
     * Generate a response using OpenAI GPT model with improved handling
     *
     * @param string $prompt The prompt to send to OpenAI
     * @param array $options Additional options for the request
     * @return string The generated response
     * @throws \Exception When API usage limit is exceeded
     */
    public function generateResponse(string $prompt, array $options = []): string
    {
        // Get current user and settings
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        $requestType = $options['request_type'] ?? 'chat';
        $model = $options['model'] ?? $this->model;
        $success = true;
        $errorMessage = null;
        $responseText = '';
        $tokensInput = 0;
        $tokensOutput = 0;
        $totalTokens = 0;
        $estimatedCost = 0;
        
        // Check for usage limits if enabled
        $settings = $this->getSettingsFromDatabase();
        $usageLimitEnabled = isset($settings['daily_usage_limit']) && intval($settings['daily_usage_limit']) > 0;
        
        if ($usageLimitEnabled) {
            $dailyLimit = intval($settings['daily_usage_limit']);
            $todayUsage = $this->getTodayUsage();
            
            if ($todayUsage >= $dailyLimit) {
                Log::warning('Daily AI usage limit exceeded', [
                    'user_id' => $userId,
                    'limit' => $dailyLimit,
                    'usage' => $todayUsage
                ]);
                
                throw new \Exception('Daily AI usage limit reached. Please try again tomorrow or contact an administrator.');
            }
        }
        
        try {
            // Check if feature is enabled
            if (isset($options['feature']) && !$this->isFeatureEnabled($options['feature'])) {
                throw new \Exception("The requested AI feature '{$options['feature']}' is not enabled.");
            }
            
            // Get options or defaults
            $systemMessage = $options['system_message'] ?? 'You are a helpful assistant for our project management platform.';
            $maxTokens = $options['max_tokens'] ?? $this->maxTokens;
            $temperature = $options['temperature'] ?? $this->temperature;
            $previousMessages = $options['previous_messages'] ?? [];
            
            // Build message history for context
            $messages = [['role' => 'system', 'content' => $systemMessage]];
            
            // Add previous messages if provided (for conversation context)
            foreach ($previousMessages as $message) {
                $messages[] = $message;
            }
            
            // Add current user message
            $messages[] = ['role' => 'user', 'content' => $prompt];
            
            // Log the start of the request
            Log::info('OpenAI API Request', [
                'model' => $model,
                'request_type' => $requestType,
                'user_id' => $userId,
                'message_count' => count($messages)
            ]);
            
            // Call OpenAI API with retry logic
            $attempts = 0;
            $maxAttempts = 2;
            
            while ($attempts < $maxAttempts) {
                try {
                    $response = $this->client->chat()->create([
                        'model' => $model,
                        'messages' => $messages,
                        'max_tokens' => $maxTokens,
                        'temperature' => $temperature,
                    ]);
                    
                    // Extract response and token information
                    $responseText = $response->choices[0]->message->content;
                    $tokensInput = $response->usage->prompt_tokens ?? 0;
                    $tokensOutput = $response->usage->completion_tokens ?? 0;
                    $totalTokens = $response->usage->total_tokens ?? 0;
                    
                    // Calculate estimated cost based on current OpenAI pricing
                    $estimatedCost = $this->calculateCost($model, $tokensInput, $tokensOutput);
                    
                    // Log successful response
                    Log::info('OpenAI API Response', [
                        'tokens' => $totalTokens,
                        'model' => $model,
                        'success' => true,
                        'cost' => $estimatedCost
                    ]);
                    
                    break; // Success, exit the retry loop
                } catch (\Exception $e) {
                    $attempts++;
                    
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
            Log::error('OpenAI API Error: ' . $e->getMessage());
            $success = false;
            $errorMessage = $e->getMessage();
            $responseText = $e->getMessage();
            
            // For user-facing errors, provide a friendly message
            if (strpos($e->getMessage(), 'rate limit') !== false) {
                $responseText = 'The AI service is currently experiencing high demand. Please try again in a moment.';
            } elseif (strpos($e->getMessage(), 'authenticate') !== false || strpos($e->getMessage(), 'api key') !== false) {
                $responseText = 'There was an authentication issue with the AI service. Please contact an administrator.';
            } else {
                $responseText = 'Sorry, I encountered an error while processing your request. Please try again later.';
            }
        }
        
        // Record the request in database
        try {
            AIRequest::create([
                'user_id' => $userId,
                'request_type' => $requestType,
                'model' => $model,
                'tokens_input' => $tokensInput,
                'tokens_output' => $tokensOutput,
                'total_tokens' => $totalTokens,
                'estimated_cost' => $estimatedCost,
                'prompt' => $prompt,
                'response' => $responseText,
                'metadata' => $options,
                'success' => $success,
                'error_message' => $errorMessage,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Exception $dbError) {
            // Just log the database error, don't change the response
            Log::error('Error recording AI request: ' . $dbError->getMessage());
        }
        
        return $responseText;
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
            'gpt-4' => ['input' => 0.00003, 'output' => 0.00006],
            'gpt-3.5-turbo' => ['input' => 0.0000005, 'output' => 0.0000015],
            // Default fallback rates
            'default' => ['input' => 0.00001, 'output' => 0.00002]
        ];
        
        // Get rates for the model or use default
        $rates = $pricing[$model] ?? $pricing['default'];
        
        // Calculate cost
        return ($inputTokens * $rates['input']) + ($outputTokens * $rates['output']);
    }
    
    /**
     * Get the total AI usage for today
     * 
     * @return int Number of requests today
     */
    protected function getTodayUsage(): int
    {
        try {
            return Cache::remember('ai_usage_today', 60, function () {
                return AIRequest::whereDate('created_at', now()->toDateString())->count();
            });
        } catch (\Exception $e) {
            Log::error('Error checking AI usage: ' . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Check if a specific AI feature is enabled
     * 
     * @param string $feature Feature name to check
     * @return bool Whether the feature is enabled
     */
    protected function isFeatureEnabled(string $feature): bool
    {
        $settings = $this->getSettingsFromDatabase();
        $key = 'enable_' . $feature;
        
        return isset($settings[$key]) && $settings[$key] == '1';
    }

    /**
     * Generate ideas based on a given topic or project description
     *
     * @param string $description Description of the project or topic
     * @return array List of generated ideas
     */
    public function generateIdeas(string $description): array
    {
        $prompt = "Generate 5 creative ideas related to the following project or topic: \"{$description}\". Provide each idea with a title and a brief description.";
        
        $systemMessage = "You are a creative assistant that helps users brainstorm innovative ideas for their projects. Be specific, practical, and think outside the box.";
        
        $response = $this->generateResponse($prompt, [
            'system_message' => $systemMessage,
            'temperature' => 0.9, // Higher temperature for more creativity
        ]);
        
        // Parse the response into structured ideas
        $ideas = $this->parseIdeasResponse($response);
        
        return $ideas;
    }

    /**
     * Parse the AI response into structured ideas
     *
     * @param string $response The raw AI response
     * @return array The structured ideas
     */
    protected function parseIdeasResponse(string $response): array
    {
        $ideas = [];
        
        // Simple parsing - assumes responses are numbered 1-5
        preg_match_all('/(\d+\.\s*.*?)(?=\d+\.|$)/s', $response, $matches);
        
        if (!empty($matches[0])) {
            foreach ($matches[0] as $ideaText) {
                // Extract title and description
                if (preg_match('/(?:\d+\.\s*)(.*?)(?:\n|:)(.*)/s', $ideaText, $parts)) {
                    $title = trim($parts[1]);
                    $description = trim($parts[2]);
                    
                    $ideas[] = [
                        'title' => $title,
                        'description' => $description
                    ];
                }
            }
        }
        
        // If parsing failed, return the whole response as a single idea
        if (empty($ideas)) {
            $ideas[] = [
                'title' => 'Generated Idea',
                'description' => $response
            ];
        }
        
        return $ideas;
    }

    /**
     * Analyze a project and provide recommendations
     *
     * @param array $project The project data to analyze
     * @return array Analysis and recommendations
     */
    public function analyzeProject(array $project): array
    {
        $projectInfo = "Project Title: {$project['title']}\n";
        $projectInfo .= "Description: {$project['description']}\n";
        $projectInfo .= "Status: {$project['status']}\n";
        $projectInfo .= "Timeline: {$project['start_date']} to {$project['end_date']}\n";
        
        $prompt = "Analyze the following project and provide:\n" .
                 "1. Strengths of the project\n" .
                 "2. Potential risks or challenges\n" .
                 "3. Three specific recommendations for improvement\n\n" .
                 $projectInfo;
                 
        $systemMessage = "You are an expert project analyst who helps identify strengths, weaknesses, and opportunities for improvement in projects. Be specific, practical, and actionable in your analysis.";
        
        $response = $this->generateResponse($prompt, [
            'system_message' => $systemMessage,
        ]);
        
        return [
            'analysis' => $response,
            'project_id' => $project['id'] ?? null,
        ];
    }
}
