@extends('layouts.admin')

@section('title', 'Frameworks Management')

@section('content')
<div class="p-3 sm:p-6">
    <!-- Header with stats -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-1">Frameworks Management</h2>
            <p class="text-sm text-gray-600">Manage your project and methodology frameworks</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.frameworks.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add Framework
            </a>
        </div>
    </div>
    
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Frameworks</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ number_format($frameworks->total()) }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-5 border-b border-gray-200 bg-gradient-to-r from-green-50 to-green-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Active Frameworks</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $frameworks->filter(function($fw) { return $fw->is_active ?? true; })->count() }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-5 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-purple-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Projects Using Frameworks</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $frameworks->sum('projects_count') }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-5 border-b border-gray-200 bg-gradient-to-r from-yellow-50 to-yellow-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Framework Categories</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ count($categories) }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Search and Filters - Improved UI -->
    <div class="bg-white shadow-sm rounded-lg mb-6">
        <div class="p-4 border-b border-gray-200 bg-gray-50">
            <div class="flex flex-wrap items-center justify-between">
                <h3 class="text-lg font-medium text-gray-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filters and Search
                </h3>
                
                <!-- View Toggles -->
                <div class="flex space-x-2">
                    <button type="button" id="card-view-toggle" class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded-md text-sm font-medium hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Cards
                    </button>
                    <button type="button" id="table-view-toggle" class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Table
                    </button>
                </div>
            </div>
        </div>
        
        <form action="{{ route('admin.frameworks.index') }}" method="GET" class="p-4 sm:p-6 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="col-span-1 sm:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Find Frameworks</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Search by name, description or version">
                    </div>
                </div>

                <!-- Category Filter -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category" id="category" class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ ucfirst($category) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                    <div class="flex space-x-2">
                        <select name="sort" id="sort" class="focus:ring-blue-500 focus:border-blue-500 block w-2/3 sm:text-sm border-gray-300 rounded-md">
                            <option value="name" {{ request('sort', 'name') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Date Created</option>
                            <option value="popularity" {{ request('sort') == 'popularity' ? 'selected' : '' }}>Popularity</option>
                            <option value="category" {{ request('sort') == 'category' ? 'selected' : '' }}>Category</option>
                        </select>
                        <select name="direction" id="direction" class="focus:ring-blue-500 focus:border-blue-500 block w-1/3 sm:text-sm border-gray-300 rounded-md">
                            <option value="asc" {{ request('direction', 'asc') == 'asc' ? 'selected' : '' }}>Asc</option>
                            <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Desc</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap justify-end gap-3 mt-4">
                <a href="{{ route('admin.frameworks.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Reset
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Main Content Area with Card and Table Views -->
    <div id="frameworks-wrapper">
        <!-- Card View -->
        <div id="card-view" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-6 px-2 sm:px-0">
            @if($frameworks->count() > 0)
                @foreach($frameworks as $framework)
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition mobile-framework-card">
                        <!-- Framework Card Header -->
                        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="text-md font-semibold text-gray-800 truncate">{{ $framework->name }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $framework->category == 'agile' ? 'bg-green-100 text-green-800' : ($framework->category == 'traditional' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }}">
                                {{ ucfirst($framework->category) }}
                            </span>
                        </div>
                        
                        <!-- Framework Card Body -->
                        <div class="px-4 py-3">
                            <div class="text-sm text-gray-700 mb-3 min-h-[3rem] max-h-[4rem] overflow-hidden">
                                {{ Str::limit($framework->description ?? 'No description available', 80) }}
                            </div>
                            
                            <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 mb-3">
                                <div>
                                    <span class="text-xs text-gray-500">Version</span>
                                    <div class="font-medium">{{ $framework->version ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">Projects</span>
                                    <div class="font-medium">{{ $framework->projects_count ?? 0 }}</div>
                                </div>
                            </div>
                            
                            <div class="text-xs text-gray-500 mb-3">
                                Created {{ $framework->created_at->format('M d, Y') }}
                            </div>
                        </div>
                        
                        <!-- Framework Card Footer -->
                        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 flex flex-wrap justify-between gap-2">
                            <button type="button" class="text-blue-600 hover:text-blue-800 text-sm font-medium framework-preview mobile-touch-target py-2 px-3 -mx-3 rounded" data-id="{{ $framework->id }}">
                                Preview
                            </button>
                            <div class="space-x-3">
                                <a href="{{ route('admin.frameworks.edit', $framework->id) }}" class="text-gray-600 hover:text-gray-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L11.828 15.1l-2.12.283.283-2.12L19.414 3.737z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.frameworks.destroy', $framework->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this framework?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <div class="col-span-full mt-4">
                    {{ $frameworks->withQueryString()->links() }}
                </div>
            @else
                <div class="col-span-full bg-white rounded-lg shadow p-6 text-center text-gray-500">
                    No frameworks found. <a href="{{ route('admin.frameworks.create') }}" class="text-blue-600 hover:text-blue-900">Create one</a>.
                </div>
            @endif
        </div>

        <!-- Table View -->
        <div id="table-view" class="bg-white shadow-sm rounded-lg overflow-hidden hidden">
            @if($frameworks->count() > 0)
                <div class="overflow-x-auto -mx-4 sm:mx-0 p-4 sm:p-0">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Version</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Projects</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($frameworks as $framework)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $framework->name }}</div>
                                                <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($framework->description ?? '', 50) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $framework->category == 'agile' ? 'bg-green-100 text-green-800' : ($framework->category == 'traditional' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }}">
                                            {{ ucfirst($framework->category) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $framework->version ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $framework->projects_count ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $framework->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-y-2 sm:space-y-0 table-action-buttons">
                                        <button type="button" class="text-blue-600 hover:text-blue-900 mr-3 framework-preview" data-id="{{ $framework->id }}">Preview</button>
                                        <a href="{{ route('admin.frameworks.edit', $framework->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <form action="{{ route('admin.frameworks.destroy', $framework->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this framework?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $frameworks->withQueryString()->links() }}
                </div>
            @else
                <div class="px-6 py-4 text-center text-gray-500">
                    No frameworks found. <a href="{{ route('admin.frameworks.create') }}" class="text-blue-600 hover:text-blue-900">Create one</a>.
                </div>
            @endif
        </div>
    </div>
    
    <!-- Framework Preview Modal -->
    <div id="framework-preview-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-modal="true" role="dialog">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full max-w-[95%] sm:w-full">
                <div class="absolute top-0 right-0 pt-4 pr-4">
                    <button type="button" id="close-preview-modal" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="p-6">
                    <div class="text-center mb-4">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                            <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2" id="modal-framework-name">Framework Details</h3>
                    </div>
                    
                    <div class="mt-4">
                        <div class="flex justify-between border-b border-gray-200 pb-3 mb-3">
                            <span class="text-sm font-medium text-gray-500">Category</span>
                            <span class="text-sm text-gray-900" id="modal-framework-category">-</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-3 mb-3">
                            <span class="text-sm font-medium text-gray-500">Version</span>
                            <span class="text-sm text-gray-900" id="modal-framework-version">-</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-3 mb-3">
                            <span class="text-sm font-medium text-gray-500">Created</span>
                            <span class="text-sm text-gray-900" id="modal-framework-created">-</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-3 mb-3">
                            <span class="text-sm font-medium text-gray-500">Projects Using</span>
                            <span class="text-sm text-gray-900" id="modal-framework-projects">-</span>
                        </div>
                        <div class="mb-4">
                            <span class="text-sm font-medium text-gray-500 block mb-2">Description</span>
                            <p class="text-sm text-gray-900" id="modal-framework-description">-</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex flex-col sm:flex-row justify-between gap-3">
                        <a href="#" id="modal-framework-edit" class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mobile-touch-target">
                            Edit Framework
                        </a>
                        <button type="button" id="close-preview-button" class="inline-flex justify-center w-full sm:w-auto px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mobile-touch-target">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Mejoras generales para toda la página */
        .mobile-touch-target {
            min-height: 44px; /* Tamaño mínimo recomendado para objetivos táctiles */
        }
        
        /* Estilos específicos para móviles */
        @media (max-width: 640px) {
            .table-action-buttons {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            .table-action-buttons button,
            .table-action-buttons a {
                margin-right: 0 !important;
                padding: 0.35rem 0;
                display: inline-block;
                width: 100%;
                text-align: left;
            }
            .mobile-framework-card {
                box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
                transition: all 0.3s cubic-bezier(.25,.8,.25,1);
            }
            .mobile-framework-card:active {
                box-shadow: 0 5px 10px rgba(0,0,0,0.19), 0 3px 3px rgba(0,0,0,0.23);
            }
        }
    </style>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // View Toggle Functionality
            const cardViewToggle = document.getElementById('card-view-toggle');
            const tableViewToggle = document.getElementById('table-view-toggle');
            const cardView = document.getElementById('card-view');
            const tableView = document.getElementById('table-view');
            
            // Save view preference to localStorage
            const saveViewPreference = (view) => {
                localStorage.setItem('frameworksViewPreference', view);
            };
            
            // Apply view preference
            const applyViewPreference = () => {
                const preference = localStorage.getItem('frameworksViewPreference') || 'card';
                if (preference === 'card') {
                    showCardView();
                } else {
                    showTableView();
                }
            };
            
            const showCardView = () => {
                cardView.classList.remove('hidden');
                tableView.classList.add('hidden');
                cardViewToggle.classList.remove('bg-gray-100', 'text-gray-700');
                cardViewToggle.classList.add('bg-blue-100', 'text-blue-700');
                tableViewToggle.classList.remove('bg-blue-100', 'text-blue-700');
                tableViewToggle.classList.add('bg-gray-100', 'text-gray-700');
                saveViewPreference('card');
            };
            
            const showTableView = () => {
                cardView.classList.add('hidden');
                tableView.classList.remove('hidden');
                tableViewToggle.classList.remove('bg-gray-100', 'text-gray-700');
                tableViewToggle.classList.add('bg-blue-100', 'text-blue-700');
                cardViewToggle.classList.remove('bg-blue-100', 'text-blue-700');
                cardViewToggle.classList.add('bg-gray-100', 'text-gray-700');
                saveViewPreference('table');
            };
            
            cardViewToggle.addEventListener('click', showCardView);
            tableViewToggle.addEventListener('click', showTableView);
            
            // Apply saved preference on load
            applyViewPreference();
            
            // Preview Modal Functionality
            const modal = document.getElementById('framework-preview-modal');
            const closeModalBtn = document.getElementById('close-preview-modal');
            const closePreviewBtn = document.getElementById('close-preview-button');
            const previewButtons = document.querySelectorAll('.framework-preview');
            
            function openPreviewModal(frameworkId) {
                // Get framework data via API
                fetch(`{{ url('/admin/frameworks') }}/${frameworkId}/preview`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate modal with framework data
                        document.getElementById('modal-framework-name').textContent = data.name || 'Framework';
                        document.getElementById('modal-framework-category').textContent = data.category ? data.category.charAt(0).toUpperCase() + data.category.slice(1) : '-';
                        document.getElementById('modal-framework-version').textContent = data.version || 'v1.0';
                        document.getElementById('modal-framework-created').textContent = data.created_at ? new Date(data.created_at).toLocaleDateString('en-US', {year: 'numeric', month: 'short', day: 'numeric'}) : '-';
                        document.getElementById('modal-framework-projects').textContent = data.projects_count ? data.projects_count : '0';
                        document.getElementById('modal-framework-description').textContent = data.description || 'No description available';
                        
                        // Set edit link
                        document.getElementById('modal-framework-edit').href = `/admin/frameworks/${frameworkId}/edit`;
                        
                        // Show modal
                        modal.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error fetching framework data:', error);
                        alert('Failed to load framework details. Please try again.');
                    });
            }
            
            function closeModal() {
                modal.classList.add('hidden');
            }
            
            // Add event listeners for preview buttons
            previewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const frameworkId = this.getAttribute('data-id');
                    openPreviewModal(frameworkId);
                });
            });
            
            // Close modal with buttons
            closeModalBtn.addEventListener('click', closeModal);
            closePreviewBtn.addEventListener('click', closeModal);
            
            // Close modal with escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
            
            // Close modal when clicking outside
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeModal();
                }
            });
        });
    </script>
    @endpush
@endsection
