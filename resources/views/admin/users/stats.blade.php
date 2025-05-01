@extends('layouts.admin')

@section('title', $user->name . ' - Detailed Statistics')

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
        <span class="text-gray-700">Detailed Stats</span>
    </div>

    <!-- Header -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
        <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-indigo-100 border-b flex justify-between items-center">
            <div class="flex items-center">
                <div class="h-10 w-10 bg-indigo-100 rounded-lg border border-indigo-200 flex items-center justify-center mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h1 class="text-xl font-semibold text-gray-800">{{ $user->name }}'s Statistics</h1>
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
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Account Stats -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Account Statistics</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Account Age</span>
                        </div>
                        <div class="text-sm font-semibold text-right">
                            <span class="text-gray-800">{{ $stats['account_age_days'] }} days</span>
                            <div class="text-xs text-gray-500">({{ $stats['account_age_months'] }} months)</div>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Last Login</span>
                        </div>
                        <div class="text-sm font-semibold text-right">
                            @if($stats['last_login'])
                                <span class="text-gray-800">{{ $stats['last_login']->diffForHumans() }}</span>
                                <div class="text-xs text-gray-500">{{ $stats['last_login']->format('M d, Y g:i A') }}</div>
                            @else
                                <span class="text-gray-500">No data available</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Total Logins</span>
                        </div>
                        <div class="text-sm font-semibold">
                            <span class="text-gray-800">{{ $stats['activity_logs'] ?? 0 }}</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center py-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Last Activity</span>
                        </div>
                        <div class="text-sm font-semibold text-right">
                            @if($stats['last_activity_date'])
                                <span class="text-gray-800">{{ \Carbon\Carbon::parse($stats['last_activity_date'])->diffForHumans() }}</span>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($stats['last_activity_date'])->format('M d, Y g:i A') }}</div>
                            @else
                                <span class="text-gray-500">No data available</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Stats -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-purple-100 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Project Statistics</h2>
            </div>
            <div class="p-6">
                <div class="mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Total Projects</span>
                        <span class="text-sm font-bold text-purple-700">{{ $stats['total_projects'] }}</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-purple-400 to-purple-600 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                            <span class="text-sm font-medium text-gray-700">Completed</span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-800">{{ $stats['completed_projects'] }}</span>
                            <span class="text-xs text-gray-500 ml-1">({{ number_format($stats['total_projects'] > 0 ? ($stats['completed_projects'] / $stats['total_projects'] * 100) : 0, 0) }}%)</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                            <span class="text-sm font-medium text-gray-700">In Progress</span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-800">{{ $stats['in_progress_projects'] }}</span>
                            <span class="text-xs text-gray-500 ml-1">({{ number_format($stats['total_projects'] > 0 ? ($stats['in_progress_projects'] / $stats['total_projects'] * 100) : 0, 0) }}%)</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-amber-500 mr-2"></div>
                            <span class="text-sm font-medium text-gray-700">Pending</span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-800">{{ $stats['pending_projects'] }}</span>
                            <span class="text-xs text-gray-500 ml-1">({{ number_format($stats['total_projects'] > 0 ? ($stats['pending_projects'] / $stats['total_projects'] * 100) : 0, 0) }}%)</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center py-3">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-indigo-500 mr-2"></div>
                            <span class="text-sm font-medium text-gray-700">Avg. Duration</span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-800">{{ $stats['avg_project_duration'] ?? 0 }} days</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Idea Stats -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-pink-50 to-pink-100 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Idea Statistics</h2>
            </div>
            <div class="p-6">
                <div class="mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Total Ideas</span>
                        <span class="text-sm font-bold text-pink-700">{{ $stats['total_ideas'] }}</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-pink-400 to-pink-600 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                            <span class="text-sm font-medium text-gray-700">Implemented</span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-800">{{ $stats['implemented_ideas'] }}</span>
                            <span class="text-xs text-gray-500 ml-1">({{ number_format($stats['total_ideas'] > 0 ? ($stats['implemented_ideas'] / $stats['total_ideas'] * 100) : 0, 0) }}%)</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                            <span class="text-sm font-medium text-gray-700">Evaluating</span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-800">{{ $stats['evaluating_ideas'] }}</span>
                            <span class="text-xs text-gray-500 ml-1">({{ number_format($stats['total_ideas'] > 0 ? ($stats['evaluating_ideas'] / $stats['total_ideas'] * 100) : 0, 0) }}%)</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-gray-500 mr-2"></div>
                            <span class="text-sm font-medium text-gray-700">Other</span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-800">{{ $stats['total_ideas'] - $stats['implemented_ideas'] - $stats['evaluating_ideas'] }}</span>
                            <span class="text-xs text-gray-500 ml-1">({{ number_format($stats['total_ideas'] > 0 ? (($stats['total_ideas'] - $stats['implemented_ideas'] - $stats['evaluating_ideas']) / $stats['total_ideas'] * 100) : 0, 0) }}%)</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center py-3">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-indigo-500 mr-2"></div>
                            <span class="text-sm font-medium text-gray-700">Implementation Rate</span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-800">{{ number_format($stats['idea_implementation_rate'] ?? 0, 0) }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Activity Charts -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-amber-50 to-amber-100 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Activity Over Time</h2>
            </div>
            <div class="p-6 h-80">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
        
        <!-- Contribution Charts -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-emerald-50 to-emerald-100 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Contributions by Month</h2>
            </div>
            <div class="p-6 h-80">
                <canvas id="contributionsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Activity Types -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
        <div class="px-6 py-4 bg-gradient-to-r from-sky-50 to-sky-100 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Activity Types</h2>
        </div>
        <div class="p-6">
            @if(isset($stats['activity_by_type']) && count($stats['activity_by_type']) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($stats['activity_by_type'] as $type => $count)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">{{ ucfirst($type) }}</span>
                                <span class="text-sm font-semibold text-gray-800">{{ $count }}</span>
                            </div>
                            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-sky-400 to-sky-600 rounded-full" style="width: {{ ($count / ($stats['activity_logs'] ?: 1)) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10">
                    <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-800 mb-1">No activity type data available</h3>
                    <p class="text-gray-500 max-w-md mx-auto">We couldn't find any categorized activity data for this user.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Activity Chart
        const activityCtx = document.getElementById('activityChart').getContext('2d');
        new Chart(activityCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($timeSeriesData['labels'] ?? []) !!},
                datasets: [{
                    label: 'Activity',
                    data: {!! json_encode($timeSeriesData['activity'] ?? []) !!},
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    borderColor: 'rgba(245, 158, 11, 0.8)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });

        // Contributions Chart
        const contribCtx = document.getElementById('contributionsChart').getContext('2d');
        new Chart(contribCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($timeSeriesData['labels'] ?? []) !!},
                datasets: [
                    {
                        label: 'Projects',
                        data: {!! json_encode($timeSeriesData['projects'] ?? []) !!},
                        backgroundColor: 'rgba(124, 58, 237, 0.7)',
                        borderWidth: 0
                    },
                    {
                        label: 'Ideas',
                        data: {!! json_encode($timeSeriesData['ideas'] ?? []) !!},
                        backgroundColor: 'rgba(236, 72, 153, 0.7)',
                        borderWidth: 0
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        stacked: false,
                        ticks: {
                            precision: 0
                        }
                    },
                    x: {
                        stacked: false
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    });
</script>
@endsection
