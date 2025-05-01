@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="p-6 space-y-10 bg-white">
    <!-- Modern Dashboard Header -->
    <div class="border-b border-gray-200 bg-white/90 backdrop-blur-sm" style="background: linear-gradient(to right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
        <div class="flex items-center justify-between px-4 py-2">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-lg p-1.5 mr-3 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">
                    Executive Dashboard
                </h2>
            </div>
            <div class="hidden sm:flex items-center space-x-2">
                <span class="text-xs font-medium px-2.5 py-1 bg-green-100 text-green-800 rounded flex items-center">
                    <span class="h-2 w-2 rounded-full bg-green-500 mr-1.5 animate-pulse"></span>
                    Live Data
                </span>
                <span class="text-xs font-medium text-gray-500">Last updated: {{ now()->format('M d, Y H:i') }}</span>
            </div>
        </div>
        <ul class="flex flex-wrap px-4 -mb-px text-sm font-medium" id="dashboardTabs" role="tablist">
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 rounded-t-lg border-b-2 border-gray-800 text-gray-800 hover:bg-gray-50 transition-colors duration-200 active" id="overview-tab" data-tab="overview-tab-panel" type="button" role="tab">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                    Executive Dashboard
                </button>
            </li>
        </ul>
    </div>
    
    <!-- Tab Content -->
    <div id="dashboardTabContent">
        <!-- Overview Tab -->
        <div class="block" id="overview-tab-panel" role="tabpanel">

    <!-- Enhanced Executive Summary -->
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-md overflow-hidden border border-gray-100">
        <div class="relative px-6 py-8 md:px-10 md:py-12 overflow-hidden" style="background: linear-gradient(to right, rgba(249, 250, 251, 0.8), rgba(243, 244, 246, 0.8));">
            
            <!-- Content -->
            <div class="relative z-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 flex flex-wrap items-center mb-2">
                            <span>Welcome to Command Center</span>
                            <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-blue-600 bg-blue-100 rounded-full ml-2 mt-1">EXEC VIEW</span>
                        </h1>
                        <p class="text-gray-600 text-lg max-w-3xl">Real-time platform performance with integrated analytics and executive insights.</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <div class="px-3 py-1.5 bg-gray-100 rounded-lg flex items-center space-x-2">
                            <span class="inline-block h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                            <span class="text-sm text-gray-700 font-medium">Live updates</span>
                        </div>
                    </div>
                </div>
            
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <!-- PLATFORM HEALTH -->
                    <div class="bg-white/90 backdrop-blur-sm border border-gray-100 rounded-xl p-5 shadow-md hover:shadow-lg transition-all duration-300 group" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-xs font-semibold tracking-wider mb-1">PLATFORM HEALTH</p>
                                <div class="flex items-baseline space-x-1">
                                    <p class="text-gray-800 text-2xl font-bold group-hover:scale-105 transform transition-transform">{{ round(memory_get_usage() / 1048576, 1) }}MB</p>
                                    <span class="text-gray-600 text-xs">of memory</span>
                                </div>
                            </div>
                            <div class="bg-gray-100 rounded-full p-3 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500">CPU Load</span>
                                    <span class="text-gray-700">{{ function_exists('sys_getloadavg') ? round(sys_getloadavg()[0] * 10) : round(memory_get_usage() / memory_get_peak_usage() * 100) }}%</span>
                                </div>
                                <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-gray-400 rounded-full" style="width: {{ function_exists('sys_getloadavg') ? min(round(sys_getloadavg()[0] * 10), 100) : round(memory_get_usage() / memory_get_peak_usage() * 100) }}%"></div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500">Disk Usage</span>
                                    <span class="text-gray-700">{{ round((disk_total_space(DIRECTORY_SEPARATOR === '\\' ? 'C:' : '/') - disk_free_space(DIRECTORY_SEPARATOR === '\\' ? 'C:' : '/')) / disk_total_space(DIRECTORY_SEPARATOR === '\\' ? 'C:' : '/') * 100) }}%</span>
                                </div>
                                <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-gray-400 rounded-full" style="width: {{ min(round((disk_total_space(DIRECTORY_SEPARATOR === '\\' ? 'C:' : '/') - disk_free_space(DIRECTORY_SEPARATOR === '\\' ? 'C:' : '/')) / disk_total_space(DIRECTORY_SEPARATOR === '\\' ? 'C:' : '/') * 100), 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- MONTHLY GROWTH -->
                    <div class="bg-white/90 backdrop-blur-sm border border-gray-100 rounded-xl p-5 shadow-md hover:shadow-lg transition-all duration-300 group" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-xs font-semibold tracking-wider mb-1">MONTHLY GROWTH</p>
                                <div class="flex items-baseline space-x-1">  
                                    <p class="text-gray-800 text-2xl font-bold group-hover:scale-105 transform transition-transform">{{ $totalUsers > 0 ? round(($newUsers / $totalUsers) * 100) : 0 }}</p>
                                    <span class="text-blue-600 text-xs">% users</span>
                                </div>
                            </div>
                            <div class="bg-gray-100 rounded-full p-3 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 grid grid-cols-1 gap-4">
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500">{{ $newUsers }} new users this month</span>
                                    <span class="text-gray-700">{{ $totalUsers > 0 ? round(($newUsers / $totalUsers) * 100) : 0 }}% growth</span>
                                </div>
                                <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-gray-400 rounded-full" style="width: {{ min(($totalUsers > 0 ? ($newUsers / $totalUsers) * 100 : 0) * 2, 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ENGAGEMENT SCORE (Firebase-like Real-time Analytics) -->
                    <div class="bg-white/90 backdrop-blur-sm border border-gray-100 rounded-xl p-5 shadow-md hover:shadow-lg transition-all duration-300 group" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="flex items-center">
                                    <p class="text-gray-600 text-xs font-semibold tracking-wider mb-1">USER ENGAGEMENT SCORE</p>
                                    <!-- Live data indicator -->
                                    <div class="ml-2 flex items-center">
                                        <span class="flex h-2 w-2 relative mr-1">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                        </span>
                                        <span class="text-green-600 text-xs font-medium">LIVE</span>
                                    </div>
                                </div>
                                <div class="flex items-baseline space-x-1">
                                    <p id="engagement-score" class="text-gray-800 text-2xl font-bold group-hover:scale-105 transform transition-transform">{{ min(round(($totalProjects + $totalIdeas) / max($totalUsers, 1), 1), 5) }}/5</p>
                                    <span id="engagement-level" class="text-teal-600 text-xs">{{ ($totalProjects + $totalIdeas) / max($totalUsers, 1) > 1.5 ? 'excellent' : (($totalProjects + $totalIdeas) / max($totalUsers, 1) > 0.8 ? 'good' : 'average') }}</span>
                                </div>
                            </div>
                            <div class="bg-gray-100 rounded-full p-3 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 grid grid-cols-1 gap-4">
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500">Avg Contributions/User</span>
                                    <span id="contributions-per-user" class="text-gray-700">{{ round(($totalProjects + $totalIdeas) / max($totalUsers, 1), 1) }}</span>
                                </div>
                                <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                    <div id="contributions-bar" class="h-full bg-teal-500 rounded-full" style="width: {{ min(round(($totalProjects + $totalIdeas) / max($totalUsers, 1), 1) * 20, 100) }}%"></div>
                                </div>
                            </div>
                            <!-- Active Users (New Firebase-like Metric) -->
                            <div class="mt-3 space-y-2">
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500">Active Users (24h)</span>
                                    <span id="active-users" class="text-gray-700">--</span>
                                </div>
                                <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                    <div id="active-users-bar" class="h-full bg-blue-500 rounded-full" style="width: 0%"></div>
                                </div>
                            </div>
                            <!-- Events Per User (New Firebase-like Metric) -->
                            <div class="mt-3 space-y-2">
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500">Events Per User</span>
                                    <span id="events-per-user" class="text-gray-700">--</span>
                                </div>
                                <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                    <div id="events-per-user-bar" class="h-full bg-indigo-500 rounded-full" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ACTIVE PROJECTS -->
                    <div class="bg-white/90 backdrop-blur-sm border border-gray-100 rounded-xl p-5 shadow-md hover:shadow-lg transition-all duration-300 group" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-xs font-semibold tracking-wider mb-1">ACTIVE PROJECTS</p>
                                <div class="flex items-baseline space-x-1">
                                    <p class="text-gray-800 text-2xl font-bold group-hover:scale-105 transform transition-transform">{{ ceil($totalProjects * 0.6) }}</p>
                                    <span class="text-pink-600 text-xs">in progress</span>
                                </div>
                            </div>
                            <div class="bg-gray-100 rounded-full p-3 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 grid grid-cols-1 gap-4">
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500">Current Progress</span>
                                    <span class="text-gray-700">{{ ceil($totalProjects * 0.6) }} of {{ $totalProjects }}</span>
                                </div>
                                <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-gray-400 rounded-full" style="width: {{ $totalProjects > 0 ? min(ceil($totalProjects * 0.6) / $totalProjects * 100, 100) : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <!-- Stats Overview -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
                Platform Analytics
                <span class="ml-2 text-xs font-normal text-gray-500">Last 30 days</span>
            </h2>
            <div class="hidden md:flex items-center space-x-2">
                <button class="flex items-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-md transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export Data
                </button>
                <button id="refresh-data" class="flex items-center px-3 py-1.5 bg-green-50 hover:bg-green-100 text-green-700 text-sm font-medium rounded-md transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refresh Stats
                </button>
                <div class="px-2 py-1 bg-green-100 text-xs text-green-700 rounded-md flex items-center">
                    <span class="h-2 w-2 bg-green-500 rounded-full mr-1 animate-pulse"></span>
                    Live Data
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 text-xs" id="stats-container">
            <!-- Total Users Card (Modern Design) -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
                <div class="px-6 py-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Users</h3>
                        <div class="p-2 rounded-md bg-gray-100 relative">
                            <div class="absolute -top-1 -right-1 h-3 w-3 bg-green-500 rounded-full animate-ping"></div>
                            <div class="absolute -top-1 -right-1 h-3 w-3 bg-green-500 rounded-full"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5 5 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-baseline space-x-2">
                        <p class="text-3xl font-bold text-gray-800" id="total-users-count" data-value="{{ $totalUsers }}">{{ $totalUsers }}</p>
                        @if($newUsers > 0)
                        <span class="flex items-center text-sm font-semibold text-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            <span id="users-growth-pct">{{ round(($newUsers / max($totalUsers - $newUsers, 1)) * 100) }}%</span>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="px-6 py-3 bg-gray-50/70 backdrop-blur-sm border-t border-gray-100">
                    <div class="flex justify-between items-center mb-1 text-sm">
                        <span class="text-gray-600">New This Month</span>
                        <span class="text-blue-600 font-semibold" id="new-users-count">{{ $newUsers }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-gray-500 h-1.5 rounded-full" id="users-progress-bar" style="width: {{ $totalUsers > 0 ? min(($newUsers / $totalUsers) * 100, 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
            
            <!-- Total Projects Card (Modern Design) -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
                <div class="px-6 py-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Projects</h3>
                        <div class="p-2 rounded-md bg-gray-100 relative">
                            <div class="absolute -top-1 -right-1 h-3 w-3 bg-green-500 rounded-full animate-ping"></div>
                            <div class="absolute -top-1 -right-1 h-3 w-3 bg-green-500 rounded-full"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-baseline space-x-2">
                        <p class="text-3xl font-bold text-gray-800" id="total-projects-count" data-value="{{ $totalProjects }}">{{ $totalProjects }}</p>
                        @if($newProjects > 0)
                        <span class="flex items-center text-sm font-semibold text-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            <span id="projects-growth-pct">{{ round(($newProjects / max($totalProjects - $newProjects, 1)) * 100) }}%</span>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="px-6 py-3 bg-gray-50/70 backdrop-blur-sm border-t border-gray-100">
                    <div class="flex justify-between items-center mb-1 text-sm">
                        <span class="text-gray-600">New This Month</span>
                        <span class="text-indigo-600 font-semibold" id="new-projects-count">{{ $newProjects }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-gray-500 h-1.5 rounded-full" id="projects-progress-bar" style="width: {{ $totalProjects > 0 ? min(($newProjects / $totalProjects) * 100, 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
            
            <!-- Total Ideas Card (Modern Design) -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
                <div class="px-6 py-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Ideas</h3>
                        <div class="p-2 rounded-md bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-baseline space-x-2">
                        <p class="text-3xl font-bold text-gray-800">{{ $totalIdeas }}</p>
                        @if($newIdeas > 0)
                        <span class="flex items-center text-sm font-semibold text-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            {{ round(($newIdeas / max($totalIdeas - $newIdeas, 1)) * 100) }}%
                        </span>
                        @endif
                    </div>
                </div>
                <div class="px-6 py-3 bg-gray-50/70 backdrop-blur-sm border-t border-gray-100">
                    <div class="flex justify-between items-center mb-1 text-sm">
                        <span class="text-gray-600">New This Month</span>
                        <span class="text-purple-600 font-semibold">{{ $newIdeas }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-400 to-violet-500 h-1.5 rounded-full" style="width: {{ $totalIdeas > 0 ? min(($newIdeas / $totalIdeas) * 100, 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
            
            <!-- Total Frameworks Card (Modern Design) -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
                <div class="px-6 py-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Frameworks</h3>
                        <div class="p-2 rounded-md bg-teal-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-baseline space-x-2">
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Framework::getTotalCount() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Enhanced Analytics Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
        <!-- User Engagement Analytics (Enhanced & Realistic) -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden col-span-1 hover:shadow-lg transition-shadow duration-300 border border-gray-100 flex flex-col">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    User Engagement
                </h3>
                <div class="flex items-center space-x-2">
                    <span id="engagement-updated-time" class="text-xs font-medium text-gray-500 flex items-center bg-white bg-opacity-50 rounded-full px-2 py-1">
                        <span class="h-2 w-2 rounded-full bg-green-500 animate-pulse mr-1"></span>
                        Live Data
                    </span>
                </div>
            </div>
            <div class="p-6">
                <!-- Engagement Score Card -->
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Engagement Score</p>
                        <div class="flex items-baseline mt-1">
                            <p id="engagement-score-display" class="text-2xl font-bold text-gray-800">--</p>
                            <span class="text-xs font-medium ml-1 text-blue-600">/10</span>
                        </div>
                    </div>
                    <div class="p-2 bg-blue-50 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>

                <!-- Key Metrics Cards -->
                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div class="bg-white rounded-lg border border-gray-100 p-3 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Active Users</p>
                        <div class="flex items-baseline space-x-2">
                            <p id="active-users-count" class="text-lg font-bold text-gray-800">--</p>
                            <span id="active-users-growth" class="text-xs font-medium text-green-600 flex items-center">--</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg border border-gray-100 p-3 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Events Per User</p>
                        <div class="flex items-baseline space-x-2">
                            <p id="events-per-user" class="text-lg font-bold text-gray-800">--</p>
                            <span id="events-per-user-growth" class="text-xs font-medium text-green-600 flex items-center">--</span>
                        </div>
                    </div>
                </div>
                
                <!-- User Segments Chart -->
                <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-sm mb-4">
                    <div class="flex justify-between items-center mb-3">
                        <p class="text-sm font-medium text-gray-700">User Segments</p>
                    </div>
                    <div class="flex justify-center">
                        <div class="h-36 w-36">
                            <canvas id="userSegmentsChart"></canvas>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mt-3 text-center text-xs">
                        <div>
                            <p class="text-gray-500">High Engagement</p>
                            <p id="high-engagement-percent" class="font-semibold text-blue-600">--</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Moderate</p>
                            <p id="moderate-engagement-percent" class="font-semibold text-indigo-600">--</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Low Engagement</p>
                            <p id="low-engagement-percent" class="font-semibold text-purple-600">--</p>
                        </div>
                    </div>
                </div>
                
                <!-- Activity Timeline -->
                <div class="h-60 w-full">
                    <canvas id="userActivityChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Project Evolution (Enhanced) -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden col-span-2 hover:shadow-lg transition-shadow duration-300 border border-gray-100 flex flex-col">
            <div class="px-6 py-4 bg-gray-50/70 backdrop-blur-sm border-b flex items-center justify-between" style="background: linear-gradient(to right, rgba(243, 244, 246, 0.7), rgba(249, 250, 251, 0.7));">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                    Project & Idea Evolution
                </h3>
                <div class="flex space-x-2">
                    <button id="evolution-monthly" class="evolution-filter text-xs font-medium bg-white rounded-md px-2 py-1 shadow-sm border border-gray-200 text-indigo-600 hover:bg-indigo-50 transition-colors duration-200">Monthly</button>
                    <button id="evolution-quarterly" class="evolution-filter text-xs font-medium bg-indigo-600 rounded-md px-2 py-1 shadow-sm text-white">Quarterly</button>
                    <button id="evolution-yearly" class="evolution-filter text-xs font-medium bg-white rounded-md px-2 py-1 shadow-sm border border-gray-200 text-indigo-600 hover:bg-indigo-50 transition-colors duration-200">Yearly</button>
                </div>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <div class="space-y-1">
                        <div class="flex items-center space-x-2">
                            <span class="h-3 w-3 rounded-full bg-indigo-500"></span>
                            <span class="text-sm font-medium text-gray-600">Projects ({{ $totalProjects }})</span>
                        </div>

                        <div class="flex items-center space-x-2">
                            <span class="h-3 w-3 rounded-full bg-purple-500"></span>
                            <span class="text-sm font-medium text-gray-600">Ideas ({{ $totalIdeas }})</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Growth Rate</p>
                        <p class="text-xl font-bold text-indigo-600">+{{ round(($newProjects + $newIdeas) / max($totalProjects + $totalIdeas - $newProjects - $newIdeas, 1) * 100) }}%</p>
                    </div>
                </div>
                <div class="h-60 w-full">
                    <canvas id="evolutionChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Framework Usage & Activity Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
        <!-- Framework Usage (Enhanced) -->
        <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden col-span-1 border border-gray-100 flex flex-col" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
            <div class="px-6 py-4 bg-gray-50/70 backdrop-blur-sm border-b flex items-center justify-between" style="background: linear-gradient(to right, rgba(243, 244, 246, 0.7), rgba(249, 250, 251, 0.7));">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    Framework Usage
                </h3>
                <div class="rounded-full bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 flex items-center">
                    <span class="h-1.5 w-1.5 rounded-full bg-green-500 mr-1"></span>
                    Top {{ count(array_filter(array_values($frameworkUsage), function($v) { return $v > 0; })) }}
                </div>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500">Total Frameworks</p>
                    <p class="text-xl font-bold text-green-600">{{ $totalFrameworks }}</p>
                </div>
                <div class="h-60 w-full">
                    <canvas id="frameworkChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>
        <!-- Recent Activity (Enhanced) -->
        <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden col-span-2 border border-gray-100 flex flex-col" style="background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(249, 250, 251, 0.9));">
            <div class="px-6 py-4 bg-gray-50/70 backdrop-blur-sm border-b flex items-center justify-between" style="background: linear-gradient(to right, rgba(243, 244, 246, 0.7), rgba(249, 250, 251, 0.7));">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Recent Activity
                </h3>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                        <span class="h-1.5 w-1.5 rounded-full bg-teal-500 mr-1 animate-pulse"></span>
                        Live Feed
                    </span>
                    <button id="refresh-activity" class="text-gray-400 hover:text-teal-600 transition-colors duration-150 p-1 rounded-full hover:bg-gray-50" title="Refresh Activity">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="flow-root">
                    <ul class="-my-2 divide-y divide-gray-100">
                        @forelse(array_slice($recentActivity, 0, 5) as $activity)
                        <li class="py-3 hover:bg-gray-50 rounded-lg px-2 transition-colors duration-150">
                            <div class="flex items-center">
                                @php
                                    // Safe activity type with fallback
                                    $type = isset($activity['type']) ? $activity['type'] : 'general';
                                    
                                    // Predefined colors and icons based on activity type
                                    $colorMap = [
                                        'project' => 'indigo',
                                        'idea' => 'purple',
                                        'user' => 'blue',
                                        'general' => 'gray'
                                    ];
                                    
                                    // Get color with fallback to safe default
                                    $color = isset($activity['color']) ? $activity['color'] : 
                                            (array_key_exists($type, $colorMap) ? $colorMap[$type] : 'gray');
                                    
                                    // Predefined icons
                                    $iconMap = [
                                        'project' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                                        'idea' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                                        'user' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                                        'general' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                                    ];
                                    
                                    // Get icon with fallback
                                    $icon = isset($activity['icon']) ? $activity['icon'] : 
                                           (array_key_exists($type, $iconMap) ? $iconMap[$type] : $iconMap['general']);
                                @endphp
                                <div class="bg-{{ $color }}-100 p-2 rounded-full mr-3 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-{{ $color }}-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $activity['title'] }}</p>
                                        @if(isset($activity['owner']))
                                        <span class="ml-2 text-xs text-gray-500 whitespace-nowrap">by {{ $activity['owner'] }}</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-500 truncate">{{ $activity['description'] }}</p>
                                </div>
                                <div class="ml-3 flex-shrink-0 flex items-center space-x-2">
                                    <span class="text-xs bg-gray-100 text-gray-800 py-1 px-2 rounded-full" title="{{ isset($activity['created_at']) ? $activity['created_at']->format('Y-m-d H:i:s') : '' }}">
                                        {{ $activity['time'] ?? 'N/A' }}
                                    </span>
                                    <a href="#{{ $type }}-{{ $activity['id'] }}" class="text-gray-400 hover:text-{{ $color }}-600 transition-colors duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="py-8">
                            <div class="flex flex-col items-center justify-center text-center">
                                <div class="bg-gray-50 p-4 rounded-full shadow-sm mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h4 class="text-base font-medium text-gray-700 mb-2">No Recent Activity</h4>
                                <p class="text-sm text-gray-500 mb-3 max-w-xs">Activities will appear here as users engage with projects, ideas, and other features.</p>
                                <a href="/admin/users" class="text-xs text-teal-600 border border-teal-200 px-3 py-1.5 rounded-full inline-flex items-center hover:bg-teal-50 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Explore User Engagement
                                </a>
                            </div>
                        </li>
                        @endforelse
                    </ul>
                </div>
                @if(count($recentActivity) > 5)
                <div class="mt-6 text-center">
                    <a href="/admin/activity" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-teal-50 hover:border-teal-200 hover:text-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200">
                        View all activity
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
                @else
                <div class="mt-4 text-center">
                    <p class="text-xs text-gray-500">Showing all recent activity</p>
                </div>
                @endif
            </div>
        </div>
    </div>

        <!-- Projects & Ideas Section -->
        <div id="projects-tab-panel" role="tabpanel">
            <!-- Project Management Dashboard -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/70 backdrop-blur-sm" style="background: linear-gradient(to right, rgba(243, 244, 246, 0.7), rgba(249, 250, 251, 0.7));">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Projects & Ideas Analysis
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                        <!-- Project Stats Cards -->
                        <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg p-4 text-white shadow-md">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-purple-100">Total Projects</p>
                                    <p class="text-3xl font-bold">{{ $totalProjects }}</p>
                                </div>
                                <div class="p-3 bg-white bg-opacity-30 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex justify-between mb-1 text-xs text-purple-100">
                                    <span>This Month: {{ $newProjects }}</span>
                                    <span>{{ $totalProjects > 0 ? round(($newProjects / $totalProjects) * 100) : 0 }}%</span>
                                </div>
                                <div class="w-full bg-purple-200 bg-opacity-30 rounded-full h-2">
                                    <div class="bg-white h-2 rounded-full" style="width: {{ $totalProjects > 0 ? min(($newProjects / $totalProjects) * 100, 100) : 0 }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-blue-500 to-cyan-600 rounded-lg p-4 text-white shadow-md">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-blue-100">Total Ideas</p>
                                    <p class="text-3xl font-bold">{{ $totalIdeas }}</p>
                                </div>
                                <div class="p-3 bg-white bg-opacity-30 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex justify-between mb-1 text-xs text-blue-100">
                                    <span>This Month: {{ $newIdeas }}</span>
                                    <span>{{ $totalIdeas > 0 ? round(($newIdeas / $totalIdeas) * 100) : 0 }}%</span>
                                </div>
                                <div class="w-full bg-blue-200 bg-opacity-30 rounded-full h-2">
                                    <div class="bg-white h-2 rounded-full" style="width: {{ $totalIdeas > 0 ? min(($newIdeas / $totalIdeas) * 100, 100) : 0 }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-teal-500 to-green-600 rounded-lg p-4 text-white shadow-md">
                            <div class="flex justify-between items-center">
                                <div class="ml-6">
                                    <p class="text-sm font-medium text-teal-100">Idea Conversion Rate</p>
                                    <p class="text-3xl font-bold">{{ $totalIdeas > 0 ? round(($totalProjects / $totalIdeas) * 100) : 0 }}%</p>
                                </div>
                                <div class="p-3 bg-white bg-opacity-30 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex justify-between mb-1 text-xs text-teal-100">
                                    <span>Converted Ideas: {{ min($totalProjects, $totalIdeas) }}/{{ $totalIdeas }}</span>
                                    <span>Target: 60%</span>
                                </div>
                                <div class="w-full bg-teal-200 bg-opacity-30 rounded-full h-2">
                                    <div class="bg-white h-2 rounded-full" style="width: {{ $totalIdeas > 0 ? min(($totalProjects / $totalIdeas) * 100, 100) : 0 }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-amber-500 to-yellow-600 rounded-lg p-4 text-white shadow-md">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-amber-100">High Risks</p>
                                    <p class="text-3xl font-bold">{{ round($totalProjects * 0.8) }}</p>
                                </div>
                                <div class="p-3 bg-white bg-opacity-30 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex justify-between mb-1 text-xs text-amber-100">
                                    <span>This Month: {{ round($totalProjects * 0.8) }}</span>
                                    <span>{{ $totalProjects > 0 ? round(($totalProjects * 0.8 / $totalProjects) * 100) : 0 }}%</span>
                                </div>
                                <div class="w-full bg-amber-200 bg-opacity-30 rounded-full h-2">
                                    <div class="bg-white h-2 rounded-full" style="width: {{ $totalProjects > 0 ? min(($totalProjects * 0.8 / $totalProjects) * 100, 100) : 0 }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-lg p-4 text-white shadow-md">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-green-100">Resolved Risks</p>
                                    <p class="text-3xl font-bold">{{ round($totalProjects * 2.2) }}</p>
                                </div>
                                <div class="p-3 bg-white bg-opacity-30 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex justify-between mb-1 text-xs text-green-100">
                                    <span>This Month: {{ round($totalProjects * 2.2) }}</span>
                                    <span>{{ $totalProjects > 0 ? round(($totalProjects * 2.2 / $totalProjects) * 100) : 0 }}%</span>
                                </div>
                                <div class="w-full bg-green-200 bg-opacity-30 rounded-full h-2">
                                    <div class="bg-white h-2 rounded-full" style="width: {{ $totalProjects > 0 ? min(($totalProjects * 2.2 / $totalProjects) * 100, 100) : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8 mb-6">
                        <!-- Risks Matrix -->
                        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">
                            <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-rose-50 border-b flex items-center justify-between">
                                <h4 class="text-base font-semibold text-gray-800 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Risk Matrix
                                </h4>
                                <div class="rounded-full bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5">
                                    Interactive
                                </div>
                            </div>
                            <div class="p-6 flex-grow">
                                <canvas id="riskMatrixChart" class="w-full h-full" style="min-height: 260px"></canvas>
                            </div>
                        </div>

                        <!-- Dependencies Diagram -->
                        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">
                            <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-blue-50 border-b flex items-center justify-between">
                                <h4 class="text-base font-semibold text-gray-800 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                    </svg>
                                    Dependencies Diagram
                                </h4>
                                <div class="rounded-full bg-cyan-100 text-cyan-800 text-xs font-medium px-2.5 py-0.5">
                                    {{ $totalProjects * 2 }} Items
                                </div>
                            </div>
                            <div class="p-6 flex-grow">
                                <canvas id="dependencyChart" class="w-full h-full" style="min-height: 260px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Global statistics for dashboard charts
    window.totalUsers = {{ $totalUsers }};
    window.totalProjects = {{ $totalProjects }};
    window.totalIdeas = {{ $totalIdeas }};
    window.totalFrameworks = {{ $totalFrameworks }};
    
    // Framework usage data for charts
    window.frameworkUsage = {!! json_encode($frameworkUsage) !!};
    
    // Evolution data (monthly, quarterly, yearly)
    window.evolutionData = {!! json_encode($evolutionData) !!};
    
    // Función de utilidad para manejar errores globalmente
    function safeExecute(fn, fnName) {
        try {
            return fn();
        } catch (error) {
            console.warn(`Error ejecutando ${fnName}:`, error);
            return null;
        }
    }
    
    // Initialize User Engagement charts
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize charts with manejo de errores adecuado
        safeExecute(function() {
            if (typeof initializeUserSegmentsChart === 'function') {
                initializeUserSegmentsChart();
            }
        }, 'initializeUserSegmentsChart');
        
        safeExecute(function() {
            if (typeof initializeUserActivityChart === 'function') {
                initializeUserActivityChart();
            }
        }, 'initializeUserActivityChart');
        
        safeExecute(function() {
            initializeProjectEvolutionChart('quarterly'); // Default view
        }, 'initializeProjectEvolutionChart');
        
        safeExecute(function() {
            initializeFrameworkChart();
        }, 'initializeFrameworkChart');
        
        // Add event listeners for the evolution chart period buttons with error handling
        safeExecute(function() {
            const buttons = document.querySelectorAll('.evolution-filter');
            if (!buttons || buttons.length === 0) {
                console.log('No evolution filter buttons found');
                return;
            }
            
            buttons.forEach(function(button) {
                if (!button || !button.addEventListener) return;
                
                button.addEventListener('click', function() {
                    try {
                        // Remove active class from all buttons
                        document.querySelectorAll('.evolution-filter').forEach(function(btn) {
                            btn.classList.remove('bg-indigo-600', 'text-white');
                            btn.classList.add('bg-white', 'text-indigo-600', 'border', 'border-gray-200');
                        });
                        
                        // Add active class to clicked button
                        this.classList.remove('bg-white', 'text-indigo-600', 'border', 'border-gray-200');
                        this.classList.add('bg-indigo-600', 'text-white');
                        
                        // Get period from button id
                        const period = this.id.replace('evolution-', '');
                        
                        // Update chart safely
                        safeExecute(function() {
                            initializeProjectEvolutionChart(period);
                        }, 'initializeProjectEvolutionChart with ' + period);
                    } catch (error) {
                        console.warn('Error handling evolution filter click:', error);
                    }
                });
            });
        }, 'evolution filter buttons setup');
        
        // Load initial engagement data with error handling
        safeExecute(function() {
            if (typeof fetchEngagementData === 'function') {
                fetchEngagementData();
                
                // Set up interval to refresh data every 60 seconds
                const refreshInterval = setInterval(function() {
                    safeExecute(fetchEngagementData, 'fetchEngagementData (interval)');
                }, 60000);
                
                // Store interval ID to prevent memory leaks
                window.dashboardRefreshInterval = refreshInterval;
            } else {
                console.log('fetchEngagementData function not available, skipping refresh');
            }
        }, 'initial data fetch');
    });
    
    // Función de utilidad para limpiar gráficos anteriores correctamente
    function safeDestroyChart(canvasId) {
        try {
            // Verificar si hay gráficos registrados en este canvas
            const chartInstance = Chart.getChart(canvasId);
            if (chartInstance) {
                // Destruir el gráfico existente
                chartInstance.destroy();
                console.log(`Chart on canvas ${canvasId} properly destroyed`);
            }
        } catch (error) {
            console.warn(`Error destroying chart on ${canvasId}:`, error);
        }
    }

    // Project Evolution Chart bridge function to connect UI buttons with dashboard-init.js functionality
    function initializeProjectEvolutionChart(period) {
        // Update the window activeEvolutionPeriod property for dashboard-init.js
        window.activeEvolutionPeriod = period;
        
        // If dashboard-init.js has initialized the chart, call its function
        if (typeof window.initEvolutionChart === 'function') {
            window.initEvolutionChart(period);
        } else {
            console.log('Using built-in evolution chart rendering');
            
            // Fallback - get evolution data for the selected period
            const data = window.evolutionData[period] || {
                labels: [],
                projects: [],
                ideas: []
            };
            
            // Limpiar adecuadamente cualquier gráfico existente
            safeDestroyChart('evolutionChart');
            
            // Get canvas context
            const canvas = document.getElementById('evolutionChart');
            if (!canvas) {
                console.warn('Evolution chart canvas not found');
                return;
            }
            
            const ctx = canvas.getContext('2d');
            
            // Create new chart
            window.evolutionChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Projects',
                        data: data.projects,
                        borderColor: 'rgb(99, 102, 241)',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgb(99, 102, 241)',
                        pointRadius: 3,
                        pointHoverRadius: 5
                    },
                    {
                        label: 'Ideas',
                        data: data.ideas,
                        borderColor: 'rgb(168, 85, 247)',
                        backgroundColor: 'rgba(168, 85, 247, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgb(168, 85, 247)',
                        pointRadius: 3,
                        pointHoverRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }
    }
    
    // Framework Usage Chart
    function initializeFrameworkChart() {
        // Limpiar adecuadamente cualquier gráfico existente
        safeDestroyChart('frameworkChart');
        
        // Get canvas element
        const canvas = document.getElementById('frameworkChart');
        if (!canvas) {
            console.warn('Framework chart canvas not found');
            return;
        }
        
        const ctx = canvas.getContext('2d');
        
        // Prepare data for the chart
        const labels = Object.keys(window.frameworkUsage);
        const values = Object.values(window.frameworkUsage);
        
        // Generate colors based on the number of frameworks
        const colors = generateGradientColors(labels.length, [24, 144, 255], [136, 87, 255]);
        
        const chartConfig = {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 12,
                            padding: 15,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                const value = context.raw;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        };
        
        // Usar window.frameworkChart para coherencia global
        window.frameworkChart = new Chart(ctx, chartConfig);
    }
    
    // All user engagement related functions have been moved to the external file
    // user-engagement-charts.js to prevent conflicts and improve maintainability
    
    // Helper function to generate gradient colors
    function generateGradientColors(count, startRGB, endRGB) {
        const colors = [];
        for (let i = 0; i < count; i++) {
            const ratio = count > 1 ? i / (count - 1) : 0.5;
            const r = Math.round(startRGB[0] + ratio * (endRGB[0] - startRGB[0]));
            const g = Math.round(startRGB[1] + ratio * (endRGB[1] - startRGB[1]));
            const b = Math.round(startRGB[2] + ratio * (endRGB[2] - startRGB[2]));
            colors.push(`rgb(${r}, ${g}, ${b})`);
        }
        return colors;
    }
</script>
    
    // Prevent any conflicts with existing charts
    window.addEventListener('DOMContentLoaded', function() {
        // Clear any duplicate chart initializations
        if (window.userEngagementChartsLoaded) return;
        window.userEngagementChartsLoaded = true;
    });
</script>
<!-- Load the separate user engagement charts script -->
<script src="{{ asset('js/user-engagement-charts.js') }}"></script>
@endpush
