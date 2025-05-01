@extends('layouts.dashboard')

@section('content')
<div class="bg-white min-h-screen">
    <!-- Header -->
    <div class="flex items-center justify-between p-4">
        <div class="flex items-center">
            <svg class="h-6 w-6 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <div>
                <h1 class="text-lg font-medium text-blue-600">Settings</h1>
                <p class="text-blue-400 text-xs">Manage your account and application preferences</p>
            </div>
        </div>
        <div>
            <button class="h-8 w-8 rounded-full text-gray-400 flex items-center justify-center hover:bg-gray-100">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Tabs navigation -->
    <div class="px-4 border-b border-gray-200">
        <div class="flex overflow-x-auto space-x-6 text-sm">
            <a href="{{ route('user.settings', ['tab' => 'profile']) }}" class="text-gray-400 py-2 hover:text-blue-500">Profile</a>
            <a href="{{ route('user.settings', ['tab' => 'security']) }}" class="text-gray-400 py-2 hover:text-blue-500">Account Security</a>
            <a href="{{ route('user.settings', ['tab' => 'team']) }}" class="text-gray-400 py-2 hover:text-blue-500">Add Member</a>
            <a href="{{ route('user.notification-preferences') }}" class="text-gray-400 py-2 hover:text-blue-500">Notifications</a>
            <a href="{{ route('user.settings', ['tab' => 'branding']) }}" class="text-blue-500 py-2 border-b-2 border-blue-500">Branding</a>
            <a href="{{ route('user.settings', ['tab' => 'advanced']) }}" class="text-gray-400 py-2 hover:text-blue-500">Advanced</a>
        </div>
    </div>
    
    <!-- Main content -->
    <div class="p-4">
        <div class="bg-white">
            <form action="{{ route('user.settings.branding') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <h2 class="text-lg font-medium text-gray-700">Report & Document Branding</h2>
                    <p class="text-gray-500 text-xs">These settings will affect how your exported reports and documents appear.</p>
                </div>
                
                <!-- Company/Organization Name -->
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-1">Company/Organization Name</h3>
                    <input type="text" name="company_name" id="company_name" class="w-full p-2 border border-gray-300 rounded text-sm">
                    <p class="text-gray-500 text-xs mt-1">Use this account in the header of your reports.</p>
                </div>
                
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Primary Color -->
                    <div class="w-full md:w-1/2 mb-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-1">Primary Color</h3>
                        <div class="flex items-center space-x-2">
                            <div class="w-10 h-6 bg-blue-500 rounded"></div>
                            <span class="text-gray-500 text-xs">#2B82FC</span>
                        </div>
                        <p class="text-gray-500 text-xs mt-1">Main color used in reports and documents.</p>
                    </div>
                    
                    <!-- Secondary Color -->
                    <div class="w-full md:w-1/2 mb-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-1">Secondary Color</h3>
                        <div class="flex items-center space-x-2">
                            <div class="w-10 h-6 bg-blue-800 rounded"></div>
                            <span class="text-gray-500 text-xs">#1B52BC</span>
                        </div>
                        <p class="text-gray-500 text-xs mt-1">Accent color used in reports and documents.</p>
                    </div>
                </div>
                
                <!-- Logo Type -->
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-1/2 mb-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-1">Logo type</h3>
                        <div class="relative">
                            <select name="logo_type" class="w-full p-2 border border-gray-300 rounded text-sm appearance-none pr-8">
                                <option value="no_logo">No Logo</option>
                                <option value="text">Text Logo</option>
                                <option value="image">Image Logo</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Preview Section -->
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Preview</h3>
                    <div class="border border-gray-200 p-4 rounded">
                        <div class="mb-2 text-sm text-gray-600">Your Company Name</div>
                        <div class="mb-6 p-2 bg-gray-50 border-l-4 border-blue-500">
                            <h4 class="text-blue-600 font-medium">Sample Report Title</h4>
                            <p class="text-xs text-gray-500 mt-1">This is a preview of how your reports will look with the selected branding settings.</p>
                        </div>
                        <div class="flex justify-end">
                            <div class="bg-blue-500 text-white text-xs px-3 py-1 rounded">
                                Sample Button
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="mt-6">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600 focus:outline-none">
                        Save Branding Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
