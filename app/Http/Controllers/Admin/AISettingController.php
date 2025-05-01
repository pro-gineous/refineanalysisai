<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AISettingController extends Controller
{
    /**
     * Display the AI settings form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all AI settings
        $settings = DB::table('settings')
            ->where('group', 'ai')
            ->get()
            ->keyBy('key')
            ->map(function ($item) {
                return $item->value;
            })
            ->toArray();
        
        // Set default values if not set
        $settings = array_merge([
            'openai_api_key' => '',
            'default_model' => 'gpt-4o',
            'temperature' => '0.7',
            'max_tokens' => '2048',
            'enable_ai_journey' => '1',
            'enable_idea_generation' => '1',
            'enable_project_analysis' => '1',
            'daily_usage_limit' => '500',
            'usage_per_request' => '1',
            'cached_models' => json_encode([]),
            'last_models_check' => '0',
        ], $settings);
        
        // Default models in case the API is not available
        $aiModels = [
            'gpt-4o' => 'GPT-4o (Latest)',
            'gpt-4-turbo' => 'GPT-4 Turbo',
            'gpt-4' => 'GPT-4',
            'gpt-3.5-turbo' => 'GPT-3.5 Turbo',
        ];
        
        // Try to get models from API if we have an API key and if we haven't checked recently
        $apiKey = $settings['openai_api_key'];
        $lastCheck = (int)$settings['last_models_check'];
        $cachedModels = json_decode($settings['cached_models'] ?? '[]', true);
        
        // Only check every 24 hours
        $shouldRefreshModels = (time() - $lastCheck) > (24 * 60 * 60);
        
        if ($apiKey && ($shouldRefreshModels || empty($cachedModels))) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])->get('https://api.openai.com/v1/models');
                
                if ($response->successful()) {
                    $availableModels = $response->json()['data'] ?? [];
                    $chatModels = [];
                    
                    // Filter for GPT models
                    foreach ($availableModels as $model) {
                        if (strpos($model['id'], 'gpt') === 0) {
                            $modelName = $model['id'];
                            
                            // Create a human-readable name
                            $displayName = $modelName;
                            if ($modelName === 'gpt-4o') {
                                $displayName = 'GPT-4o (Latest)'; 
                            } elseif (strpos($modelName, 'gpt-4') === 0) {
                                $displayName = strtoupper(str_replace('-', ' ', $modelName));
                                if (strpos($modelName, 'turbo') !== false) {
                                    $displayName .= ' (Fast)'; 
                                }
                            } elseif (strpos($modelName, 'gpt-3.5') === 0) {
                                $displayName = strtoupper(str_replace('-', ' ', $modelName));
                                if (strpos($modelName, 'turbo') !== false) {
                                    $displayName .= ' (Fast)';
                                }
                            }
                            
                            $chatModels[$modelName] = $displayName;
                        }
                    }
                    
                    if (!empty($chatModels)) {
                        // Sort models with GPT-4 models first, then GPT-3.5
                        uksort($chatModels, function($a, $b) {
                            if (strpos($a, 'gpt-4') === 0 && strpos($b, 'gpt-3') === 0) {
                                return -1;
                            } elseif (strpos($a, 'gpt-3') === 0 && strpos($b, 'gpt-4') === 0) {
                                return 1;
                            } else {
                                return strcmp($b, $a); // Reverse sort within the same category
                            }
                        });
                        
                        $aiModels = $chatModels;
                        
                        // Cache the models for future use
                        DB::table('settings')->updateOrInsert(
                            ['key' => 'cached_models', 'group' => 'ai'],
                            ['value' => json_encode($chatModels)]
                        );
                        
                        // Update last check timestamp
                        DB::table('settings')->updateOrInsert(
                            ['key' => 'last_models_check', 'group' => 'ai'],
                            ['value' => time()]
                        );
                    }
                }
            } catch (\Exception $e) {
                // If API call fails, we'll use the default models
                // Could log the error here if needed
            }
        } elseif (!empty($cachedModels)) {
            // Use cached models if available
            $aiModels = $cachedModels;
        }
        
        // Usage statistics
        $usageStats = [
            'total_requests' => DB::table('ai_requests')->count(),
            'requests_today' => DB::table('ai_requests')->whereDate('created_at', today())->count(),
            'daily_limit' => (int)$settings['daily_usage_limit'],
        ];
        
        return view('admin.ai-settings.index', compact('settings', 'aiModels', 'usageStats'));
    }
    
    /**
     * Update AI settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'openai_api_key' => 'required|string',
            'default_model' => 'required|string',
            'temperature' => 'required|numeric|min:0|max:1',
            'max_tokens' => 'required|integer|min:1|max:4096',
            'enable_ai_journey' => 'boolean',
            'enable_idea_generation' => 'boolean',
            'enable_project_analysis' => 'boolean',
            'daily_usage_limit' => 'required|integer|min:1',
            'usage_per_request' => 'required|integer|min:1',
        ]);
        
        // Update each setting
        foreach ($validated as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key, 'group' => 'ai'],
                ['value' => $value]
            );
        }
        
        // Clear any cached settings
        Cache::forget('ai_settings');
        
        // Add success message
        return back()->with('success', 'AI settings updated successfully.');
    }
    
    /**
     * Test connection with OpenAI API
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function testConnection(Request $request)
    {
        $request->validate([
            'api_key' => 'required|string',
        ]);
        
        $apiKey = $request->input('api_key');
        
        try {
            // Make a simple request to the OpenAI API to check if the API key is valid
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->get('https://api.openai.com/v1/models');
            
            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Connection successful!',
                    'models' => $response->json()['data'] ?? [],
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'API connection failed: ' . ($response->json()['error']['message'] ?? 'Unknown error'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error connecting to OpenAI API: ' . $e->getMessage(),
            ]);
        }
    }
}
