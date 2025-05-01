@extends('layouts.admin')

@section('title', 'User Engagement Analytics')

@section('content')
<div class="p-6 space-y-8 bg-white">
    <!-- Modern Analytics Header -->
    <div class="border-b border-gray-200 bg-white/90 backdrop-blur-sm" style="background: linear-gradient(to right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
        <div class="flex items-center justify-between px-4 py-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    User Engagement Analytics
                </h1>
                <p class="text-gray-600 mt-1">Real-time user activity tracking and engagement metrics</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <select id="time-range" class="bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                        <option value="24">Last 24 Hours</option>
                        <option value="48">Last 48 Hours</option>
                        <option value="72">Last 72 Hours</option>
                        <option value="168">Last 7 Days</option>
                        <option value="720">Last 30 Days</option>
                    </select>
                </div>
                <button id="refresh-analytics" class="flex items-center space-x-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 px-4 py-2 rounded-lg transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Refresh Data</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Real-time Metrics Overview -->
    <div class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Active Users Card -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
                <div class="px-6 py-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Active Users</h3>
                        <div class="p-2 rounded-md bg-blue-50 relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <!-- Live indicator -->
                            <span class="flex h-2 w-2 absolute top-0 right-0">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between">
                        <div>
                            <h4 id="active-users-count" class="text-3xl font-bold text-gray-800">{{ $metrics['active_users'] }}</h4>
                            <p class="text-xs text-gray-500 mt-1">of {{ $metrics['total_users'] }} total users</p>
                        </div>
                        <div class="text-right">
                            <span id="active-users-percentage" class="text-sm font-semibold {{ $metrics['active_users_percentage'] > 20 ? 'text-green-600' : 'text-yellow-600' }}">{{ $metrics['active_users_percentage'] }}%</span>
                            <p class="text-xs text-gray-500 mt-1">engagement rate</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>Engagement</span>
                            <span id="active-users-percentage-text">{{ $metrics['active_users_percentage'] > 20 ? 'Good' : ($metrics['active_users_percentage'] > 10 ? 'Average' : 'Needs improvement') }}</span>
                        </div>
                        <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div id="active-users-bar" class="h-full bg-blue-500 rounded-full" style="width: {{ min($metrics['active_users_percentage'], 100) }}%"></div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-4 last-updated">Last updated: {{ $metrics['timestamp'] }}</p>
                </div>
            </div>
            
            <!-- Events Per User Card -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
                <div class="px-6 py-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Events Per User</h3>
                        <div class="p-2 rounded-md bg-indigo-50 relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <!-- Live indicator -->
                            <span class="flex h-2 w-2 absolute top-0 right-0">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between">
                        <div>
                            <h4 id="events-per-user-count" class="text-3xl font-bold text-gray-800">{{ $metrics['events_per_user'] }}</h4>
                            <p class="text-xs text-gray-500 mt-1">events per active user</p>
                        </div>
                        <div class="text-right">
                            <span id="total-events-count" class="text-sm font-semibold text-indigo-600">{{ $metrics['total_events'] }}</span>
                            <p class="text-xs text-gray-500 mt-1">total events</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>User Activity</span>
                            <span id="events-per-user-level">{{ $metrics['events_per_user'] > 5 ? 'High' : ($metrics['events_per_user'] > 2 ? 'Moderate' : 'Low') }}</span>
                        </div>
                        <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div id="events-per-user-bar" class="h-full bg-indigo-500 rounded-full" style="width: {{ min($metrics['events_per_user'] * 10, 100) }}%"></div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-4 last-updated">Last updated: {{ $metrics['timestamp'] }}</p>
                </div>
            </div>
            
            <!-- Top Event Type Card -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
                <div class="px-6 py-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Top Event Type</h3>
                        <div class="p-2 rounded-md bg-purple-50 relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <!-- Live indicator -->
                            <span class="flex h-2 w-2 absolute top-0 right-0">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between">
                        <div>
                            @php
                                // Get the top event type
                                $topEventType = array_key_first($metrics['events_by_type'] ?? []) ?: 'N/A';
                                $topEventCount = $metrics['events_by_type'][$topEventType] ?? 0;
                                $topEventPercentage = $metrics['total_events'] > 0 ? round(($topEventCount / $metrics['total_events']) * 100) : 0;
                            @endphp
                            <h4 id="top-event-type" class="text-2xl font-bold text-gray-800 capitalize">{{ str_replace('_', ' ', $topEventType) }}</h4>
                            <p class="text-xs text-gray-500 mt-1">most common action</p>
                        </div>
                        <div class="text-right">
                            <span id="top-event-percentage" class="text-sm font-semibold text-purple-600">{{ $topEventPercentage }}%</span>
                            <p class="text-xs text-gray-500 mt-1">of total events</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>Distribution</span>
                            <span id="top-event-count">{{ $topEventCount }} events</span>
                        </div>
                        <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div id="top-event-bar" class="h-full bg-purple-500 rounded-full" style="width: {{ $topEventPercentage }}%"></div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-4 last-updated">Last updated: {{ $metrics['timestamp'] }}</p>
                </div>
            </div>
            
            <!-- Top Page Card -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
                <div class="px-6 py-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Most Visited Page</h3>
                        <div class="p-2 rounded-md bg-teal-50 relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <!-- Live indicator -->
                            <span class="flex h-2 w-2 absolute top-0 right-0">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between">
                        <div>
                            @php
                                // Get the top visited page
                                $topPage = array_key_first($metrics['events_by_page'] ?? []) ?: 'N/A';
                                $topPageCount = $metrics['events_by_page'][$topPage] ?? 0;
                                $topPagePercentage = $metrics['total_events'] > 0 ? round(($topPageCount / $metrics['total_events']) * 100) : 0;
                                // Format the page path for better display
                                $displayPage = $topPage === 'N/A' ? 'N/A' : (str_contains($topPage, '/') ? basename($topPage) : $topPage);
                            @endphp
                            <h4 id="top-page" class="text-2xl font-bold text-gray-800">{{ $displayPage }}</h4>
                            <p class="text-xs text-gray-500 mt-1">most visited page</p>
                        </div>
                        <div class="text-right">
                            <span id="top-page-percentage" class="text-sm font-semibold text-teal-600">{{ $topPagePercentage }}%</span>
                            <p class="text-xs text-gray-500 mt-1">of total traffic</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>Traffic Share</span>
                            <span id="top-page-count">{{ $topPageCount }} views</span>
                        </div>
                        <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div id="top-page-bar" class="h-full bg-teal-500 rounded-full" style="width: {{ $topPagePercentage }}%"></div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-4 last-updated">Last updated: {{ $metrics['timestamp'] }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Section -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-6">Detailed Analytics</h2>
        
        <!-- Hourly Activity Chart -->
        <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md p-6 mb-8 border border-gray-100" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Hourly User Activity</h3>
                <div class="text-sm text-gray-500 flex items-center">
                    <span class="flex h-2 w-2 mr-2">
                        <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    Live Data
                </div>
            </div>
            <div class="h-80">
                <canvas id="hourlyActivityChart"></canvas>
            </div>
        </div>
        
        <!-- Event Distribution & Device Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Event Type Distribution Chart -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md p-6 border border-gray-100" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Event Type Distribution</h3>
                </div>
                <div class="h-64">
                    <canvas id="eventTypeChart"></canvas>
                </div>
            </div>
            
            <!-- Device & Browser Chart -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md p-6 border border-gray-100" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Device & Browser Distribution</h3>
                </div>
                <div class="h-64">
                    <canvas id="deviceChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Recent User Activity -->
        <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md p-6 border border-gray-100" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Recent User Activity</h3>
                <div class="text-sm text-gray-500 flex items-center">
                    <span class="flex h-2 w-2 mr-2">
                        <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    Live Updates
                </div>
            </div>
            <div class="overflow-hidden overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Page</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        </tr>
                    </thead>
                    <tbody id="recent-activity-table" class="bg-white divide-y divide-gray-200">
                        @forelse($recentEvents ?? [] as $event)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-indigo-800">{{ substr($event->user->name ?? 'User', 0, 1) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $event->user->name ?? 'Unknown User' }}</div>
                                            <div class="text-xs text-gray-500">ID: {{ $event->user_id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 capitalize">{{ str_replace('_', ' ', $event->event_name) }}</div>
                                    <div class="text-xs text-gray-500">{{ $event->event_type }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $event->page }}</div>
                                    <div class="text-xs text-gray-500">{{ $event->section }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $event->event_time->diffForHumans() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    No recent activity available
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Definir la URL para las métricas de analíticas
    const ANALYTICS_METRICS_URL = "{{ route('analytics.metrics') }}";
</script>
<script src="{{ asset('js/analytics-dashboard.js') }}"></script>
@endpush

@endsection
