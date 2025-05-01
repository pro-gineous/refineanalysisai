@extends('layouts.admin')

@section('title', 'AI Settings')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800">AI Integration Settings</h2>
        <p class="mt-1 text-sm text-gray-600">Configure the OpenAI integration and AI behavior throughout the platform.</p>
    </div>
    
    <form action="{{ route('admin.ai-settings.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <!-- API Configuration Card -->
            <div class="bg-white shadow overflow-hidden rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900">API Configuration</h3>
                    </div>
                </div>
                <div class="px-6 py-5 space-y-6">
                    <div>
                        <label for="openai_api_key" class="block text-sm font-medium text-gray-700 mb-1">OpenAI API Key</label>
                        <div class="relative rounded-md shadow-sm">
                            <input type="password" name="openai_api_key" id="openai_api_key" value="{{ $settings['openai_api_key'] }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" onclick="toggleApiKeyVisibility()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="eye-off-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Your OpenAI API key from <a href="https://platform.openai.com/account/api-keys" target="_blank" class="text-indigo-600 hover:text-indigo-500">platform.openai.com</a>. This is required for all AI functionality.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="default_model" class="block text-sm font-medium text-gray-700 mb-1">Default Model</label>
                            <select name="default_model" id="default_model" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                @foreach($aiModels as $value => $label)
                                    <option value="{{ $value }}" {{ $settings['default_model'] == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500">The default AI model to use for generating responses.</p>
                        </div>
                        
                        <div>
                            <label for="max_tokens" class="block text-sm font-medium text-gray-700 mb-1">Max Tokens</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="number" name="max_tokens" id="max_tokens" min="1" max="4096" value="{{ $settings['max_tokens'] }}" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Maximum number of tokens to generate in a response. 1 token ≈ 4 characters.</p>
                        </div>
                        
                        <div>
                            <label for="temperature" class="block text-sm font-medium text-gray-700 mb-1">Temperature (Creativity)</label>
                            <div class="mt-1">
                                <input type="range" name="temperature" id="temperature" min="0" max="1" step="0.1" value="{{ $settings['temperature'] }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                <div class="flex justify-between text-xs text-gray-600 px-1">
                                    <span>0.0</span>
                                    <span>0.5</span>
                                    <span>1.0</span>
                                </div>
                                <p class="text-center text-sm font-medium mt-1">Current: <span id="temperature-value">{{ $settings['temperature'] }}</span></p>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Higher values (0.8+) make output more random, lower values (0.2-) make it more focused and deterministic.</p>
                        </div>
                        
                        <div>
                            <label for="test_connection" class="block text-sm font-medium text-gray-700 mb-1">Test Connection</label>
                            <button type="button" id="test-connection" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Test API Connection
                            </button>
                            <div id="api-status" class="mt-2 hidden">
                                <div id="api-success" class="text-green-600 text-sm hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    API connection successful!
                                </div>
                                <div id="api-error" class="text-red-600 text-sm hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    <span id="api-error-message">API connection failed.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- AI Features Card -->
            <div class="bg-white shadow overflow-hidden rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900">AI Features</h3>
                    </div>
                </div>
                <div class="px-6 py-5 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 transition duration-150 hover:shadow-md">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <input type="hidden" name="enable_ai_journey" value="0">
                                    <input type="checkbox" name="enable_ai_journey" id="enable_ai_journey" value="1" {{ $settings['enable_ai_journey'] ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                </div>
                                <div class="ml-3">
                                    <label for="enable_ai_journey" class="font-medium text-gray-800">AI Journey</label>
                                    <p class="text-sm text-gray-500 mt-1">Enable the AI-assisted creation journey for projects and ideas with step-by-step guidance.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 transition duration-150 hover:shadow-md">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <input type="hidden" name="enable_idea_generation" value="0">
                                    <input type="checkbox" name="enable_idea_generation" id="enable_idea_generation" value="1" {{ $settings['enable_idea_generation'] ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                </div>
                                <div class="ml-3">
                                    <label for="enable_idea_generation" class="font-medium text-gray-800">Idea Generation</label>
                                    <p class="text-sm text-gray-500 mt-1">Allow AI to suggest innovative ideas based on user inputs and preferences.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 transition duration-150 hover:shadow-md">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <input type="hidden" name="enable_project_analysis" value="0">
                                    <input type="checkbox" name="enable_project_analysis" id="enable_project_analysis" value="1" {{ $settings['enable_project_analysis'] ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                </div>
                                <div class="ml-3">
                                    <label for="enable_project_analysis" class="font-medium text-gray-800">Project Analysis</label>
                                    <p class="text-sm text-gray-500 mt-1">Enable AI to analyze projects and provide insights and recommendations for improvement.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Usage Limits Card -->
            <div class="bg-white shadow overflow-hidden rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900">Usage Limits</h3>
                    </div>
                </div>
                <div class="px-6 py-5 space-y-6">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Setting usage limits helps control costs. The OpenAI API charges based on token usage. Learn more about <a href="https://openai.com/pricing" target="_blank" class="font-medium underline text-yellow-700 hover:text-yellow-600">OpenAI pricing</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="daily_usage_limit" class="block text-sm font-medium text-gray-700 mb-1">Daily Platform Usage Limit</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="number" name="daily_usage_limit" id="daily_usage_limit" min="1" value="{{ $settings['daily_usage_limit'] }}" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Maximum number of AI requests allowed per day across the entire platform. Set higher for busy platforms.</p>
                        </div>
                        
                        <div>
                            <label for="usage_per_request" class="block text-sm font-medium text-gray-700 mb-1">Usage Points Per Request</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="number" name="usage_per_request" id="usage_per_request" min="1" value="{{ $settings['usage_per_request'] }}" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">How many usage points to deduct for each AI request. Adjust based on request complexity.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Save Settings
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Toggle API key visibility
    function toggleApiKeyVisibility() {
        const input = document.getElementById('openai_api_key');
        const eyeIcon = document.getElementById('eye-icon');
        const eyeOffIcon = document.getElementById('eye-off-icon');
        
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeOffIcon.classList.remove('hidden');
        } else {
            input.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeOffIcon.classList.add('hidden');
        }
    }
    
    // Update temperature value display
    document.getElementById('temperature').addEventListener('input', function() {
        document.getElementById('temperature-value').textContent = this.value;
    });
    
    // Test API connection
    document.getElementById('test-connection').addEventListener('click', function() {
        const apiKey = document.getElementById('openai_api_key').value;
        const apiStatus = document.getElementById('api-status');
        const apiSuccess = document.getElementById('api-success');
        const apiError = document.getElementById('api-error');
        const apiErrorMessage = document.getElementById('api-error-message');
        
        if (!apiKey) {
            apiStatus.classList.remove('hidden');
            apiSuccess.classList.add('hidden');
            apiError.classList.remove('hidden');
            apiErrorMessage.textContent = 'Please enter an API key first.';
            return;
        }
        
        // Show loading state
        this.disabled = true;
        this.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Testing...';
        
        // Make the AJAX request to test the connection
        fetch('/admin/ai-settings/test-connection', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ api_key: apiKey })
        })
        .then(response => response.json())
        .then(data => {
            apiStatus.classList.remove('hidden');
            
            if (data.success) {
                apiSuccess.classList.remove('hidden');
                apiError.classList.add('hidden');
            } else {
                apiSuccess.classList.add('hidden');
                apiError.classList.remove('hidden');
                apiErrorMessage.textContent = data.message || 'API connection failed.';
            }
        })
        .catch(error => {
            apiStatus.classList.remove('hidden');
            apiSuccess.classList.add('hidden');
            apiError.classList.remove('hidden');
            apiErrorMessage.textContent = 'Error: ' + (error.message || 'Unknown error occurred.');
        })
        .finally(() => {
            // Restore button state
            this.disabled = false;
            this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg> Test API Connection';
        });
    });
</script>
@endpush
