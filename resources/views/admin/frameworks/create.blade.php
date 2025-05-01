@extends('layouts.admin')

@section('title', 'Add New Framework')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Add New Framework</h2>
        <a href="{{ route('admin.frameworks.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring focus:ring-gray-300 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Frameworks
        </a>
    </div>
    
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <form action="{{ route('admin.frameworks.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Framework Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Framework Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="e.g. React, Laravel, Vue.js">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Version -->
                <div>
                    <label for="version" class="block text-sm font-medium text-gray-700 mb-1">Version</label>
                    <input type="text" name="version" id="version" value="{{ old('version') }}" class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="e.g. 5.0, 18.2, Latest">
                    @error('version')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                <div class="flex space-x-3">
                    <select name="category" id="category" class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ ucfirst($category) }}</option>
                        @endforeach
                        <option value="frontend" {{ old('category') == 'frontend' ? 'selected' : '' }}>Frontend</option>
                        <option value="backend" {{ old('category') == 'backend' ? 'selected' : '' }}>Backend</option>
                        <option value="fullstack" {{ old('category') == 'fullstack' ? 'selected' : '' }}>Full Stack</option>
                        <option value="mobile" {{ old('category') == 'mobile' ? 'selected' : '' }}>Mobile</option>
                        <option value="desktop" {{ old('category') == 'desktop' ? 'selected' : '' }}>Desktop</option>
                        <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <input type="text" name="new_category" id="new_category" class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-1/3 sm:text-sm border-gray-300 rounded-md" placeholder="Or enter new category">
                </div>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="4" required class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Provide a detailed description of the framework, its use cases, and main features">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Website URL -->
                <div>
                    <label for="website_url" class="block text-sm font-medium text-gray-700 mb-1">Official Website</label>
                    <input type="url" name="website_url" id="website_url" value="{{ old('website_url') }}" class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="https://example.com">
                    @error('website_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Documentation URL -->
                <div>
                    <label for="docs_url" class="block text-sm font-medium text-gray-700 mb-1">Documentation URL</label>
                    <input type="url" name="docs_url" id="docs_url" value="{{ old('docs_url') }}" class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="https://docs.example.com">
                    @error('docs_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Framework Icon -->
            <div>
                <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Framework Icon</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="icon" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                <span>Upload an icon</span>
                                <input id="icon" name="icon" type="file" class="sr-only" accept="image/*">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, SVG up to 2MB</p>
                    </div>
                </div>
                @error('icon')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Additional Information -->
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Framework Information</h3>
                        <div class="mt-2 text-sm text-blue-700 space-y-1">
                            <p>• Adding frameworks helps users select the appropriate technology for their projects</p>
                            <p>• Include accurate descriptions and links to official resources when available</p>
                            <p>• Framework icons help with visual recognition in the project creation interface</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Create Framework
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
