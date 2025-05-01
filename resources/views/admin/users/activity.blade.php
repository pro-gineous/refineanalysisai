@extends('layouts.admin')

@section('title', $user->name . ' - Activity Log')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
        </a>
        <span class="text-gray-500 mx-2">/</span>
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800">Users</a>
        <span class="text-gray-500 mx-2">/</span>
        <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600 hover:text-blue-800">{{ $user->name }}</a>
        <span class="text-gray-500 mx-2">/</span>
        <span class="text-gray-700">Activity Log</span>
    </div>

    <!-- Header -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
        <div class="px-6 py-4 bg-gradient-to-r from-amber-50 to-amber-100 border-b flex justify-between items-center">
            <div class="flex items-center">
                <div class="h-10 w-10 bg-amber-100 rounded-lg border border-amber-200 flex items-center justify-center mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h1 class="text-xl font-semibold text-gray-800">{{ $user->name }}'s Activity Log</h1>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.users.show', $user->id) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Profile
                </a>
            </div>
        </div>
        <div class="p-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 px-4 py-5">
                    <div class="flex items-center">
                        <div class="rounded-full p-2 bg-blue-100 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 uppercase">Total Activities</div>
                            <div class="text-xl font-semibold">{{ $stats['total_activities'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 px-4 py-5">
                    <div class="flex items-center">
                        <div class="rounded-full p-2 bg-purple-100 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 uppercase">Projects</div>
                            <div class="text-xl font-semibold">{{ $stats['projects'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 px-4 py-5">
                    <div class="flex items-center">
                        <div class="rounded-full p-2 bg-pink-100 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 uppercase">Ideas</div>
                            <div class="text-xl font-semibold">{{ $stats['ideas'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 px-4 py-5">
                    <div class="flex items-center">
                        <div class="rounded-full p-2 bg-green-100 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 uppercase">Member Since</div>
                            <div class="text-lg font-semibold">{{ $user->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Log -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Activity Timeline</h2>
        </div>
        
        <div class="p-6">
            @if($hasActivityData && $activities->count() > 0)
                <div class="flex flex-col space-y-6">
                    @foreach($activities as $activity)
                        <div class="flex items-start">
                            <!-- Timeline dot -->
                            <div class="mr-4 flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gradient-to-br from-blue-400 to-indigo-500 shadow-md">
                                    @if(isset($activity->description) && stripos($activity->description, 'create') !== false)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    @elseif(isset($activity->description) && stripos($activity->description, 'update') !== false)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    @elseif(isset($activity->description) && stripos($activity->description, 'delete') !== false)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    @elseif(isset($activity->description) && stripos($activity->description, 'login') !== false)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            <!-- Activity content -->
                            <div class="flex-1 bg-gray-50 rounded-lg shadow-sm border border-gray-100 p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">
                                            {{ isset($activity->description) ? ucfirst($activity->description) : (isset($activity->event_type) ? ucfirst($activity->event_type) : 'User activity') }}
                                        </p>
                                        @if(isset($activity->properties) && !empty($activity->properties))
                                            <div class="mt-1 text-xs text-gray-500">
                                                @if(is_string($activity->properties))
                                                    {{ json_decode($activity->properties) ? json_encode(json_decode($activity->properties), JSON_PRETTY_PRINT) : $activity->properties }}
                                                @else
                                                    {{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}
                                                @endif
                                            </div>
                                        @endif
                                        @if(isset($activity->subject_type) && !empty($activity->subject_type))
                                            <p class="mt-1 text-xs text-blue-600">
                                                {{ str_replace('App\\Models\\', '', $activity->subject_type) }} #{{ $activity->subject_id ?? 'N/A' }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ isset($activity->created_at) ? \Carbon\Carbon::parse($activity->created_at)->format('M d, Y g:i A') : 'Unknown date' }}
                                        <div class="text-xs mt-1">
                                            {{ isset($activity->created_at) ? \Carbon\Carbon::parse($activity->created_at)->diffForHumans() : '' }}
                                        </div>
                                    </div>
                                </div>
                                
                                @if(isset($activity->changes) && !empty($activity->changes))
                                    <div class="mt-2 p-2 bg-gray-100 rounded text-xs">
                                        <div class="font-medium text-gray-700 mb-1">Changes:</div>
                                        <div class="space-y-1">
                                            @foreach(json_decode($activity->changes, true) as $field => $change)
                                                <div>
                                                    <span class="font-medium">{{ $field }}:</span>
                                                    <span class="text-red-600 line-through">{{ is_array($change) && isset($change['old']) ? $change['old'] : 'null' }}</span>
                                                    <span class="mx-1">→</span>
                                                    <span class="text-green-600">{{ is_array($change) && isset($change['new']) ? $change['new'] : 'null' }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-6">
                    {{ $activities->links() }}
                </div>
            @else
                <div class="text-center py-10">
                    <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-800 mb-1">No activity logs found</h3>
                    <p class="text-gray-500 max-w-md mx-auto">This user doesn't have any recorded activity yet, or the activity tracking tables aren't available in the database.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
