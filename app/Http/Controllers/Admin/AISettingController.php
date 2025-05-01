<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

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
        ], $settings);
        
        // Get available models
        $aiModels = [
            'gpt-4o' => 'GPT-4o (Latest)',
            'gpt-4-turbo' => 'GPT-4 Turbo',
            'gpt-4' => 'GPT-4',
            'gpt-3.5-turbo' => 'GPT-3.5 Turbo',
        ];
        
        return view('admin.ai-settings.index', compact('settings', 'aiModels'));
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
}
