@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="p-6 space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            User Details
        </h2>
        <div class="flex space-x-3">
            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring focus:ring-indigo-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring focus:ring-gray-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Users
            </a>
        </div>
    </div>

    <!-- User Profile Section -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-blue-50 border-b flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Profile Information</h3>
            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $user->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="col-span-1 flex flex-col items-center">
                    <div class="w-40 h-40 overflow-hidden rounded-full border-4 border-white shadow-lg">
                        <img class="w-full h-full object-cover object-center" 
                             src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF&size=200' }}" 
                             alt="{{ $user->name }}">
                    </div>
                    <div class="mt-4 text-center">
                        <h4 class="text-xl font-bold text-gray-900">{{ $user->name }}</h4>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <div class="mt-2">
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                {{ $user->role->name ?? 'User' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Account Details</h4>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-gray-500">ID</p>
                                    <p class="text-sm font-medium">{{ $user->id }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Registered On</p>
                                    <p class="text-sm font-medium">{{ $user->created_at->format('F j, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Last Login</p>
                                    <p class="text-sm font-medium">{{ $user->last_login_at ? $user->last_login_at->format('F j, Y g:i A') : 'Never' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Email Verification</p>
                                    <p class="text-sm font-medium">
                                        @if($user->email_verified_at)
                                            <span class="text-green-600">Verified on {{ $user->email_verified_at->format('F j, Y') }}</span>
                                        @else
                                            <span class="text-red-600">Not verified</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Contact Information</h4>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-gray-500">Full Name</p>
                                    <p class="text-sm font-medium">{{ $user->first_name }} {{ $user->last_name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Email Address</p>
                                    <p class="text-sm font-medium">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Job Title</p>
                                    <p class="text-sm font-medium">{{ $user->job_title ?? 'Not specified' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- User Stats Section -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-emerald-50 to-teal-50 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-0">
            <h3 class="text-lg font-semibold text-gray-800">User Activity & Statistics</h3>
            <div class="flex flex-wrap gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Account age: {{ $stats['account_age_months'] }} months
                </span>
                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    {{ $stats['total_projects'] + $stats['total_ideas'] }} contributions
                </span>
            </div>
        </div>
        <div class="p-6">
            <!-- Account Information -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center">
                        <div class="h-8 w-8 bg-indigo-100 rounded-lg border border-indigo-200 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-700 uppercase tracking-wider">Account Timeline</h4>
                    </div>
                    <span class="text-xs bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full font-medium">{{ $stats['activity_logs'] > 0 ? $stats['activity_logs'] + 2 : 2 }} events</span>
                </div>
                
                <div class="relative">
                    <!-- Timeline line -->
                    <div class="absolute top-0 bottom-0 left-4 md:left-1/2 w-0.5 bg-gradient-to-b from-blue-300 via-green-300 to-amber-300 transform md:-translate-x-1/2 rounded-full" style="z-index: 1;"></div>
                    
                    <!-- Timeline events -->
                    <div class="space-y-8 relative pb-4" style="z-index: 2;">
                        <!-- Registration event -->
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-5">
                            <!-- Left side (mobile top) -->
                            <div class="flex items-center md:w-1/2 md:justify-end md:pr-8 order-2 md:order-1">
                                <div class="bg-blue-50 rounded-lg p-4 w-full md:max-w-xs shadow-sm border border-blue-100 hover:shadow-md transition group">
                                    <div class="flex items-center mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <p class="text-sm font-medium text-blue-800 group-hover:text-blue-900 transition">User registered</p>
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $stats['registration_date'] ? $stats['registration_date']->format('F j, Y g:i A') : 'Date unknown' }}</p>
                                    <p class="text-xs text-blue-600 mt-2 md:hidden">{{ $stats['registration_date'] ? $stats['registration_date']->diffForHumans(null, true) . ' ago' : '' }}</p>
                                </div>
                            </div>
                            
                            <!-- Center icon -->
                            <div class="absolute left-0 md:left-1/2 transform md:-translate-x-1/2 flex items-center justify-center z-20 order-1 md:order-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center shadow-md border-2 border-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Right side (mobile blank) -->
                            <div class="hidden md:block md:w-1/2 md:pl-8 order-3">
                                <div class="bg-white px-3 py-2 rounded-lg shadow-sm border border-gray-100 inline-block">
                                    <p class="text-sm font-medium text-gray-700">{{ $stats['registration_date'] ? $stats['registration_date']->diffForHumans(null, true) . ' ago' : '' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Last login event -->
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-5 pt-2">
                            <!-- Left side (mobile blank) -->
                            <div class="hidden md:block md:w-1/2 md:text-right md:pr-8 order-1">
                                <div class="bg-white px-3 py-2 rounded-lg shadow-sm border border-gray-100 inline-block ml-auto">
                                    <p class="text-sm font-medium text-gray-700">{{ $stats['last_login'] ? $stats['last_login']->diffForHumans() : 'Never logged in' }}</p>
                                </div>
                            </div>
                            
                            <!-- Center icon -->
                            <div class="absolute left-0 md:left-1/2 transform md:-translate-x-1/2 flex items-center justify-center z-20 order-1 md:order-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-md border-2 border-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Right side (mobile below) -->
                            <div class="flex items-center md:w-1/2 md:pl-8 order-2 md:order-3">
                                <div class="bg-green-50 rounded-lg p-4 w-full md:max-w-xs shadow-sm border border-green-100 hover:shadow-md transition group">
                                    <div class="flex items-center mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                        <p class="text-sm font-medium text-green-800 group-hover:text-green-900 transition">Last login</p>
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $stats['last_login'] ? $stats['last_login']->format('F j, Y g:i A') : 'Never logged in' }}</p>
                                    <p class="text-xs text-green-600 mt-2 md:hidden">{{ $stats['last_login_human'] }}</p>
                                </div>
                            </div>
                        </div>
                        
                        @if($stats['activity_logs'] > 0)
                        <!-- Last activity event -->
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-5 pt-2">
                            <!-- Left side (mobile top) -->
                            <div class="flex items-center md:w-1/2 md:justify-end md:pr-8 order-2 md:order-1">
                                <div class="bg-amber-50 rounded-lg p-4 w-full md:max-w-xs shadow-sm border border-amber-100 hover:shadow-md transition group">
                                    <div class="flex items-center mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-sm font-medium text-amber-800 group-hover:text-amber-900 transition">{{ isset($stats['last_activity_type']) ? $stats['last_activity_type'] : 'Latest activity' }}</p>
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $stats['last_activity_date'] ? date('F j, Y g:i A', strtotime($stats['last_activity_date'])) : 'No activity recorded' }}</p>
                                    <div class="flex items-center mt-2">
                                        <div class="text-xs bg-amber-100 text-amber-800 px-2 py-1 rounded-full font-medium">{{ $stats['activity_logs'] }} activities</div>
                                        <p class="text-xs text-amber-600 mt-0 ml-2 md:hidden">{{ $stats['last_activity_date'] ? \Carbon\Carbon::parse($stats['last_activity_date'])->diffForHumans() : '' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Center icon -->
                            <div class="absolute left-0 md:left-1/2 transform md:-translate-x-1/2 flex items-center justify-center z-20 order-1 md:order-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full flex items-center justify-center shadow-md border-2 border-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Right side (mobile blank) -->
                            <div class="hidden md:block md:w-1/2 md:pl-8 order-3">
                                <div class="bg-white px-3 py-2 rounded-lg shadow-sm border border-gray-100 inline-block">
                                    <p class="text-sm font-medium text-gray-700">{{ $stats['last_activity_date'] ? \Carbon\Carbon::parse($stats['last_activity_date'])->diffForHumans() : '' }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contribution Stats -->
            <div class="md:mb-0 mb-6">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center">
                        <div class="h-8 w-8 bg-purple-100 rounded-lg border border-purple-200 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-700 uppercase tracking-wider">Contribution Statistics</h4>
                    </div>
                    <a href="{{ route('admin.users.stats', $user->id) }}" class="text-xs bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition px-3 py-1.5 rounded-full font-medium flex items-center">
                        <span>View all stats</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
    
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Projects Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition overflow-hidden">
                        <!-- Card Header -->
                        <div class="px-5 py-4 bg-gradient-to-r from-purple-50 to-purple-100 border-b border-purple-200 flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-purple-100 border border-purple-200 flex items-center justify-center mr-3 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Projects</h3>
                                    <p class="text-xs text-gray-500">{{ $user->name }}'s project activity</p>
                                </div>
                            </div>
                            <div class="text-center">
                                <span class="text-2xl font-bold text-purple-700 block">{{ $stats['total_projects'] }}</span>
                                <span class="text-xs text-gray-500">total</span>
                            </div>
                        </div>
                        
                        <!-- Card Content -->
                        <div class="p-5">
                            <div class="flex flex-wrap items-center gap-2 mb-5">
                                <div class="px-3 py-1.5 rounded-full text-xs font-medium {{ $stats['completed_projects'] > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $stats['completed_projects'] }} completed
                                </div>
                                <div class="px-3 py-1.5 rounded-full text-xs font-medium {{ $stats['in_progress_projects'] > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $stats['in_progress_projects'] }} in progress
                                </div>
                                <div class="px-3 py-1.5 rounded-full text-xs font-medium {{ $stats['pending_projects'] > 0 ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $stats['pending_projects'] }} pending
                                </div>
                            </div>
                            
                            <!-- Progress Bars -->
                            <div class="space-y-4 bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div>
                                    <div class="flex justify-between mb-2 text-xs font-medium">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                                            <span class="text-gray-700">Completed</span>
                                        </div>
                                        <span class="text-gray-700 font-semibold">{{ $stats['total_projects'] > 0 ? number_format(($stats['completed_projects'] / $stats['total_projects'] * 100), 0) : 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner">
                                        <div class="bg-gradient-to-r from-green-400 to-green-600 h-3 rounded-full transition-all duration-500" style="width: {{ $stats['total_projects'] > 0 ? ($stats['completed_projects'] / $stats['total_projects'] * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="flex justify-between mb-2 text-xs font-medium">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                                            <span class="text-gray-700">In Progress</span>
                                        </div>
                                        <span class="text-gray-700 font-semibold">{{ $stats['total_projects'] > 0 ? number_format(($stats['in_progress_projects'] / $stats['total_projects'] * 100), 0) : 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner">
                                        <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-3 rounded-full transition-all duration-500" style="width: {{ $stats['total_projects'] > 0 ? ($stats['in_progress_projects'] / $stats['total_projects'] * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="flex justify-between mb-2 text-xs font-medium">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 rounded-full bg-amber-500 mr-2"></div>
                                            <span class="text-gray-700">Pending</span>
                                        </div>
                                        <span class="text-gray-700 font-semibold">{{ $stats['total_projects'] > 0 ? number_format(($stats['pending_projects'] / $stats['total_projects'] * 100), 0) : 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner">
                                        <div class="bg-gradient-to-r from-amber-400 to-amber-600 h-3 rounded-full transition-all duration-500" style="width: {{ $stats['total_projects'] > 0 ? ($stats['pending_projects'] / $stats['total_projects'] * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ideas Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition overflow-hidden">
                        <!-- Card Header -->
                        <div class="px-5 py-4 bg-gradient-to-r from-pink-50 to-pink-100 border-b border-pink-200 flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-pink-100 border border-pink-200 flex items-center justify-center mr-3 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Ideas</h3>
                                    <p class="text-xs text-gray-500">{{ $user->name }}'s idea contributions</p>
                                </div>
                            </div>
                            <div class="text-center">
                                <span class="text-2xl font-bold text-pink-700 block">{{ $stats['total_ideas'] }}</span>
                                <span class="text-xs text-gray-500">total</span>
                            </div>
                        </div>
                        
                        <!-- Card Content -->
                        <div class="p-5">
                            <div class="flex flex-wrap items-center gap-2 mb-5">
                                <div class="px-3 py-1.5 rounded-full text-xs font-medium {{ $stats['implemented_ideas'] > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $stats['implemented_ideas'] }} implemented
                                </div>
                                <div class="px-3 py-1.5 rounded-full text-xs font-medium {{ $stats['evaluating_ideas'] > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $stats['evaluating_ideas'] }} evaluating
                                </div>
                                <div class="px-3 py-1.5 rounded-full text-xs font-medium {{ ($stats['total_ideas'] - $stats['implemented_ideas'] - $stats['evaluating_ideas']) > 0 ? 'bg-gray-100 text-gray-600' : 'hidden' }}">
                                    {{ $stats['total_ideas'] - $stats['implemented_ideas'] - $stats['evaluating_ideas'] }} other
                                </div>
                            </div>
                            
                            <!-- Progress Bars -->
                            <div class="space-y-4 bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div>
                                    <div class="flex justify-between mb-2 text-xs font-medium">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                                            <span class="text-gray-700">Implemented</span>
                                        </div>
                                        <span class="text-gray-700 font-semibold">{{ $stats['total_ideas'] > 0 ? number_format(($stats['implemented_ideas'] / $stats['total_ideas'] * 100), 0) : 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner">
                                        <div class="bg-gradient-to-r from-green-400 to-green-600 h-3 rounded-full transition-all duration-500" style="width: {{ $stats['total_ideas'] > 0 ? ($stats['implemented_ideas'] / $stats['total_ideas'] * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="flex justify-between mb-2 text-xs font-medium">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                                            <span class="text-gray-700">Evaluating</span>
                                        </div>
                                        <span class="text-gray-700 font-semibold">{{ $stats['total_ideas'] > 0 ? number_format(($stats['evaluating_ideas'] / $stats['total_ideas'] * 100), 0) : 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner">
                                        <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-3 rounded-full transition-all duration-500" style="width: {{ $stats['total_ideas'] > 0 ? ($stats['evaluating_ideas'] / $stats['total_ideas'] * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="flex justify-between mb-2 text-xs font-medium">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 rounded-full bg-gray-400 mr-2"></div>
                                            <span class="text-gray-700">Other</span>
                                        </div>
                                        <span class="text-gray-700 font-semibold">{{ $stats['total_ideas'] > 0 ? number_format((($stats['total_ideas'] - $stats['implemented_ideas'] - $stats['evaluating_ideas']) / $stats['total_ideas'] * 100), 0) : 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner">
                                        <div class="bg-gradient-to-r from-gray-400 to-gray-500 h-3 rounded-full transition-all duration-500" style="width: {{ $stats['total_ideas'] > 0 ? (($stats['total_ideas'] - $stats['implemented_ideas'] - $stats['evaluating_ideas']) / $stats['total_ideas'] * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Summary -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition overflow-hidden">
                        <!-- Card Header -->
                        <div class="px-5 py-4 bg-gradient-to-r from-amber-50 to-amber-100 border-b border-amber-200 flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-amber-100 border border-amber-200 flex items-center justify-center mr-3 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Activity</h3>
                                    <p class="text-xs text-gray-500">{{ $user->name }}'s recent engagement</p>
                                </div>
                            </div>
                            <div class="text-center">
                                <span class="text-2xl font-bold text-amber-700 block">{{ $stats['activity_logs'] }}</span>
                                <span class="text-xs text-gray-500">actions</span>
                            </div>
                        </div>
                        
                        <!-- Card Content -->
                        <div class="p-5">
                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div class="flex flex-col items-center justify-center p-4 rounded-lg bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-100 shadow-sm hover:shadow transition">
                                    <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mb-2 border border-purple-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <span class="text-xs text-purple-700 font-medium mb-1">Projects</span>
                                    <span class="text-2xl font-bold text-purple-800">{{ $stats['total_projects'] }}</span>
                                </div>
                                <div class="flex flex-col items-center justify-center p-4 rounded-lg bg-gradient-to-br from-pink-50 to-pink-100 border border-pink-100 shadow-sm hover:shadow transition">
                                    <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center mb-2 border border-pink-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-pink-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs text-pink-700 font-medium mb-1">Ideas</span>
                                    <span class="text-2xl font-bold text-pink-800">{{ $stats['total_ideas'] }}</span>
                                </div>
                            </div>
                            
                            <!-- Activity Stats -->
                            <div class="space-y-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                        <span class="text-sm font-medium text-gray-700">Completed</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-800 bg-green-100 px-2.5 py-1 rounded-full">{{ $stats['completed_projects'] }}</span>
                                </div>
                                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                        <span class="text-sm font-medium text-gray-700">In Progress</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-800 bg-blue-100 px-2.5 py-1 rounded-full">{{ $stats['in_progress_projects'] }}</span>
                                </div>
                                <div class="flex items-center justify-between py-2">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-amber-500 rounded-full mr-2"></div>
                                        <span class="text-sm font-medium text-gray-700">Last active</span>
                                    </div>
                                    <span class="text-sm font-semibold bg-amber-100 px-2.5 py-1 rounded-full">{{ $stats['last_activity_date'] ? \Carbon\Carbon::parse($stats['last_activity_date'])->diffForHumans() : 'N/A' }}</span>
                                </div>
                            </div>
                            
                            <!-- Last Activity -->
                            @if($stats['last_activity_date'])
                            <div class="mt-4 flex items-center justify-between bg-gradient-to-r from-amber-50 to-amber-100 p-3 rounded-lg border border-amber-200">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-xs text-amber-800 font-medium">{{ isset($stats['last_activity_type']) ? $stats['last_activity_type'] : 'Latest activity' }}</p>
                                        <p class="text-xs text-gray-600">{{ date('F j, Y g:i A', strtotime($stats['last_activity_date'])) }}</p>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('admin.users.activity', $user->id) }}" class="text-xs bg-amber-200 hover:bg-amber-300 text-amber-800 px-2 py-1 rounded-full transition">
                                        View all
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- User Devices Section -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
        <div class="px-6 py-4 bg-gradient-to-r from-sky-50 to-blue-50 border-b flex justify-between items-center">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-lg bg-blue-100 border border-blue-200 flex items-center justify-center mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Login Devices</h3>
            </div>
            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{ count($devices) }} devices</span>
        </div>
        
        @if(count($devices) > 0)
        <!-- Desktop Table View -->
        <div class="hidden md:block p-6">
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">OS</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Browser</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Login</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($devices as $device)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-left">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full {{ $device['type'] == 'Desktop' ? 'bg-blue-100' : 'bg-green-100' }} flex items-center justify-center mr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $device['type'] == 'Desktop' ? 'text-blue-600' : 'text-green-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            @if($device['type'] == 'Desktop')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            @endif
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $device['type'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-left text-gray-900">{{ $device['os'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-left text-gray-900">{{ $device['browser'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-left text-gray-500">
                                {{ $device['last_login'] }}
                                <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($device['last_login'])->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-left text-gray-500 font-mono">{{ $device['ip'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Mobile Card View -->
        <div class="md:hidden p-4">
            <div class="space-y-4">
                @foreach($devices as $device)
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition">
                    <div class="px-4 py-3 {{ $device['type'] == 'Desktop' ? 'bg-blue-50 border-b border-blue-100' : 'bg-green-50 border-b border-green-100' }} flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full {{ $device['type'] == 'Desktop' ? 'bg-blue-100' : 'bg-green-100' }} flex items-center justify-center mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $device['type'] == 'Desktop' ? 'text-blue-600' : 'text-green-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    @if($device['type'] == 'Desktop')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    @endif
                                </svg>
                            </div>
                            <span class="font-medium text-gray-900">{{ $device['type'] }}</span>
                        </div>
                        <span class="inline-flex px-2 py-1 text-xs rounded-full {{ $device['type'] == 'Desktop' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">{{ $device['os'] }}</span>
                    </div>
                    <div class="p-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Browser</span>
                            <span class="text-sm font-medium">{{ $device['browser'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Last Login</span>
                            <span class="text-sm font-medium">{{ \Carbon\Carbon::parse($device['last_login'])->diffForHumans() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">IP Address</span>
                            <span class="text-sm font-mono text-gray-700">{{ $device['ip'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <!-- No Login Devices Available Message -->
        <div class="p-6">
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">No login devices data available</h3>
                <p class="text-gray-500 max-w-md mx-auto">
                    No real login device data could be found for this user in the database.
                </p>
            </div>
        </div>
        @endif
    </div>
    
    <!-- User Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Projects Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-violet-50 to-purple-50 border-b border-purple-100 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-purple-100 border border-purple-200 flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Recent Projects</h3>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">{{ $stats['total_projects'] }} total</span>
            </div>
            <div class="p-5">
                @if($user->projects->count() > 0)
                    <div class="space-y-4 max-h-96 overflow-y-auto pr-1">
                        @foreach($user->projects as $project)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition shadow-sm hover:shadow">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-purple-700 hover:text-purple-800 transition">{{ $project->title }}</h4>
                                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ Str::limit($project->description, 120) }}</p>
                                    </div>
                                    <span class="ml-3 flex-shrink-0 px-3 py-1 text-xs rounded-full font-medium {{ 
                                        $project->status == 'Completed' ? 'bg-green-100 text-green-800' : 
                                        ($project->status == 'In Progress' ? 'bg-blue-100 text-blue-800' : 
                                        'bg-yellow-100 text-yellow-800') 
                                    }}">
                                        {{ $project->status }}
                                    </span>
                                </div>
                                <div class="mt-3 flex justify-between items-center">
                                    <div class="flex items-center text-xs text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $project->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="text-xs">
                                        <span class="text-gray-400">{{ $project->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($stats['total_projects'] > count($user->projects))
                        <div class="mt-4 text-center">
                            <a href="#" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 transition">
                                <span>View all {{ $stats['total_projects'] }} projects</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-12 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="mt-2 text-gray-500 font-medium">No projects found</p>
                        <p class="text-sm text-gray-400">This user hasn't created any projects yet</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Ideas Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-pink-50 to-rose-50 border-b border-pink-100 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-pink-100 border border-pink-200 flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Recent Ideas</h3>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-800">{{ $stats['total_ideas'] }} total</span>
            </div>
            <div class="p-5">
                @if($user->ideas->count() > 0)
                    <div class="space-y-4 max-h-96 overflow-y-auto pr-1">
                        @foreach($user->ideas as $idea)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition shadow-sm hover:shadow">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-pink-700 hover:text-pink-800 transition">{{ $idea->title }}</h4>
                                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ Str::limit($idea->description, 120) }}</p>
                                    </div>
                                    <span class="ml-3 flex-shrink-0 px-3 py-1 text-xs rounded-full font-medium bg-pink-100 text-pink-800">
                                        {{ $idea->category ?? 'Uncategorized' }}
                                    </span>
                                </div>
                                <div class="mt-3 flex justify-between items-center">
                                    <div class="flex items-center text-xs text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $idea->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="text-xs">
                                        <span class="text-gray-400">{{ $idea->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($stats['total_ideas'] > count($user->ideas))
                        <div class="mt-4 text-center">
                            <a href="#" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 transition">
                                <span>View all {{ $stats['total_ideas'] }} ideas</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-12 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        <p class="mt-2 text-gray-500 font-medium">No ideas found</p>
                        <p class="text-sm text-gray-400">This user hasn't submitted any ideas yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Advanced Settings Section -->
    @php
        // Handle case where advanced_settings might be a string instead of an array
        $advancedSettings = null;
        if ($user->advanced_settings) {
            if (is_string($user->advanced_settings)) {
                // Try to decode JSON string (handle potential double-encoding)
                $cleanJson = trim($user->advanced_settings, '"');
                try {
                    $advancedSettings = json_decode($cleanJson, true);
                } catch (\Exception $e) {
                    // Just leave as null if can't decode
                }
            } else {
                // Already an array
                $advancedSettings = $user->advanced_settings;
            }
        }
    @endphp

    @if($advancedSettings)
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-slate-50 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Advanced Settings</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Data Export</h4>
                    <p class="text-sm">{{ isset($advancedSettings['export_data']) && $advancedSettings['export_data'] ? 'Enabled' : 'Disabled' }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Timezone</h4>
                    <p class="text-sm">{{ $advancedSettings['timezone'] ?? 'UTC' }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Date Format</h4>
                    <p class="text-sm">{{ $advancedSettings['date_format'] ?? 'Y-m-d' }}</p>
                </div>
                @if(isset($advancedSettings['language']))
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Language</h4>
                    <p class="text-sm">{{ $advancedSettings['language'] ?? 'en' }}</p>
                </div>
                @endif
            </div>
            <div class="mt-4 text-right text-xs text-gray-500">
                Last updated: {{ isset($advancedSettings['last_updated']) ? date('F j, Y g:i A', strtotime($advancedSettings['last_updated'])) : 'Never' }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
