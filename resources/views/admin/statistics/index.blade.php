@extends('layouts.admin')

@section('title', 'Statistics & Analytics')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Platform Statistics</h2>
            <p class="mt-1 text-sm text-gray-600">Comprehensive analytics dashboard showing platform usage and trends.</p>
        </div>
        
        <!-- Period Selector -->
        <div class="inline-flex shadow-sm rounded-md">
            <form action="{{ route('admin.statistics.index') }}" method="GET" class="flex">
                <select name="period" id="period" onchange="this.form.submit()" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md">
                    <option value="7days" {{ $period == '7days' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="30days" {{ $period == '30days' ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="90days" {{ $period == '90days' ? 'selected' : '' }}>Last 90 Days</option>
                    <option value="year" {{ $period == 'year' ? 'selected' : '' }}>This Year</option>
                    <option value="all" {{ $period == 'all' ? 'selected' : '' }}>All Time</option>
                </select>
            </form>
        </div>
    </div>
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <!-- User Statistics Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">User Statistics</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Users</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($userStats['total']) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">New Users</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($userStats['new']) }}</p>
                        <p class="text-xs text-green-600">+{{ round(($userStats['new'] / max($userStats['total'] - $userStats['new'], 1)) * 100, 1) }}%</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Active Users</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($userStats['active']) }}</p>
                        <p class="text-xs text-gray-500">{{ round(($userStats['active'] / max($userStats['total'], 1)) * 100, 1) }}% of total</p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <canvas id="userTrendChart" height="200"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Idea Statistics Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Idea Statistics</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Ideas</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($ideaStats['total']) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">New Ideas</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($ideaStats['new']) }}</p>
                        <p class="text-xs text-green-600">+{{ round(($ideaStats['new'] / max($ideaStats['total'] - $ideaStats['new'], 1)) * 100, 1) }}%</p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <canvas id="ideaStatusChart" height="200"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Project Statistics Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-sky-50">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Project Statistics</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Projects</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($projectStats['total']) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">New Projects</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($projectStats['new']) }}</p>
                        <p class="text-xs text-green-600">+{{ round(($projectStats['new'] / max($projectStats['total'] - $projectStats['new'], 1)) * 100, 1) }}%</p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <canvas id="projectStatusChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Framework Usage Chart -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Framework Usage</h3>
            </div>
            <div class="p-6">
                <canvas id="frameworkUsageChart" height="300"></canvas>
            </div>
        </div>
        
        <!-- Top Tags -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Top Tags</h3>
            </div>
            <div class="p-6">
                <div class="flex flex-wrap gap-2">
                    @foreach($topTags as $tag => $count)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                            {{ $tag }}
                            <span class="ml-2 text-indigo-600">{{ $count }}</span>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <!-- Activity Trend Chart -->
    <div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Activity Trends</h3>
        </div>
        <div class="p-6">
            <canvas id="activityTrendChart" height="300"></canvas>
        </div>
    </div>
    
    <!-- Most Active Users -->
    <div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Most Active Users</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ideas</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Projects</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Items</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($activeUsers as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $user->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->idea_count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->project_count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $user->total_items }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart colors
        const colors = {
            blue: '#3B82F6',
            indigo: '#6366F1',
            purple: '#8B5CF6',
            pink: '#EC4899',
            red: '#EF4444',
            orange: '#F97316',
            amber: '#F59E0B',
            yellow: '#EAB308',
            lime: '#84CC16',
            green: '#22C55E',
            teal: '#14B8A6',
            cyan: '#06B6D4',
            sky: '#0EA5E9',
            blue_light: 'rgba(59, 130, 246, 0.1)',
            indigo_light: 'rgba(99, 102, 241, 0.1)',
            purple_light: 'rgba(139, 92, 246, 0.1)',
        };

        // User Trend Chart
        new Chart(document.getElementById('userTrendChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: Object.keys({{ json_encode($userStats['trend']) }}),
                datasets: [{
                    label: 'New Users',
                    data: Object.values({{ json_encode($userStats['trend']) }}),
                    borderColor: colors.blue,
                    backgroundColor: colors.blue_light,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Idea Status Chart
        new Chart(document.getElementById('ideaStatusChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: Object.keys({{ json_encode($ideaStats['by_status']) }}),
                datasets: [{
                    data: Object.values({{ json_encode($ideaStats['by_status']) }}),
                    backgroundColor: [
                        colors.purple,
                        colors.pink,
                        colors.indigo,
                        colors.sky,
                        colors.teal,
                        colors.amber
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });

        // Project Status Chart
        new Chart(document.getElementById('projectStatusChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: Object.keys({{ json_encode($projectStats['by_status']) }}),
                datasets: [{
                    data: Object.values({{ json_encode($projectStats['by_status']) }}),
                    backgroundColor: [
                        colors.indigo,
                        colors.blue,
                        colors.cyan,
                        colors.sky,
                        colors.teal,
                        colors.green
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });

        // Framework Usage Chart
        new Chart(document.getElementById('frameworkUsageChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: Object.keys({{ json_encode($frameworkUsage) }}),
                datasets: [{
                    label: 'Projects',
                    data: Object.values({{ json_encode($frameworkUsage) }}),
                    backgroundColor: colors.indigo,
                    borderColor: colors.indigo,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Activity Trend Chart
        new Chart(document.getElementById('activityTrendChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: Object.keys({{ json_encode($userStats['trend']) }}),
                datasets: [
                    {
                        label: 'Users',
                        data: Object.values({{ json_encode($userStats['trend']) }}),
                        borderColor: colors.blue,
                        backgroundColor: colors.blue_light,
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Projects',
                        data: Object.values({{ json_encode($projectStats['trend']) }}),
                        borderColor: colors.indigo,
                        backgroundColor: colors.indigo_light,
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Ideas',
                        data: Object.values({{ json_encode($ideaStats['trend']) }}),
                        borderColor: colors.purple,
                        backgroundColor: colors.purple_light,
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
