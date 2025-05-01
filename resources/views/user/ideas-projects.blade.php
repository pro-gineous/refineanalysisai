@extends('layouts.dashboard')

@section('content')
<div class="bg-white min-h-screen overflow-x-hidden">
    <div class="max-w-full mx-auto bg-white px-3 sm:px-6 lg:px-8 py-3 sm:py-4 overflow-x-visible">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 sm:mb-6 header-section">
            <div class="flex items-center">
                <div class="mr-2 sm:mr-4 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 md:h-8 sm:w-7 md:w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg sm:text-xl md:text-2xl font-bold text-blue-700">Ideas & Projects</h1>
                    <p class="text-xs sm:text-sm text-blue-500">Manage ideas, projects, and test runs</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 mt-3 sm:mt-0 w-full sm:w-auto">
                <a href="#" class="flex items-center px-2 sm:px-3 md:px-5 py-1.5 sm:py-2 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 text-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-blue-600 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <span class="text-xs sm:text-sm font-medium text-gray-700">Assistant</span>
                </a>
                <button id="createNewBtn" class="flex items-center px-2 sm:px-3 md:px-5 py-1.5 sm:py-2 bg-blue-500 text-white rounded-lg shadow-sm hover:bg-blue-600 text-nowrap transition duration-150 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="text-xs sm:text-sm font-medium">Create New</span>
                </button>
                <a href="#" class="flex items-center justify-center w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 bg-white border border-gray-200 rounded-full shadow-sm hover:bg-gray-50 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- Search and Filter Section -->
        <div class="flex flex-row space-y-0 items-center mb-4 sm:mb-5 w-full">
            <div class="relative flex-grow w-full sm:max-w-sm mr-2">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" class="block w-full pl-8 sm:pl-10 pr-3 py-1.5 sm:py-2 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-xs sm:text-sm" placeholder="Search by name or ID...">
            </div>
            <div class="flex justify-end">
                <button type="button" class="inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 border border-gray-300 rounded-md shadow-sm bg-white hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Tabs -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 sm:mb-5 gap-3">
            <div class="bg-white rounded-full p-1 shadow-sm flex flex-wrap justify-center w-full sm:w-auto overflow-hidden">
                <a href="{{ route('user.ideas-projects', ['filter' => 'all']) }}" class="{{ request()->input('filter', 'all') == 'all' ? 'bg-blue-500 text-white' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }} px-2.5 sm:px-3 md:px-6 py-1 sm:py-1.5 rounded-full text-xs sm:text-sm font-medium whitespace-nowrap flex-shrink-0 text-center w-1/4 sm:w-auto sm:flex-grow-0 m-0.5 sm:m-1 transition-colors duration-200 ease-in-out">All</a>
                <a href="{{ route('user.ideas-projects', ['filter' => 'ideas']) }}" class="{{ request()->input('filter') == 'ideas' ? 'bg-blue-500 text-white' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }} px-2.5 sm:px-3 md:px-6 py-1 sm:py-1.5 rounded-full text-xs sm:text-sm font-medium whitespace-nowrap flex-shrink-0 text-center w-1/4 sm:w-auto sm:flex-grow-0 m-0.5 sm:m-1 transition-colors duration-200 ease-in-out">Ideas</a>
                <a href="{{ route('user.ideas-projects', ['filter' => 'projects']) }}" class="{{ request()->input('filter') == 'projects' ? 'bg-blue-500 text-white' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }} px-2.5 sm:px-3 md:px-6 py-1 sm:py-1.5 rounded-full text-xs sm:text-sm font-medium whitespace-nowrap flex-shrink-0 text-center w-1/4 sm:w-auto sm:flex-grow-0 m-0.5 sm:m-1 transition-colors duration-200 ease-in-out">Projects</a>
                <a href="{{ route('user.ideas-projects', ['filter' => 'run']) }}" class="{{ request()->input('filter') == 'run' ? 'bg-blue-500 text-white' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }} px-2.5 sm:px-3 md:px-6 py-1 sm:py-1.5 rounded-full text-xs sm:text-sm font-medium whitespace-nowrap flex-shrink-0 text-center w-1/4 sm:w-auto sm:flex-grow-0 m-0.5 sm:m-1 transition-colors duration-200 ease-in-out">Run</a>
            </div>
            <!-- Icono M eliminado -->
        </div>

    <!-- Table Layout - Shown only on tablets and larger screens -->    
    <div class="bg-white rounded-lg shadow-sm overflow-hidden hidden sm:block mx-auto">
        <div class="responsive-table-container rounded-xl relative" style="max-height: 460px; position: relative; -webkit-overflow-scrolling: touch; max-width: 1100px; margin-left: auto; margin-right: auto; border-radius: 12px;">
            <!-- Scroll left button -->
            <button class="table-scroll-btn btn-left" id="scrollLeftBtn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
            
            <!-- Scroll right button -->
            <button class="table-scroll-btn btn-right" id="scrollRightBtn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
        <table class="divide-y divide-gray-100 border-collapse table-auto w-full table-enhanced" style="width: max-content; min-width: 100%;">
        <colgroup>
            <col class="bg-gray-50" style="width: 60px;"> <!-- ID column -->
            <col style="width: 180px;"> <!-- Index Name -->
            <col style="width: 120px;"> <!-- Submitter -->
            <col style="width: 120px;"> <!-- Framework -->
            <col style="width: 100px;"> <!-- Status -->
            <col style="width: 100px;"> <!-- Priority -->
            <!-- These columns will be visible by scrolling -->
            <col span="4" class="bg-gray-50" style="width: 120px;"> <!-- Timeline columns group -->
            <col style="width: 100px;"> <!-- Progress -->
            <col span="5" class="bg-blue-50" style="width: 120px;"> <!-- Financial columns group -->
            <col span="2" class="bg-gray-50" style="width: 120px;"> <!-- Approval columns group -->
            <col span="5" style="width: 150px;"> <!-- Additional info columns group -->
        </colgroup>

            <thead class="sticky top-0 bg-white z-10">
                <!-- Optional: Column group headers -->
                <tr class="bg-gray-100">
                    <th colspan="6" class="px-2 py-1 text-xs font-medium text-gray-700 text-center border-b border-gray-200">Core Information</th>
                    <th colspan="4" class="px-2 py-1 text-xs font-medium text-gray-700 text-center border-b border-gray-200 bg-gray-50">Timeline</th>
                    <th colspan="1" class="px-2 py-1 text-xs font-medium text-gray-700 text-center border-b border-gray-200">Progress</th>
                    <th colspan="5" class="px-2 py-1 text-xs font-medium text-blue-700 text-center border-b border-gray-200 bg-blue-50">Financial</th>
                    <th colspan="2" class="px-2 py-1 text-xs font-medium text-gray-700 text-center border-b border-gray-200 bg-gray-50">Approval</th>
                    <th colspan="5" class="px-2 py-1 text-xs font-medium text-gray-700 text-center border-b border-gray-200">Additional Information</th>
                </tr>
                <tr class="bg-gradient-to-r from-blue-600 to-blue-500 text-white">
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-10 md:w-12 lg:w-16 sticky left-0 bg-blue-600 shadow-sm">ID</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[120px]">Index Name</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[100px]">Submitter</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[120px]">Framework</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[80px]">Status</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[80px]">Priority</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[100px] bg-blue-500">Assigned To</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[100px] bg-blue-500">Submit<br>Date</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[100px] bg-blue-500">Due Date</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-16 bg-blue-500">Aging</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-16 sm:w-20">Progress (%)</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[90px] bg-blue-500">Effort<br>Estimate</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[90px] bg-blue-500">Cost<br>Estimate</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[90px] bg-blue-500">Potential<br>ROI</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-16 bg-blue-500">ROI (%)</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[80px] bg-blue-500">Risk<br>Level</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[100px] bg-blue-500">Approval<br>Status</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[100px] bg-blue-500">Decision<br>Date</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[150px]">Comments/<br>Notes</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[100px]">Last<br>Updated</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[120px]">Success<br>Metrics</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[120px]">Dependencies</th>
                    <th scope="col" class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-auto min-w-[150px]">Stakeholder<br>Feedback</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @if(!empty($combinedItems) && count($combinedItems) > 0)
                    @foreach($combinedItems as $index => $item)
                    <tr class="hover:bg-blue-50 transition-colors duration-150 table-row-enhanced" data-status="{{ $item['status'] }}" data-type="{{ $item['type'] }}">
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap sticky left-0 bg-white border-r border-gray-100 shadow-sm">
                            <div class="text-xs sm:text-sm text-blue-500 font-medium">{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            <div class="text-xs sm:text-sm font-medium">{{ $item['name'] }}</div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-7 w-7 rounded-full bg-blue-100 flex items-center justify-center text-xs font-medium text-blue-600">{{ $item['submitter']['initials'] ?? 'NA' }}</div>
                                <div class="ml-2">
                                    <div class="text-xs sm:text-sm">{{ $item['submitter']['name'] ?? 'Unknown' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            <div class="text-xs sm:text-sm">{{ $item['framework'] ?? 'N/A' }}</div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            @if($item['status'] == 'completed')
                                <span class="status-badge status-badge-success">Completed</span>
                            @elseif($item['status'] == 'in_progress')
                                <span class="status-badge status-badge-primary">In Progress</span>
                            @elseif($item['status'] == 'review')
                                <span class="status-badge status-badge-review">In Review</span>
                            @elseif($item['status'] == 'planning')
                                <span class="status-badge status-badge-info">Planning</span>
                            @else
                                <span class="status-badge status-badge-secondary">{{ ucfirst($item['status']) }}</span>
                            @endif
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            @if($item['priority'] == 'high')
                                <span class="priority-indicator priority-high font-medium text-xs sm:text-sm">High</span>
                            @elseif($item['priority'] == 'medium')
                                <span class="priority-indicator priority-medium font-medium text-xs sm:text-sm">Medium</span>
                            @elseif($item['priority'] == 'low')
                                <span class="priority-indicator priority-low font-medium text-xs sm:text-sm">Low</span>
                            @else
                                <span class="priority-indicator priority-medium font-medium text-xs sm:text-sm">{{ ucfirst($item['priority'] ?? 'Medium') }}</span>
                            @endif
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            @if(!empty($item['assigned_to']))
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-7 w-7 rounded-full bg-green-100 flex items-center justify-center text-xs font-medium text-green-600">{{ $item['assigned_to']['initials'] ?? 'NA' }}</div>
                                <div class="ml-2">
                                    <div class="text-xs sm:text-sm">{{ $item['assigned_to']['name'] ?? 'Not Assigned' }}</div>
                                </div>
                            </div>
                            @else
                            <div class="text-xs sm:text-sm text-gray-400">Not Assigned</div>
                            @endif
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            <div class="text-xs sm:text-sm">{{ $item['submit_date'] ?? 'N/A' }}</div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            <div class="text-xs sm:text-sm">{{ $item['due_date'] ?? 'N/A' }}</div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            <div class="text-xs sm:text-sm">{{ $item['aging'] ?? '0' }}</div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            <div class="w-full bg-gray-200 rounded-full h-1.5 mb-1">
                                <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $item['progress'] ?? 0 }}%"></div>
                            </div>
                            <div class="text-xs text-right text-gray-500">{{ $item['progress'] ?? 0 }}%</div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            <div class="text-xs sm:text-sm">{{ $item['effort_estimate'] ? $item['effort_estimate'].' hrs' : 'N/A' }}</div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            <div class="text-xs sm:text-sm">{{ $item['cost_estimate'] ? '$'.number_format($item['cost_estimate']) : 'N/A' }}</div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            <div class="text-xs sm:text-sm">{{ $item['potential_roi'] ? '$'.number_format($item['potential_roi']) : 'N/A' }}</div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            @if(isset($item['roi_percentage']))
                                <div class="text-xs sm:text-sm {{ $item['roi_percentage'] > 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                                    {{ $item['roi_percentage'] > 0 ? '+' : '' }}{{ $item['roi_percentage'] }}%
                                </div>
                            @else
                                <div class="text-xs sm:text-sm text-gray-400">N/A</div>
                            @endif
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            <div class="text-xs sm:text-sm">{{ $item['risk_level'] ?? 'N/A' }}</div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            @if($item['approval_status'] == 'approved')
                                <span class="status-badge status-badge-success">Approved</span>
                            @elseif($item['approval_status'] == 'pending')
                                <span class="status-badge status-badge-review">Pending</span>
                            @elseif($item['approval_status'] == 'rejected')
                                <span class="status-badge status-badge-danger">Rejected</span>
                            @else
                                <span class="status-badge status-badge-secondary">{{ ucfirst($item['approval_status'] ?? 'N/A') }}</span>
                            @endif
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            <div class="text-xs sm:text-sm">{{ $item['decision_date'] ?? 'N/A' }}</div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4">
                            <div class="text-xs sm:text-sm line-clamp-2">{{ $item['comments'] ?? 'No comments' }}</div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                            <div class="text-xs sm:text-sm">{{ $item['last_updated'] ?? 'N/A' }}</div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4">
                            <div class="text-xs sm:text-sm line-clamp-2">{{ $item['success_metrics'] ?? 'N/A' }}</div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4">
                            <div class="text-xs sm:text-sm line-clamp-2">{{ $item['dependencies'] ?? 'N/A' }}</div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-4">
                            <div class="text-xs sm:text-sm line-clamp-2">{{ $item['stakeholder_feedback'] ?? 'No feedback yet' }}</div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="23" class="px-6 py-4 text-center text-gray-500">
                            No ideas or projects to display
                        </td>
                    </tr>
                @endif

            </tbody>
        </table>
        </div>
    </div>
    
    <!-- Mobile Card Layout - Shown only on mobile screens -->
    <div class="sm:hidden space-y-3 mt-3 px-1">
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-sm font-medium text-gray-700">Showing {{ count($combinedItems) }} items</h3>
            <div class="flex space-x-2">
                <button class="p-1.5 bg-white border border-gray-200 rounded-md shadow-sm text-gray-700 flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="text-xs">New</span>
                </button>
            </div>
        </div>
        
        @if(count($combinedItems) > 0)
            @foreach($combinedItems as $item)
                <div class="bg-white rounded-md shadow-sm p-3 border-l-4 border-{{$item['type'] == 'project' ? 'blue' : 'purple'}}-500 relative">
                    <div class="flex justify-between items-start">
                        <div class="mr-8">
                            <span class="inline-block {{$item['type'] == 'project' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'}} px-1.5 py-0.5 rounded-md text-xs font-medium">{{ucfirst($item['type'])}}</span>
                            <h3 class="font-medium text-sm mt-1 line-clamp-2">{{$item['name']}}</h3>
                        </div>
                        <div class="status-badge status-{{$item['status']}}">{{ucfirst(str_replace('_', ' ', $item['status']))}}</div>
                    </div>
                    
                    <div class="mt-3 grid grid-cols-2 gap-y-2 gap-x-3 text-xs">
                        <div class="flex flex-col">
                            <span class="text-gray-500 mb-0.5">Submitter</span>
                            <span class="font-medium truncate">{{ $item['submitter']['name'] ?? 'Unknown' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-gray-500 mb-0.5">Assigned To</span>
                            <span class="font-medium truncate">{{ $item['assigned_to']['name'] ?? 'Not Assigned' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-gray-500 mb-0.5">Due Date</span>
                            <span class="font-medium">{{ $item['due_date'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-gray-500 mb-0.5">Priority</span>
                            @if($item['priority'] == 'high')
                                <span class="priority-indicator priority-high font-medium">High</span>
                            @elseif($item['priority'] == 'medium')
                                <span class="priority-indicator priority-medium font-medium">Medium</span>
                            @elseif($item['priority'] == 'low')
                                <span class="priority-indicator priority-low font-medium">Low</span>
                            @else
                                <span class="priority-indicator priority-medium font-medium">{{ ucfirst($item['priority'] ?? 'Medium') }}</span>
                            @endif
                        </div>
                        <div class="flex flex-col">
                            <span class="text-gray-500 mb-0.5">Framework</span>
                            <span class="font-medium truncate">{{ $item['framework'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-gray-500 mb-0.5">Risk Level</span>
                            <span class="font-medium truncate">{{ $item['risk_level'] ?? 'N/A' }}</span>
                        </div>
                        <div class="col-span-2 mt-1">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-gray-500">Progress</span>
                                <span class="text-xs font-medium">{{ $item['progress'] ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $item['progress'] ?? 0 }}%"></div>
                            </div>
                        </div>
                        <div class="flex flex-col col-span-2 mt-1 pt-1 border-t border-gray-100">
                            <span class="text-gray-500 mb-0.5">ROI</span>
                            <div class="flex items-center">
                                <span class="font-medium mr-2">{{ $item['potential_roi'] ? '$'.number_format($item['potential_roi']) : 'N/A' }}</span>
                                @if(isset($item['roi_percentage']))
                                    <span class="text-green-600 text-xs font-semibold">{{ $item['roi_percentage'] > 0 ? '+' : '' }}{{ $item['roi_percentage'] }}%</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <button class="absolute top-0 right-0 mt-1 mr-1 text-gray-400 hover:text-gray-600" aria-label="More options">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                        </svg>
                    </button>
                </div>
            @endforeach
        @else
            <div class="bg-white rounded-md shadow-sm p-3 border-l-4 border-gray-500 relative">
                <div class="flex justify-between items-start">
                    <div class="mr-2">
                        <span class="inline-block bg-blue-100 text-blue-800 px-1.5 py-0.5 rounded-md text-xs font-medium">No Data</span>
                        <h3 class="font-medium text-sm mt-1 line-clamp-2">No ideas or projects to display</h3>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    <style>
        .responsive-table-container {
            -webkit-overflow-scrolling: touch;
            position: relative;
            scrollbar-width: thin;
            scrollbar-color: rgba(156, 163, 175, 0.5) rgba(229, 231, 235, 0.5);
            z-index: 1;
        }
        
        /* Enhanced table styling */
        .table-enhanced th, .table-enhanced td {
            padding: 0.5rem 0.75rem;
            font-size: 0.8125rem;
        }
        
        /* Set fixed width for the table container to maximum 800px and center it with rounded corners */
        .responsive-table-container {
            width: 100%;
            max-width: 800px !important;
            margin-left: auto;
            margin-right: auto;
            border-radius: 12px;
            overflow-x: auto;
            overflow-y: auto;
            position: relative;
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 0, 0, 0.2) rgba(0, 0, 0, 0.05);
            /* Ensure smooth scrolling behavior */
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }
        
        /* For WebKit browsers (Chrome, Safari) */
        .responsive-table-container::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }
        
        .responsive-table-container::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 4px;
        }
        
        .responsive-table-container::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 4px;
        }
        
        /* Scroll buttons styling */
        .table-scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            background-color: rgba(255,255,255,0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
            cursor: pointer;
            z-index: 20;
            border: none;
            transition: all 0.2s ease;
        }
        
        .table-scroll-btn:hover {
            background-color: #f3f4f6;
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
        }
        
        .table-scroll-btn.btn-left {
            left: 10px;
        }
        
        .table-scroll-btn.btn-right {
            right: 10px;
        }
        
        .table-scroll-btn svg {
            width: 16px;
            height: 16px;
            fill: #4b5563;
        }
        
        .table-enhanced thead th {
            font-weight: 600;
            letter-spacing: 0.03em;
        }
        
        .table-row-enhanced:hover td {
            background-color: rgba(59, 130, 246, 0.05);
        }
        
        .table-row-enhanced:hover td:first-child {
            background-color: rgba(59, 130, 246, 0.1);
        }
        
        /* Custom scrollbar */
        .responsive-table-container::-webkit-scrollbar-track {
            background-color: #F1F5F9;
            border-radius: 10px;
        }
        
        .responsive-table-container::-webkit-scrollbar-thumb {
            background-color: #94A3B8;
            border-radius: 10px;
            border: 2px solid #F1F5F9;
        }
        
        /* Status badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            white-space: nowrap;
        }
        
        .status-badge-completed {
            background-color: #DCFCE7;
            color: #166534;
        }
        
        .status-badge-inprogress {
            background-color: #FEF3C7;
            color: #92400E;
        }
        
        .status-badge-review {
            background-color: #DBEAFE;
            color: #1E40AF;
        }
        
        .status-badge-onhold {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        
        /* Priority indicators */
        .priority-indicator {
            display: inline-flex;
            align-items: center;
        }
        
        .priority-indicator:before {
            content: '';
            display: block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 6px;
        }
        
        .priority-high:before {
            background-color: #EF4444;
        }
        
        .priority-medium:before {
            background-color: #F59E0B;
        }
        
        .priority-low:before {
            background-color: #10B981;
        }
        
        /* Better touch areas for mobile */
        @media (max-width: 640px) {
            button, a {
                min-height: 40px;
                min-width: 40px;
            }
            
            input[type="text"] {
                min-height: 40px;
            }
            
            .sm\:hidden .bg-white {
                margin-bottom: 16px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.1);
            }
        }
        
        /* Horizontal scrollbar styling */
        .responsive-table-container::-webkit-scrollbar {
            width: 10px;
            height: 10px;
            background-color: #f1f1f1;
            border-radius: 5px;
        }
        
        .responsive-table-container::-webkit-scrollbar-thumb {
            background-color: #c1c1c1;
            border-radius: 5px;
            border: 2px solid #f1f1f1;
        }
        
        .responsive-table-container::-webkit-scrollbar-thumb:hover {
            background-color: #a8a8a8;
        }
        
        .responsive-table-container::-webkit-scrollbar-corner {
            background-color: #f1f1f1;
        }
        
        /* Visual indicators for horizontal scrolling */
        .responsive-table-container::before,
        .responsive-table-container::after {
            content: '';
            position: absolute;
            top: 0;
            height: 100%;
            width: 15px;
            pointer-events: none;
            z-index: 5;
        }
        
        .responsive-table-container::before {
            left: 0;
            background: linear-gradient(to left, rgba(255,255,255,0), rgba(255,255,255,0.8));
        }
        
        .responsive-table-container::after {
            right: 0;
            background: linear-gradient(to right, rgba(255,255,255,0), rgba(255,255,255,0.8));
        }
        
        /* Screen size-specific table heights and widths */
        @media (min-width: 1280px) {
            .responsive-table-container {
                height: 550px;
            }
        }
        
        @media (min-width: 1025px) and (max-width: 1279px) {
            .responsive-table-container {
                height: 500px;
            }
        }
        
        @media (min-width: 768px) and (max-width: 1024px) {
            .responsive-table-container {
                max-height: 460px;
            }
            .responsive-table-container table {
                width: 100%;
                min-width: 900px;
            }
        }
        
        @media (min-width: 640px) and (max-width: 767px) {
            .responsive-table-container {
                max-height: 420px;
            }
            .responsive-table-container table {
                width: 100%;
                min-width: 900px;
            }
        }
        
        /* Responsive adjustments for very small screens */
        @media (max-width: 640px) {
            .header-section {
                flex-direction: column;
                align-items: flex-start;
            }
            .header-section > div:last-child {
                margin-top: 0.75rem;
                width: 100%;
                display: flex;
                justify-content: space-between;
                gap: 0.5rem;
            }
            .header-section > div:last-child a {
                flex: 1;
                min-width: 0;
                overflow: hidden;
            }
            .header-section > div:last-child a span {
                display: block;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .responsive-table-container {
                max-height: 350px;
            }
            
            /* Better fit for mobile UI */
            .px-3 {
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
            }
        }
        
        @media (max-width: 480px) {
            .responsive-table-container {
                max-height: 300px;
            }
            td, th {
                padding-left: 0.375rem !important;
                padding-right: 0.375rem !important;
                font-size: 0.7rem !important;
            }
            td .text-sm {
                font-size: 0.7rem !important;
                line-height: 1rem !important;
            }
        }
        
        /* Better mobile support */
        @media (max-width: 480px) {
            .responsive-table-container::before,
            .responsive-table-container::after {
                width: 25px;
            }
            .scroll-hint {
                font-size: 10px !important;
                padding: 4px 8px !important;
                bottom: 5px !important;
                right: 5px !important;
            }
            
            /* Responsive table adjustments */
            .responsive-table-container {
                width: 100%;
                overflow-x: scroll;
                -webkit-overflow-scrolling: touch;
            }
            
            /* Mobile optimizations */
            @media (max-width: 640px) {
                .max-w-full {
                    padding-left: 8px !important;
                    padding-right: 8px !important;
                }
                
                body {
                    touch-action: manipulation;
                }
            }
        }
        
        /* Prevent horizontal scroll on entire page */
        body, html {
            overflow-x: hidden;
            max-width: 100%;
            -webkit-tap-highlight-color: transparent;
        }
        
        /* Better touch experience */
        a, button {
            -webkit-tap-highlight-color: rgba(0,0,0,0);
            touch-action: manipulation;
        }
    </style>
    
    <script>
        // Add viewport meta tag for proper mobile support
        if (!document.querySelector('meta[name="viewport"]')) {
            const meta = document.createElement('meta');
            meta.name = 'viewport';
            meta.content = 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no';
            document.head.appendChild(meta);
        }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Get table container for both scroll indicators and smooth scrolling
        const tableContainer = document.querySelector('.responsive-table-container');
        
        if (tableContainer) {
            // Scroll buttons functionality
            const scrollLeftBtn = document.getElementById('scrollLeftBtn');
            const scrollRightBtn = document.getElementById('scrollRightBtn');
            
            if (scrollLeftBtn && scrollRightBtn) {
                scrollLeftBtn.addEventListener('click', function() {
                    tableContainer.scrollBy({ left: -200, behavior: 'smooth' });
                });
                
                scrollRightBtn.addEventListener('click', function() {
                    tableContainer.scrollBy({ left: 200, behavior: 'smooth' });
                });
            }
            
            // Add smooth scrolling for the table on all devices
            // Add visual hint for scrollable table
            const hint = document.createElement('div');
            hint.classList.add('scroll-hint');
            hint.style.position = 'absolute';
            hint.style.bottom = '10px';
            hint.style.right = '10px';
            hint.style.background = 'rgba(0,0,0,0.6)';
            hint.style.color = 'white';
            hint.style.padding = '5px 10px';
            hint.style.borderRadius = '4px';
            hint.style.fontSize = '12px';
            hint.style.opacity = '0.9';
            hint.style.transition = 'opacity 0.3s';
            hint.style.zIndex = '20';
            hint.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
            
            hint.innerText = 'ꜛꜜ Scroll to view table ꜛꜜ';
            
            tableContainer.style.position = 'relative';
            tableContainer.appendChild(hint);
            
            // Hide hint after scrolling or after 5 seconds
            setTimeout(() => {
                hint.style.opacity = '0';
                setTimeout(() => hint.remove(), 300);
            }, 5000);
            
            tableContainer.addEventListener('scroll', () => {
                hint.style.opacity = '0';
                setTimeout(() => hint.remove(), 300);
            }, {once: true});
            
            // Add alternate row styling for better readability with scroll
            const rows = tableContainer.querySelectorAll('tbody tr:nth-child(even)');
            rows.forEach(row => {
                row.classList.add('bg-gray-50');
            });
            
            // Create and add left-right arrow indicators for horizontal scrolling
            const arrowIndicators = document.createElement('div');
            arrowIndicators.classList.add('scroll-arrows');
            arrowIndicators.style.position = 'absolute';
            arrowIndicators.style.top = '50%';
            arrowIndicators.style.left = '0';
            arrowIndicators.style.right = '0';
            arrowIndicators.style.display = 'flex';
            arrowIndicators.style.justifyContent = 'space-between';
            arrowIndicators.style.pointerEvents = 'none';
            arrowIndicators.style.zIndex = '10';
            arrowIndicators.style.transform = 'translateY(-50%)';
            
            const leftArrow = document.createElement('div');
            leftArrow.style.background = 'rgba(0,0,0,0.4)';
            leftArrow.style.color = 'white';
            leftArrow.style.padding = '8px 12px';
            leftArrow.style.borderRadius = '0 4px 4px 0';
            leftArrow.style.fontSize = '18px';
            leftArrow.innerHTML = '←';
            
            const rightArrow = document.createElement('div');
            rightArrow.style.background = 'rgba(0,0,0,0.4)';
            rightArrow.style.color = 'white';
            rightArrow.style.padding = '8px 12px';
            rightArrow.style.borderRadius = '4px 0 0 4px';
            rightArrow.style.fontSize = '18px';
            rightArrow.innerHTML = '→';
            
            arrowIndicators.appendChild(leftArrow);
            arrowIndicators.appendChild(rightArrow);
            tableContainer.appendChild(arrowIndicators);
            
            // Hide arrows after 5 seconds or on scroll
            setTimeout(() => {
                arrowIndicators.style.opacity = '0';
                setTimeout(() => arrowIndicators.remove(), 300);
            }, 5000);
            
            tableContainer.addEventListener('scroll', () => {
                arrowIndicators.style.opacity = '0';
                setTimeout(() => arrowIndicators.remove(), 300);
            }, {once: true});
        }
    });
    </script>

    <!-- Create New Modal -->
    <div id="createNewModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div id="modalBackdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            
            <!-- Center modal content -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Create New
                            </h3>
                            <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <!-- Project Option -->
                                <div id="createProjectBtn" class="group relative cursor-pointer bg-white rounded-lg border border-gray-200 shadow-sm p-5 hover:border-blue-500 hover:shadow-md transition-all">
                                    <div class="flex flex-col items-center">
                                        <div class="h-12 w-12 bg-blue-100 text-blue-800 rounded-full flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-900 mb-1 group-hover:text-blue-600 transition-colors">Project</h4>
                                        <p class="text-sm text-gray-500 text-center">Create a new structured project with tasks and milestones</p>
                                    </div>
                                </div>
                                
                                <!-- Idea Option -->
                                <div id="createIdeaBtn" class="group relative cursor-pointer bg-white rounded-lg border border-gray-200 shadow-sm p-5 hover:border-purple-500 hover:shadow-md transition-all">
                                    <div class="flex flex-col items-center">
                                        <div class="h-12 w-12 bg-purple-100 text-purple-800 rounded-full flex items-center justify-center mb-4 group-hover:bg-purple-200 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-900 mb-1 group-hover:text-purple-600 transition-colors">Idea</h4>
                                        <p class="text-sm text-gray-500 text-center">Capture a new idea or concept for future evaluation</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button id="closeModalBtn" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const createNewBtn = document.getElementById('createNewBtn');
            const createNewModal = document.getElementById('createNewModal');
            const modalBackdrop = document.getElementById('modalBackdrop');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const createProjectBtn = document.getElementById('createProjectBtn');
            const createIdeaBtn = document.getElementById('createIdeaBtn');

            if (createNewBtn && createNewModal) {
                // Open modal
                createNewBtn.addEventListener('click', function() {
                    createNewModal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden'); // Prevent background scrolling
                });

                // Close modal
                function closeModal() {
                    createNewModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }

                if (closeModalBtn) {
                    closeModalBtn.addEventListener('click', closeModal);
                }

                if (modalBackdrop) {
                    modalBackdrop.addEventListener('click', closeModal);
                }

                // Modal option clicks
                if (createProjectBtn) {
                    createProjectBtn.addEventListener('click', function() {
                        window.location.href = '{{ route("user.projects.create") }}';
                    });
                }

                if (createIdeaBtn) {
                    createIdeaBtn.addEventListener('click', function() {
                        window.location.href = '{{ route("user.ideas.create") }}';
                    });
                }
            }
        });
    </script>
</div>
@endsection
