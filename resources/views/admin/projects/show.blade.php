@extends('layouts.admin')

@section('title', 'Project Details')

@section('styles')
<style>
    /* Layout Styles */
    .project-detail-layout {
        display: flex;
        min-height: calc(100vh - 64px);
        background-color: #f9fafb;
    }
    
    .sidebar {
        width: 300px;
        flex-shrink: 0;
        border-right: 1px solid #e5e7eb;
        background-color: white;
    }
    
    .main-content {
        flex-grow: 1;
        padding: 1.5rem;
        background-color: #f9fafb;
    }
    
    /* Sidebar Styles */
    .sidebar-section {
        padding: 1.25rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .sidebar-title {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7280;
        letter-spacing: 0.05em;
        margin-bottom: 1rem;
    }
    
    .team-member {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }
    
    /* Team Avatar Styles */
    .team-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 11px;
        margin-right: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border: 1.5px solid rgba(255, 255, 255, 0.7);
        transition: transform 0.2s;
    }
    
    .team-avatar:hover {
        transform: scale(1.05);
    }
    
    .team-avatar.green {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #16a34a;
    }
    
    /* Progress Bar Styles */
    .progress-bar {
        height: 6px;
        background-color: #f3f4f6;
        border-radius: 9999px;
        overflow: hidden;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    
    .progress-value {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #60a5fa);
        border-radius: 9999px;
        box-shadow: 0 1px 3px rgba(59, 130, 246, 0.3);
        transition: width 0.4s ease-in-out;
    }
    
    /* Milestone Progress */
    .milestone-progress {
        height: 4px;
        background-color: #f3f4f6;
        border-radius: 9999px;
        overflow: hidden;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.04);
        position: relative;
    }
    
    .milestone-value {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #60a5fa);
        border-radius: 9999px;
        transition: width 0.4s ease;
        box-shadow: 0 0 3px rgba(59, 130, 246, 0.3);
    }
    
    .milestone-item {
        padding: 10px 12px;
        border-radius: 8px;
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }
    
    .milestone-item:hover {
        background-color: #f9fafb;
        border-color: #e5e7eb;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    /* Tab Styles */
    .tabs {
        display: flex;
        border-bottom: 1px solid #e5e7eb;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none;
        position: relative;
        padding: 0 4px;
        gap: 4px;
    }
    
    .tabs::-webkit-scrollbar {
        display: none;
    }
    
    .tab {
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 500;
        color: #6b7280;
        border-bottom: 2px solid transparent;
        transition: all 0.2s ease;
        position: relative;
        letter-spacing: 0.01em;
    }
    
    .tab.active {
        color: #3b82f6;
        border-bottom: 2px solid #3b82f6;
        font-weight: 600;
    }
    
    .tab.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 50%;
        transform: translateX(-50%);
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background-color: #3b82f6;
    }
    
    .tab:hover:not(.active) {
        color: #1f2937;
        background-color: #f9fafb;
        border-radius: 4px 4px 0 0;
    }
    
    /* Filter Button Styles */
    .filter-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.3rem 0.85rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        background-color: white;
        color: #6b7280;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    
    .filter-btn:hover:not(.active) {
        background-color: #f9fafb;
        color: #4b5563;
        border-color: #e5e7eb;
    }
    
    .filter-btn.active {
        background-color: #dbeafe;
        color: #2563eb;
        font-weight: 600;
        border-color: #bfdbfe;
    }
    
    /* Make tabs horizontally scrollable on mobile */
    @media (max-width: 768px) {
        .project-layout {
            flex-direction: column;
        }
        
        .sidebar {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .tabs {
            overflow-x: auto;
            white-space: nowrap;
            scrollbar-width: none;
        }
        
        .tabs::-webkit-scrollbar {
            display: none;
        }
    }
</style>
@endsection

@section('content')
<div class="mx-auto max-w-7xl">
    <div class="flex items-center py-3 px-4">
        <a href="{{ route('admin.projects.index') }}" class="text-gray-600 flex items-center hover:text-gray-900">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Project Details
        </a>
        <div class="ml-auto">
            <button class="p-2 text-gray-600 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
            </button>
            <button class="ml-3 flex items-center text-gray-600 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                AI Assistant
            </button>
            <a href="{{ route('admin.projects.edit', $project->id) }}" class="ml-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded text-sm">
                Edit Project
            </a>
        </div>
    </div>

    <div class="flex flex-col md:flex-row bg-white border border-gray-100 rounded-sm">
        <!-- Left Sidebar -->
        <div class="w-full md:w-64 border-r border-gray-100 flex-shrink-0">
            <!-- PROJECT INFO Section -->
            <div class="p-4 border-b border-gray-100">
                <h3 class="uppercase text-xs font-medium text-gray-500 mb-3">PROJECT INFO</h3>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-xs font-medium">Framework:</p>
                        <p class="text-xs text-gray-600">{{ $project->framework ? $project->framework->name : 'Project Management (PMBOK)' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs font-medium">Current Stage:</p>
                        <p class="text-xs text-gray-600">{{ ucfirst($project->status) ?? 'Initiating' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs font-medium">Status:</p>
                        <p class="text-xs text-green-600">
                            @if(strtolower($project->status) == 'in progress')
                                In Progress
                            @else
                                {{ ucfirst($project->status) }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- TEAM Section -->
            <div class="p-4 border-b border-gray-100">
                <h3 class="uppercase text-xs font-medium text-gray-500 mb-3">TEAM</h3>
                
                <div class="space-y-3">
                    @foreach($teamMembers as $index => $member)
                        @php
                            $initials = strtoupper(substr($member->name, 0, 2));
                            $avatarClass = $index == 0 ? '' : 'green';
                            $role = $index == 0 ? 'Project Lead' : 'Project Member';
                        @endphp
                        <div class="flex items-center">
                            <div class="team-avatar {{ $avatarClass }}">
                                {{ $initials }}
                            </div>
                            <div>
                                <p class="text-xs font-medium">{{ $member->name }}</p>
                                <p class="text-xs text-gray-500">{{ $role }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- DATES Section -->
            <div class="p-4 border-b border-gray-100">
                <h3 class="uppercase text-xs font-medium text-gray-500 mb-3">DATES</h3>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-xs font-medium">Start Date:</p>
                        <p class="text-xs text-gray-600">{{ $project->start_date ? date('M d, Y', strtotime($project->start_date)) : date('M d, Y', strtotime('-2 months')) }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs font-medium">Due Date:</p>
                        <p class="text-xs text-gray-600">{{ $project->end_date ? date('M d, Y', strtotime($project->end_date)) : date('M d, Y', strtotime('+2 months')) }}</p>
                    </div>
                </div>
            </div>
            
            <!-- DOCUMENTS Section -->
            <div class="p-4 border-b border-gray-100">
                <h3 class="uppercase text-xs font-medium text-gray-500 mb-3">DOCUMENTS</h3>
                
                <div class="space-y-2">
                    <div class="flex items-center text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Project Charter v1.pdf</span>
                    </div>
                    
                    <div class="flex items-center text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Requirements Document.docx</span>
                    </div>
                    
                    <div class="text-xs text-gray-500 text-center mt-3">
                        View all 5 documents
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="p-4">
                <button class="w-full flex items-center justify-center px-3 py-2 border border-gray-300 rounded-md text-xs text-gray-700 bg-white hover:bg-gray-50 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Upload File
                </button>
                
                <button class="w-full flex items-center justify-center px-3 py-2 border border-gray-300 rounded-md text-xs text-gray-700 bg-white hover:bg-gray-50 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Export Project
                </button>
                
                <button class="w-full flex items-center justify-center px-3 py-2 bg-blue-600 rounded-md text-xs text-white hover:bg-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                    Share Project
                </button>
            </div>
        </div>  <!-- Cierre del sidebar -->
        
        <!-- Main Content Area -->
        <div class="flex-1 p-6 bg-white">
            <!-- Title and action buttons row -->
            <div class="flex flex-col md:flex-row justify-between mb-6">
                <div>
                    <h1 class="text-xl font-medium text-gray-900 mb-2">{{ $project->title }}</h1>
                    <p class="text-gray-600 text-sm">{{ $project->description }}</p>
                </div>
                
                <div class="flex items-start space-x-3 mt-4 md:mt-0">
                    <button class="flex items-center px-3.5 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition-all duration-200 hover:shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Edit Project
                    </button>
                    
                    <button class="flex items-center px-3.5 py-1.5 bg-gradient-to-r from-blue-600 to-blue-500 rounded-md text-xs font-medium text-white hover:from-blue-700 hover:to-blue-600 shadow-sm transition-all duration-200 hover:shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        AI Assistant
                    </button>
                </div>
            </div>
            
            <div class="flex flex-wrap mt-4 mb-6 gap-5 text-sm text-gray-500">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $daysRemaining }} days remaining</span>
                </div>
                
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>{{ count($teamMembers) }} team members</span>
                </div>
                
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Due {{ $project->end_date ? date('M d, Y', strtotime($project->end_date)) : 'Not set' }}</span>
                </div>
            </div>
            
            <div class="mb-8">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm font-medium text-gray-700">Overall Progress</span>
                    <span class="text-sm font-medium">{{ round($progress) }}%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-value" style="width: {{ $progress }}%"></div>
                </div>
            </div>
            
            <!-- Tabs -->
            <div class="tabs mb-4">
                <a href="#" class="tab active">Milestones & Tasks</a>
                <a href="#" class="tab">Questions</a>
                <a href="#" class="tab">Documents</a>
                <a href="#" class="tab">Activity Log</a>
                <a href="#" class="tab">Project Details</a>
            </div>
            
            <!-- Filters -->
            <div class="mb-6">
                <a href="#" class="filter-btn active mr-2">All</a>
                <a href="#" class="filter-btn mr-2">Pending</a>
                <a href="#" class="filter-btn">Completed</a>
            </div>
            
            <!-- Milestones -->
            <div class="space-y-4">
                @foreach($milestones as $milestone)
                <div class="milestone-item mb-4">
                    <div class="flex justify-between items-center mb-3">
                        <div>
                            <h3 class="text-sm font-medium text-gray-800">{{ $milestone['title'] }}</h3>
                            @php
                                $statusClass = $milestone['progress'] == 100 ? 'bg-green-100 text-green-800' : 
                                              ($milestone['progress'] >= 50 ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800');
                            @endphp
                            <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded-full {{ $statusClass }}">
                                {{ $milestone['progress'] == 100 ? 'Completed' : ($milestone['progress'] >= 50 ? 'In Progress' : 'Planning') }}
                            </span>
                        </div>
                        <div class="flex items-center text-xs text-gray-500 bg-gray-50 px-2 py-1 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Due {{ date('M d, Y', strtotime($milestone['due_date'])) }}</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-grow mr-2">
                            <div class="milestone-progress">
                                <div class="milestone-value" style="width: {{ $milestone['progress'] }}%"></div>
                            </div>
                        </div>
                        <span class="text-xs font-medium bg-gray-50 px-1.5 py-0.5 rounded w-12 text-center">{{ $milestone['progress'] }}%</span>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Add New Milestone Button -->
            <div class="flex justify-center mt-8">
                <button class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add New Milestone
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
