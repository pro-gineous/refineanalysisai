@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
<div class="p-6 space-y-6 bg-white">
    <!-- Page Header -->
    <div class="border-b border-gray-200 bg-white/90 backdrop-blur-sm pb-5" style="background: linear-gradient(to right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-lg p-1.5 mr-3 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">System Settings</h2>
            </div>
        </div>
        <p class="mt-2 max-w-4xl text-sm text-gray-500">Customize the interface and general settings of the application including logos, colors, and text content.</p>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="mr-3">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="mr-3">
                <p class="text-sm text-red-700">An error occurred while saving settings. Please check your data and try again.</p>
                <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <!-- Settings Form -->
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200">
            <div class="flex -mb-px space-x-6 rtl:space-x-reverse">
                @foreach($groups as $groupKey => $groupName)
                <button type="button" 
                    class="group setting-tab inline-block pb-4 px-1 text-sm font-medium border-b-2 border-transparent hover:border-gray-300 hover:text-gray-600 whitespace-nowrap {{ array_key_first($groups) === $groupKey ? 'border-blue-500 text-blue-600' : 'text-gray-500' }}"
                    data-target="settings-{{ $groupKey }}">
                    
                    @if($groupKey === 'general')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1 mx-auto text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                    </svg>
                    @elseif($groupKey === 'branding')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1 mx-auto text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    @elseif($groupKey === 'footer')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1 mx-auto text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15h18" />
                    </svg>
                    @elseif($groupKey === 'advanced')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1 mx-auto text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    @endif
                    
                    <span class="block mt-1">{{ $groupName }}</span>
                </button>
                @endforeach
            </div>
        </div>

        <!-- Settings Content Sections -->
        <div class="settings-content space-y-6">
            @foreach($groups as $groupKey => $groupName)
            <div id="settings-{{ $groupKey }}" class="setting-panel {{ array_key_first($groups) === $groupKey ? 'block' : 'hidden' }}">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50/70 backdrop-blur-sm border-b" style="background: linear-gradient(to right, rgba(243, 244, 246, 0.7), rgba(249, 250, 251, 0.7));">
                        <h3 class="font-semibold text-lg text-gray-800">{{ $groupName }}</h3>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @if(isset($settings[$groupKey]))
                            @foreach($settings[$groupKey] as $setting)
                            <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                                <div class="md:grid md:grid-cols-3 md:gap-6">
                                    <div class="md:col-span-1">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $setting->name }}</h4>
                                        <p class="mt-1 text-sm text-gray-500">{{ $setting->description }}</p>
                                    </div>
                                    <div class="mt-5 md:mt-0 md:col-span-2">
                                        @if($setting->type === 'text')
                                            <input type="text" 
                                                name="settings[{{ $setting->key }}]" 
                                                value="{{ old('settings.' . $setting->key, $setting->value) }}" 
                                                class="block w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                                
                                        @elseif($setting->type === 'boolean')
                                            <div class="flex items-center">
                                                <div class="relative inline-block w-10 ml-3 align-middle select-none transition duration-200 ease-in">
                                                    <input type="checkbox" 
                                                        name="settings[{{ $setting->key }}]" 
                                                        id="toggle-{{ $setting->key }}" 
                                                        value="1" 
                                                        class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 border-gray-300 appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                                        {{ old('settings.' . $setting->key, $setting->value) ? 'checked' : '' }}>
                                                    <label for="toggle-{{ $setting->key }}" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                                </div>
                                                <label for="toggle-{{ $setting->key }}" class="text-sm text-gray-500">{{ $setting->value ? 'Enabled' : 'Disabled' }}</label>
                                            </div>
                                        
                                        @elseif($setting->type === 'image')
                                            <div class="space-y-4">
                                                @php
                                                    $imageUrl = asset('storage/' . $setting->value);
                                                @endphp
                                                
                                                @if($imageUrl)
                                                <div class="mb-3">
                                                    <img src="{{ $imageUrl }}" alt="{{ $setting->name }}" class="h-16 object-contain border border-gray-200 rounded p-1">
                                                </div>
                                                @endif
                                                
                                                <div class="relative">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2 cursor-pointer text-center py-2 px-4 border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 transition-colors duration-200" 
                                                           for="file-{{ $setting->key }}">
                                                        <span class="flex items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
                                                            </svg>
                                                            Choose New File
                                                        </span>
                                                    </label>
                                                    <input id="file-{{ $setting->key }}" 
                                                           type="file" 
                                                           name="files[{{ $setting->key }}]" 
                                                           class="hidden"
                                                           accept="image/*">
                                                    <p class="mt-1 text-xs text-gray-500">Please use an image with appropriate dimensions for display</p>
                                                </div>
                                            </div>
                                        
                                        @elseif($setting->type === 'json')
                                            <textarea name="settings[{{ $setting->key }}]" 
                                                      rows="4" 
                                                      class="block w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500"
                                                      placeholder="JSON Data">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                                            <p class="mt-1 text-xs text-gray-500">Data must be in valid JSON format</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="p-6 text-center text-gray-500">No settings found in this group</div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Submit Button -->
        <div class="flex justify-center pt-5">
            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Save Settings
            </button>
        </div>
    </form>
</div>

<!-- CSS for Toggle Switch -->
<style>
    .toggle-checkbox:checked {
        @apply: right-0 border-blue-600;
        right: 0;
        border-color: rgb(37, 99, 235);
    }
    .toggle-checkbox:checked + .toggle-label {
        @apply: bg-blue-600;
        background-color: rgb(37, 99, 235);
    }
</style>

<!-- JavaScript for Tabs -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab functionality
        const tabs = document.querySelectorAll('.setting-tab');
        const panels = document.querySelectorAll('.setting-panel');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const target = this.dataset.target;
                
                // Hide all panels
                panels.forEach(panel => {
                    panel.classList.add('hidden');
                });
                
                // Show target panel
                document.getElementById(target).classList.remove('hidden');
                
                // Update active tab
                tabs.forEach(t => {
                    t.classList.remove('border-blue-500', 'text-blue-600');
                    t.classList.add('border-transparent', 'text-gray-500');
                });
                
                this.classList.remove('border-transparent', 'text-gray-500');
                this.classList.add('border-blue-500', 'text-blue-600');
            });
        });
        
        // File input preview
        const fileInputs = document.querySelectorAll('input[type="file"]');
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const fileName = this.files[0]?.name;
                if (fileName) {
                    const label = this.previousElementSibling;
                    const span = label.querySelector('span');
                    span.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        ${fileName}
                    `;
                }
            });
        });
    });
</script>
@endpush
@endsection
