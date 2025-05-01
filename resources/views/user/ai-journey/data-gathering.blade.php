@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Enhanced Header with Journey Information -->
    <div class="bg-white shadow-sm">
        <div class="container mx-auto p-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div class="flex items-center space-x-3 mb-3 md:mb-0">
                    <a href="{{ route('user.ideas-projects') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-800">AI {{ isset($journeyType) && $journeyType == 'idea' ? 'Idea' : 'Project' }} Journey</h1>
                        <p class="text-sm text-gray-500">Let AI guide you through developing your {{ isset($journeyType) && $journeyType == 'idea' ? 'idea' : 'project' }}</p>
                    </div>
                </div>
                
                <!-- Journey Progress --> 
                <div class="flex items-center w-full md:w-1/3">
                    <span class="text-xs text-gray-500 mr-2 whitespace-nowrap">Progress</span>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div id="journey-progress" class="bg-blue-600 h-2.5 rounded-full transition-all duration-700" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modern Chat Interface with Sidebar -->
    <div class="container mx-auto py-8 px-4">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Sidebar for Context and Files -->
            <div class="w-full lg:w-1/4">
                <!-- Framework Selector -->
                <div class="bg-white rounded-lg shadow-sm p-5 mb-6 border-t-4 border-blue-600">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Framework Selection</h3>
                    <select id="framework-selector" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                        <option value="" selected disabled>Select a framework</option>
                        <optgroup label="Project Frameworks">
                            <option value="prince2" data-type="project">PRINCE2</option>
                            <option value="six-sigma" data-type="project">Six Sigma</option>
                            <option value="scrum" data-type="project">Scrum</option>
                            <option value="lean-startup" data-type="project">Lean Startup</option>
                            <option value="togaf" data-type="project">TOGAF</option>
                            <option value="itil" data-type="project">ITIL</option>
                        </optgroup>
                        <optgroup label="Idea Frameworks">
                            <option value="idea-management" data-type="idea">Idea Management Framework</option>
                        </optgroup>
                        <optgroup label="Test Frameworks">
                            <option value="functional-test" data-type="test">Functional Testing</option>
                            <option value="usability-test" data-type="test">Usability Testing</option>
                            <option value="performance-test" data-type="test">Performance Testing</option>
                        </optgroup>
                    </select>
                </div>

                <!-- Journey Overview -->
                <div class="bg-white rounded-lg shadow-sm p-5 mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Journey Overview</h3>
                    <div class="text-sm text-gray-600 space-y-4">
                        <div>
                            <span class="font-medium block text-gray-700">Type:</span>
                            <span class="capitalize">{{ $journeyType ?? 'project' }}</span>
                        </div>
                        <div>
                            <span class="font-medium block text-gray-700">Framework:</span>
                            <span id="selected-framework">Not selected</span>
                        </div>
                        <div>
                            <span class="font-medium block text-gray-700">Started:</span>
                            <span>{{ now()->format('M j, Y g:ia') }}</span>
                        </div>
                        <div>
                            <span class="font-medium block text-gray-700">Current Stage:</span>
                            <span id="journey-stage" class="font-medium text-blue-600">Data Gathering</span>
                        </div>
                    </div>
                </div>
                
                @if(isset($files) && count($files) > 0)
                <!-- Uploaded Files Panel -->
                <div class="bg-white rounded-lg shadow-sm p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-medium text-gray-800">Documents</h3>
                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{ count($files) }} files</span>
                    </div>
                    
                    <div class="space-y-3 max-h-60 overflow-y-auto">
                        @foreach($files as $file)
                        <div class="flex items-center p-2 hover:bg-gray-50 rounded-md transition">
                            @if(strpos($file['type'], 'image/') === 0)
                            <div class="w-10 h-10 bg-indigo-100 rounded-md flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @elseif(strpos($file['type'], 'application/pdf') === 0)
                            <div class="w-10 h-10 bg-red-100 rounded-md flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @elseif(strpos($file['name'], '.doc') !== false)
                            <div class="w-10 h-10 bg-blue-100 rounded-md flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @elseif(strpos($file['name'], '.xls') !== false)
                            <div class="w-10 h-10 bg-green-100 rounded-md flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @else
                            <div class="w-10 h-10 bg-gray-100 rounded-md flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $file['name'] }}</p>
                                <p class="text-xs text-gray-500">{{ round($file['size']/1024, 1) }} KB</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-4">These files are analyzed to enhance your AI journey experience.</p>
                </div>
                @endif
                
                <!-- SME Integration Panel -->
                <div class="bg-white rounded-lg shadow-sm p-5 mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-medium text-gray-800">Expert Collaboration</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            <span class="w-1.5 h-1.5 mr-1 bg-purple-500 rounded-full"></span>New Feature
                        </span>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-3">Assign questions to subject matter experts for input:</p>
                        <div id="pending-questions" class="space-y-2 max-h-32 overflow-y-auto mb-3 text-sm">
                            <div class="hidden pending-question-template bg-gray-50 p-3 rounded-md">
                                <p class="font-medium text-gray-800 mb-1 question-text">Sample question that needs expert input?</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Waiting for answer</span>
                                    <button class="assign-sme-btn text-xs text-white bg-purple-600 hover:bg-purple-700 rounded px-2 py-1">Assign Expert</button>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500 italic">No pending questions currently</div>
                        </div>
                        
                        <!-- SME Assignment Modal (Hidden by default) -->
                        <div id="sme-assignment-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                            <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Assign Expert</h3>
                                <p id="modal-question" class="text-gray-700 mb-4">Question text will appear here</p>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Expert:</label>
                                    <select id="sme-select" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                                        <option value="project-manager">Project Manager</option>
                                        <option value="technical-lead">Technical Lead</option>
                                        <option value="business-analyst">Business Analyst</option>
                                        <option value="stakeholder">Key Stakeholder</option>
                                        <option value="custom">Custom (Enter Email)</option>
                                    </select>
                                </div>
                                
                                <div id="custom-email-field" class="mb-4 hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Expert Email:</label>
                                    <input type="email" id="sme-email" placeholder="example@company.com" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                                </div>
                                
                                <div class="flex justify-end space-x-3">
                                    <button id="cancel-assignment" class="text-gray-700 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm px-4 py-2">Cancel</button>
                                    <button id="confirm-assignment" class="text-white bg-purple-600 hover:bg-purple-700 font-medium rounded-lg text-sm px-4 py-2">Assign</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Deliverable Preview Panel -->
                <div class="bg-white rounded-lg shadow-sm p-5 mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Deliverable Preview</h3>
                    <div id="deliverable-content" class="text-sm text-gray-600">
                        <div class="framework-specific-content hidden" id="prince2-content">
                            <p class="mb-2">Your PRINCE2 project will include:</p>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-gray-300 rounded-full mr-2 flex-shrink-0"></span>
                                    <span class="flex-grow">Project Initiation Documentation</span>
                                    <span class="text-xs text-gray-400">0%</span>
                                </li>
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-gray-300 rounded-full mr-2 flex-shrink-0"></span>
                                    <span class="flex-grow">Governance Plan</span>
                                    <span class="text-xs text-gray-400">0%</span>
                                </li>
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-gray-300 rounded-full mr-2 flex-shrink-0"></span>
                                    <span class="flex-grow">Stakeholder Presentation</span>
                                    <span class="text-xs text-gray-400">0%</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="framework-specific-content hidden" id="idea-management-content">
                            <p class="mb-2">Your Idea Management deliverables:</p>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-gray-300 rounded-full mr-2 flex-shrink-0"></span>
                                    <span class="flex-grow">Idea Validation Report</span>
                                    <span class="text-xs text-gray-400">0%</span>
                                </li>
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-gray-300 rounded-full mr-2 flex-shrink-0"></span>
                                    <span class="flex-grow">Stakeholder Pitch Deck</span>
                                    <span class="text-xs text-gray-400">0%</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="framework-specific-content hidden" id="functional-test-content">
                            <p class="mb-2">Your Functional Test deliverables:</p>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-gray-300 rounded-full mr-2 flex-shrink-0"></span>
                                    <span class="flex-grow">Test Plan</span>
                                    <span class="text-xs text-gray-400">0%</span>
                                </li>
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-gray-300 rounded-full mr-2 flex-shrink-0"></span>
                                    <span class="flex-grow">Test Results Report</span>
                                    <span class="text-xs text-gray-400">0%</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div id="no-framework-selected" class="text-sm text-gray-500 italic">
                            Select a framework above to see deliverables
                        </div>
                        
                        <div class="mt-4 hidden" id="partial-download-section">
                            <button id="download-partial" class="w-full text-sm text-blue-700 bg-blue-50 hover:bg-blue-100 font-medium rounded-lg px-3 py-2 text-center inline-flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download In-Progress Deliverables
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Process Visualization Panel -->
                <div class="bg-white rounded-lg shadow-sm p-5 mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-medium text-gray-800">Process Visualization</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <span class="w-1.5 h-1.5 mr-1 bg-green-500 rounded-full"></span>Premium
                        </span>
                    </div>
                    
                    <div id="visualization-area" class="mb-4 p-4 bg-gray-50 rounded-lg h-48 flex items-center justify-center">
                        <div id="visualization-placeholder" class="text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                            <p class="text-sm text-gray-500">Process visualization will appear here</p>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <button id="generate-process-map" class="w-full text-sm text-green-700 bg-green-50 hover:bg-green-100 font-medium rounded-lg px-3 py-2 text-center inline-flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Generate Process Map
                        </button>
                        <button id="generate-data-model" class="w-full text-sm text-green-700 bg-green-50 hover:bg-green-100 font-medium rounded-lg px-3 py-2 text-center inline-flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3z"></path></svg>
                            Generate Data Model
                        </button>
                    </div>
                </div>
                
                <!-- Quick Tips and Hints -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-5 mt-6 border border-blue-100">
                    <h3 class="text-sm font-medium text-blue-700 mb-2">Tips for Best Results</h3>
                    <ul class="text-xs text-blue-800 space-y-2">
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-blue-500 mr-1 mt-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            Be specific about your goals and requirements
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-blue-500 mr-1 mt-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            Ask for clarification if you don't understand
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-blue-500 mr-1 mt-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            Provide feedback to improve the AI's suggestions
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Chat Area -->
            <div class="w-full lg:w-3/4 bg-white rounded-lg shadow-sm overflow-hidden flex flex-col" style="min-height: 70vh;">
                <!-- Chat Header -->
                <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="font-semibold">AI Assistant</h2>
                                <p class="text-xs text-blue-100">Helping with your {{ isset($journeyType) && $journeyType == 'idea' ? 'idea' : 'project' }}</p>
                            </div>
                        </div>
                        <div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span>Online
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Chat Messages -->
                <div class="flex-grow p-6 overflow-y-auto" id="chatMessages">
                    <!-- Welcome Message -->
                    <div class="message ai-message">
                        <div class="message-content">
                            <p>Hello! I'm your AI assistant for this journey. I'll help you refine your {{ isset($journeyType) && $journeyType == 'idea' ? 'idea' : 'project' }} through a series of questions.</p>
                            <p class="text-sm text-gray-500 mt-1">Let's start with a brief description of what you have in mind.</p>
                        </div>
                    </div>
                    
                    <!-- Messages will be dynamically added here -->
                </div>
                
                <!-- Message Input Form with File Upload - Enhanced Design -->
                <div class="p-4 border-t border-gray-100">
                    <form id="chat-form" class="flex flex-col" method="POST" enctype="multipart/form-data" action="{{ route('user.ai-journey.chat') }}">
                        @csrf
                        <!-- Message Input with Buttons -->
                        <div class="flex items-center w-full">
                            <button type="button" id="file-upload-btn" class="rounded-lg px-3 py-3 bg-gray-100 flex items-center justify-center text-gray-700 hover:bg-gray-200 transition-colors mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                            </button>
                            <div class="relative flex-grow">
                                <input type="text" id="user-message" name="message" placeholder="Type your message here..." class="w-full bg-gray-50 text-gray-700 rounded-lg px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                <button type="button" id="voice-input" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                    </svg>
                                </button>
                            </div>
                            <button type="submit" id="send-button" class="rounded-lg px-4 py-3 ml-2 bg-blue-600 flex items-center justify-center text-white hover:bg-blue-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                <span class="ml-1 hidden sm:inline">Send</span>
                            </button>
                        </div>
                        
                        <!-- Hidden File Input -->
                        <input type="file" id="file-upload" name="file" class="hidden" multiple>
                        
                        <!-- File Preview Area -->
                        <div id="file-preview-area" class="mt-3 hidden">
                            <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="text-sm font-medium text-gray-700">Attached Files</h4>
                                    <button type="button" id="clear-files" class="text-xs text-red-500 hover:text-red-700">
                                        Clear all
                                    </button>
                                </div>
                                <div id="file-preview-list" class="flex flex-wrap gap-2">
                                    <!-- File previews will be added here dynamically -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- AI Typing Indicator (Hidden by default) -->
                <div id="typing-indicator" class="hidden px-6 py-3 bg-gray-50 border-t border-gray-100">
                    <div class="flex items-center">
                        <div class="flex space-x-1">
                            <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></div>
                            <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
                            <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
                        </div>
                        <span class="text-xs text-gray-500 ml-2">AI is thinking...</span>
                    </div>
                </div>
    </div>
</div>

<style>
    /* Message Styling */
    .message {
        margin-bottom: 16px;
        animation: fadeIn 0.3s ease-in-out;
        position: relative;
    }
    
    .user-message {
        display: flex;
        justify-content: flex-end;
    }
    
    .message-content {
        max-width: 80%;
        padding: 14px 18px;
        border-radius: 18px;
        position: relative;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        line-height: 1.5;
    }
    
    .user-message .message-content {
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
        color: white;
        border-bottom-right-radius: 4px;
    }
    
    .ai-message .message-content {
        background-color: #f9fafb;
        color: #1f2937;
        border-bottom-left-radius: 4px;
        border: 1px solid #e5e7eb;
    }
    
    /* Timestamp styles */
    .message-timestamp {
        font-size: 0.65rem;
        color: #9ca3af;
        margin-top: 4px;
        opacity: 0.8;
    }
    
    .user-message .message-timestamp {
        text-align: right;
        color: #e5e7eb;
    }
    
    /* Avatar styles */
    .ai-message {
        display: flex;
        align-items: flex-start;
    }
    
    .message-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        margin-right: 8px;
        background-color: #e0e7ff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    /* Code block styling */
    .message-content pre {
        background-color: #1e293b;
        color: #e2e8f0;
        padding: 12px;
        border-radius: 6px;
        overflow-x: auto;
        margin: 8px 0;
        font-family: 'Menlo', 'Monaco', 'Courier New', monospace;
        font-size: 0.85rem;
    }
    
    .message-content code {
        background-color: rgba(0,0,0,0.05);
        padding: 2px 4px;
        border-radius: 4px;
        font-family: 'Menlo', 'Monaco', 'Courier New', monospace;
        font-size: 0.9em;
    }
    
    .user-message .message-content code {
        background-color: rgba(255,255,255,0.2);
        color: white;
    }
    
    /* List styling */
    .message-content ul, .message-content ol {
        padding-left: 1.5rem;
        margin: 0.5rem 0;
    }
    
    .message-content ul li, .message-content ol li {
        margin-bottom: 0.25rem;
    }
    
    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Typing indicator animation */
    @keyframes pulse {
        0% { opacity: 0.4; transform: scale(0.8); }
        50% { opacity: 1; transform: scale(1); }
        100% { opacity: 0.4; transform: scale(0.8); }
    }
    
    /* Responsive adjustments for mobile */
    @media (max-width: 768px) {
        .message-content {
            max-width: 90%;
        }
    }
</style>

<script>
    // Script modificado para evitar errores de sintaxis
    // NOTA: La funcionalidad de visualización ahora se maneja en el archivo externo ai-journey-fix.js
    document.addEventListener('DOMContentLoaded', function() {
        const chatContainer = document.getElementById('chatMessages');
        const chatForm = document.getElementById('chat-form');
        const userMessageInput = document.getElementById('user-message');
        const sendButton = document.getElementById('send-button');
        const typingIndicator = document.getElementById('typing-indicator');
        const voiceInputButton = document.getElementById('voice-input');
        const frameworkSelector = document.getElementById('framework-selector');
        const fileUploadBtn = document.getElementById('file-upload-btn');
        const fileUploadInput = document.getElementById('file-upload');
        const filePreviewArea = document.getElementById('file-preview-area');
        const filePreviewList = document.getElementById('file-preview-list');
        const clearFilesBtn = document.getElementById('clear-files');
        let isTyping = false;
        let currentFramework = '';
        let pendingQuestions = [];
        let selectedFiles = [];
        
        // Initialize framework-specific UI
        initializeFrameworkSelector();
        initializeSMEIntegration();
        initializeProcessVisualization();
        initializeFileUpload();
        
        // Auto-scroll to bottom of chat
        scrollToBottom();
        
        // Focus input field on page load
        userMessageInput.focus();
        
        // Initialize file upload functionality
        function initializeFileUpload() {
            if (fileUploadBtn && fileUploadInput) {
                // Trigger file input when button is clicked
                fileUploadBtn.addEventListener('click', () => {
                    fileUploadInput.click();
                });
                
                // Handle file selection
                fileUploadInput.addEventListener('change', (e) => {
                    const files = Array.from(e.target.files);
                    if (files.length > 0) {
                        selectedFiles = files;
                        renderFilePreview();
                    }
                });
                
                // Clear files button
                if (clearFilesBtn) {
                    clearFilesBtn.addEventListener('click', () => {
                        selectedFiles = [];
                        fileUploadInput.value = '';
                        renderFilePreview();
                    });
                }
            }
        }
        
        // File handling functions
        function renderFilePreview() {
            if (!filePreviewArea || !filePreviewList) return;
            
            if (selectedFiles.length > 0) {
                filePreviewArea.classList.remove('hidden');
                filePreviewList.innerHTML = '';
                
                selectedFiles.forEach(file => {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'flex items-center p-2 bg-white border border-gray-200 rounded-md text-sm';
                    
                    // Icon based on file type
                    let fileIcon = '';
                    if (file.type.startsWith('image/')) {
                        fileIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" /></svg>';
                    } else if (file.type.startsWith('application/pdf')) {
                        fileIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg>';
                    } else if (file.type.startsWith('application/msword') || file.type.includes('document')) {
                        fileIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg>';
                    } else {
                        fileIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg>';
                    }
                    
                    // Format file size
                    const fileSize = file.size < 1024 ? file.size + ' B' :
                                    file.size < 1024 * 1024 ? (file.size / 1024).toFixed(1) + ' KB' :
                                    (file.size / (1024 * 1024)).toFixed(1) + ' MB';
                    
                    fileItem.innerHTML = `
                        ${fileIcon}
                        <div class="flex-grow truncate max-w-[150px]">${file.name}</div>
                        <div class="text-xs text-gray-500 ml-2">${fileSize}</div>
                        <button type="button" class="remove-file ml-2 text-gray-400 hover:text-red-500" data-filename="${file.name}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    `;
                    
                    filePreviewList.appendChild(fileItem);
                });
                
                // Add event listeners for remove buttons
                document.querySelectorAll('.remove-file').forEach(button => {
                    button.addEventListener('click', function() {
                        const filename = this.getAttribute('data-filename');
                        selectedFiles = selectedFiles.filter(file => file.name !== filename);
                        renderFilePreview();
                    });
                });
            } else {
                filePreviewArea.classList.add('hidden');
            }
        }
        
        // Add file attachments to message
        function addFileAttachmentsToMessage(files) {
            if (!files || files.length === 0) return '';
            
            let fileListHTML = '<div class="mt-2 p-3 bg-gray-50 rounded-md border border-gray-200"><h4 class="text-sm font-medium text-gray-700 mb-2">Attached Files:</h4><div class="flex flex-wrap gap-2">';
            
            files.forEach(file => {
                // Icon based on file type
                let fileIcon = '';
                if (file.type.startsWith('image/')) {
                    fileIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" /></svg>';
                } else if (file.type.startsWith('application/pdf')) {
                    fileIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg>';
                } else if (file.type.startsWith('application/msword') || file.type.includes('document')) {
                    fileIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg>';
                } else {
                    fileIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg>';
                }
                
                // Format file size
                const fileSize = file.size < 1024 ? file.size + ' B' :
                                file.size < 1024 * 1024 ? (file.size / 1024).toFixed(1) + ' KB' :
                                (file.size / (1024 * 1024)).toFixed(1) + ' MB';
                
                fileListHTML += `
                    <div class="flex items-center p-2 bg-white border border-gray-200 rounded-md text-sm">
                        ${fileIcon}
                        <div class="flex-grow truncate max-w-[150px]">${file.name}</div>
                        <div class="text-xs text-gray-500 ml-2">${fileSize}</div>
                    </div>
                `;
            });
            
            fileListHTML += '</div></div>';
            return fileListHTML;
        }
        
        // Handle user message submission
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Todavía prevenimos el envío predeterminado
            const message = userMessageInput.value.trim();
            if ((!message && selectedFiles.length === 0) || isTyping) return;
            
            // Check for missing framework selection
            if (!currentFramework) {
                // Prompt user to select a framework first
                addMessage('ai', '<div class="bg-yellow-50 border-l-4 border-yellow-500 p-4"><p class="text-yellow-700">Please select a framework first to continue your AI journey.</p></div>', true);
                return;
            }
            
            // Add the hidden framework input if it doesn't exist
            let frameworkInput = chatForm.querySelector('input[name="framework"]');
            if (!frameworkInput) {
                frameworkInput = document.createElement('input');
                frameworkInput.type = 'hidden';
                frameworkInput.name = 'framework';
                chatForm.appendChild(frameworkInput);
            }
            frameworkInput.value = currentFramework;
            
            // Add message with attached files to the chat
            const messageWithFiles = message ? message : 'Attached files';
            let userMessageContent = messageWithFiles;
            
            // Add file attachments preview if files are present
            if (selectedFiles.length > 0) {
                userMessageContent += addFileAttachmentsToMessage(selectedFiles);
            }
            
            // Add the message to the chat display
            addMessage('user', userMessageContent);
            
            // Disable inputs while processing
            toggleInputState(true);
            
            // Show typing indicator
            showTypingIndicator();
            
            // Dado que hemos modificado el formulario para usar POST directamente,
            // ahora vamos a enviarlo usando FormData para controlar mejor el proceso
            const formData = new FormData(chatForm);
            
            // Reset inputs but keep the form data valid for sending
            const messageToSend = message;
            
            // ¡IMPORTANTE! El problema principal: debemos asegurarnos de que formData tiene el mensaje
            // antes de limpiar el campo de entrada
            formData.set('message', messageToSend);
            
            // Ahora podemos limpiar la interfaz después de capturar el mensaje
            userMessageInput.value = '';
            selectedFiles = [];
            renderFilePreview(); // Clear file preview area
            fileUploadInput.value = ''; // Reset file input
            
            // Mensaje de diagnóstico para confirmar que estamos usando el código original sin interceptores
            console.log('Sending message directly to API without any interceptors');
            
            // Usar directamente el API de OpenAI desde backend sin interceptores
            console.log('\u{1F680} Enviando mensaje directamente al backend que usa OpenAI API');
            console.log('\u{1F4DD} Mensaje:', formData.get('message'));
            
            // Petición directa al backend que usará API de OpenAI usando mfetch
            const originalFetch = window.fetch;
            originalFetch(chatForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Cache-Control': 'no-cache, no-store, must-revalidate',
                    'Pragma': 'no-cache',
                    'Expires': '0',
                    'X-Direct-API': 'true' // Marcar que queremos usar API directa
                },
                body: formData
            })
            .then(response => {
                console.log('\u{1F4E1} Respuesta recibida del servidor:', response.status);
                return response.json();
            })
            .then(data => {
                // Verificar que la respuesta viene de OpenAI API
                const isFromRealAPI = data.source === 'openai_api';
                console.log(
                    `%c\u{1F916} ${isFromRealAPI ? 'RESPUESTA REAL DE OPENAI API' : 'RESPUESTA LOCAL'}`, 
                    `color: ${isFromRealAPI ? 'green' : 'red'}; font-weight: bold;`
                );
                
                // Wait a bit before hiding typing indicator for more natural feel
                setTimeout(() => {
                    hideTypingIndicator();
                    
                    // If response is successful, display it
                    if (data.success) {
                        addMessage('ai', data.message || data.response, true);
                        
                        // Update progress if provided
                        if (data.journeyProgress) {
                            updateProgress(data.journeyProgress);
                        }
                        
                        // Process pending questions if any were detected
                        if (data.pendingQuestions && Array.isArray(data.pendingQuestions)) {
                            data.pendingQuestions.forEach(question => {
                                addPendingQuestion(question);
                            });
                        }
                        
                        // Update deliverable progress if provided
                        if (data.deliverables && Array.isArray(data.deliverables)) {
                            updateDeliverables(data.deliverables);
                        }
                    } else {
                        // Show error message
                        addMessage('ai', `<div class="bg-red-50 border-l-4 border-red-500 p-4"><p class="text-red-700">Error: ${data.message || 'Unknown error occurred'}</p></div>`, true);
                    }
                    
                    // Re-enable input
                    toggleInputState(false);
                    userMessageInput.focus();
                }, 500);
            })
            .catch(error => {
                console.error('Request Error:', error);
                hideTypingIndicator();
                addMessage('ai', `<div class="bg-red-50 border-l-4 border-red-500 p-4"><p class="text-red-700">Network error: Could not connect to the AI service.</p><p class="text-xs text-red-500 mt-1">Please check your internet connection and try again.</p></div>`, true);
                toggleInputState(false);
            });
        });
        
        // Initialize Framework Selector functionality
        function initializeFrameworkSelector() {
            if (!frameworkSelector) return;
            
            frameworkSelector.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const framework = this.value;
                const frameworkType = selectedOption.getAttribute('data-type');
                
                if (framework) {
                    currentFramework = framework;
                    
                    // Update selected framework display
                    const selectedFrameworkElement = document.getElementById('selected-framework');
                    if (selectedFrameworkElement) {
                        selectedFrameworkElement.textContent = selectedOption.textContent;
                        selectedFrameworkElement.classList.add('text-blue-600', 'font-medium');
                        setTimeout(() => {
                            selectedFrameworkElement.classList.remove('text-blue-600', 'font-medium');
                        }, 2000);
                    }
                    
                    // Show deliverables for the selected framework
                    updateDeliverablePreview(framework);
                    
                    // Add a system message about the framework change
                    const frameworkMessage = `<div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                        <p class="text-blue-700">Framework changed to <strong>${selectedOption.textContent}</strong>.</p>
                        <p class="text-xs text-blue-600 mt-1">Your AI assistant will now tailor guidance to this framework.</p>
                    </div>`;
                    
                    addMessage('ai', frameworkMessage, true);
                }
            });
        }
        
        // Function to add pending questions for SME input
        function initializeSMEIntegration() {
            const smeAssignmentModal = document.getElementById('sme-assignment-modal');
            const cancelAssignmentBtn = document.getElementById('cancel-assignment');
            const confirmAssignmentBtn = document.getElementById('confirm-assignment');
            const smeSelect = document.getElementById('sme-select');
            const customEmailField = document.getElementById('custom-email-field');
            let currentQuestionId = null;
            
            if (!smeAssignmentModal) return;
            
            // Setup SME selector change event
            if (smeSelect) {
                smeSelect.addEventListener('change', function() {
                    if (this.value === 'custom') {
                        customEmailField.classList.remove('hidden');
                    } else {
                        customEmailField.classList.add('hidden');
                    }
                });
            }
            
            // Setup modal cancel button
            if (cancelAssignmentBtn) {
                cancelAssignmentBtn.addEventListener('click', function() {
                    smeAssignmentModal.classList.add('hidden');
                    currentQuestionId = null;
                });
            }
            
            // Setup modal confirm button
            if (confirmAssignmentBtn) {
                confirmAssignmentBtn.addEventListener('click', function() {
                    const selectedSME = smeSelect.value;
                    let smeEmail = '';
                    
                    if (selectedSME === 'custom') {
                        smeEmail = document.getElementById('sme-email').value;
                        if (!smeEmail || !smeEmail.includes('@')) {
                            alert('Please enter a valid email address');
                            return;
                        }
                    }
                    
                    // Here you would typically make an API call to assign the question
                    // For demo purposes, we'll just update the UI
                    if (currentQuestionId !== null) {
                        const questionElement = document.querySelector(`[data-question-id="${currentQuestionId}"]`);
                        if (questionElement) {
                            const statusElement = questionElement.querySelector('.question-status');
                            const buttonElement = questionElement.querySelector('.assign-sme-btn');
                            
                            if (statusElement) {
                                statusElement.textContent = `Assigned to ${selectedSME === 'custom' ? smeEmail : selectedSME}`;
                                statusElement.classList.remove('text-gray-500');
                                statusElement.classList.add('text-purple-600');
                            }
                            
                            if (buttonElement) {
                                buttonElement.textContent = 'Reassign';
                            }
                            
                            // Add notification about assignment
                            addMessage('ai', `<div class="bg-purple-50 border-l-4 border-purple-500 p-4">
                                <p class="text-purple-700">Question assigned to <strong>${selectedSME === 'custom' ? smeEmail : selectedSME}</strong>.</p>
                                <p class="text-xs text-purple-600 mt-1">They will be notified to provide their input.</p>
                            </div>`, true);
                        }
                    }
                    
                    // Hide modal
                    smeAssignmentModal.classList.add('hidden');
                    currentQuestionId = null;
                });
            }
            
            // Global event delegation for assign buttons
            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('assign-sme-btn')) {
                    const questionElement = e.target.closest('.pending-question');
                    if (questionElement) {
                        currentQuestionId = questionElement.getAttribute('data-question-id');
                        const questionText = questionElement.querySelector('.question-text').textContent;
                        
                        // Update modal with question details
                        document.getElementById('modal-question').textContent = questionText;
                        
                        // Show modal
                        smeAssignmentModal.classList.remove('hidden');
                    }
                }
            });
        }
        // Function to add pending questions for SME input
        function addPendingQuestion(question) {
            const pendingQuestionsContainer = document.getElementById('pending-questions');
            const template = document.querySelector('.pending-question-template');
            const noQuestionsMessage = pendingQuestionsContainer.querySelector('.text-gray-500.italic');
            
            if (pendingQuestionsContainer && template) {
                // Remove the no questions message if it exists
                if (noQuestionsMessage) {
                    noQuestionsMessage.remove();
                }
                
                // Clone the template
                const newQuestion = template.cloneNode(true);
                newQuestion.classList.remove('hidden', 'pending-question-template');
                newQuestion.classList.add('pending-question');
                newQuestion.setAttribute('data-question-id', 'q' + Date.now()); // Unique ID
                
                // Set question text
                const questionTextElement = newQuestion.querySelector('.question-text');
                if (questionTextElement) {
                    questionTextElement.textContent = question;
                }
                
                // Update status element class for targeting
                const statusElement = newQuestion.querySelector('.text-xs.text-gray-500');
                if (statusElement) {
                    statusElement.classList.add('question-status');
                }
                
                // Add to container
                pendingQuestionsContainer.appendChild(newQuestion);
                
                // Update partial deliverables download section
                const partialDownloadSection = document.getElementById('partial-download-section');
                if (partialDownloadSection) {
                    partialDownloadSection.classList.remove('hidden');
                }
            }
        }
        
        // Function to update deliverable preview based on selected framework
        function updateDeliverablePreview(framework) {
            // Hide all framework content sections
            const frameworkContents = document.querySelectorAll('.framework-specific-content');
            frameworkContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Hide the no framework selected message
            const noFrameworkMessage = document.getElementById('no-framework-selected');
            if (noFrameworkMessage) {
                noFrameworkMessage.classList.add('hidden');
            }
            
            // Show the selected framework content
            const selectedContent = document.getElementById(`${framework}-content`);
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
            } else if (noFrameworkMessage) {
                noFrameworkMessage.classList.remove('hidden');
            }
        }

        // Function to update deliverables progress
        function updateDeliverables(deliverables) {
            if (!deliverables || !Array.isArray(deliverables)) return;
            
            deliverables.forEach(deliverable => {
                const deliverableItem = document.querySelector(`.deliverable-item[data-name="${deliverable.name}"]`);
                if (deliverableItem) {
                    const progressBar = deliverableItem.querySelector('.progress-bar');
                    const progressLabel = deliverableItem.querySelector('.progress-label');
                    
                    if (progressBar) {
                        progressBar.style.width = `${deliverable.progress}%`;
                    }
                    
                    if (progressLabel) {
                        progressLabel.textContent = `${deliverable.progress}%`;
                    }
                    
                    // Update status classes
                    if (deliverable.progress >= 100) {
                        deliverableItem.classList.add('completed');
                        deliverableItem.classList.remove('in-progress');
                    } else if (deliverable.progress > 0) {
                        deliverableItem.classList.add('in-progress');
                        deliverableItem.classList.remove('completed');
                    }
                }
            });
        }

        // Initialize process visualization functionality
        // NOTA: Esta función ha sido comentada y reemplazada por el archivo externo ai-journey-fix.js
        function initializeProcessVisualization() {
            // Función desactivada para evitar conflictos
            console.log('Función original desactivada, usando versión externa');
            return;
            // Setup modal confirm button
            if (confirmAssignmentBtn) {
                confirmAssignmentBtn.addEventListener('click', function() {
                    const selectedSME = smeSelect.value;
                    let smeEmail = '';
                    
                    if (selectedSME === 'custom') {
                        smeEmail = document.getElementById('sme-email').value;
                        if (!smeEmail || !smeEmail.includes('@')) {
                            alert('Please enter a valid email address');
                            return;
                        }
                    }
                    
                    // Here you would typically make an API call to assign the question
                    // For demo purposes, we'll just update the UI
                    if (currentQuestionId !== null) {
                        const questionElement = document.querySelector(`[data-question-id="${currentQuestionId}"]`);
                        if (questionElement) {
                            const statusElement = questionElement.querySelector('.question-status');
                            const buttonElement = questionElement.querySelector('.assign-sme-btn');
                            
                            if (statusElement) {
                                statusElement.textContent = `Assigned to ${selectedSME === 'custom' ? smeEmail : selectedSME}`;
                                statusElement.classList.remove('text-gray-500');
                                statusElement.classList.add('text-purple-600');
                            }
                            
                            if (buttonElement) {
                                buttonElement.textContent = 'Reassign';
                            }
                            
                            // Add notification about assignment
                            addMessage('ai', `<div class="bg-purple-50 border-l-4 border-purple-500 p-4">
                                <p class="text-purple-700">Question assigned to <strong>${selectedSME === 'custom' ? smeEmail : selectedSME}</strong>.</p>
                                <p class="text-xs text-purple-600 mt-1">They will be notified to provide their input.</p>
                            </div>`, true);
                        }
                    }
                    
                    // Hide modal
                    smeAssignmentModal.classList.add('hidden');
                    currentQuestionId = null;
                });
            }
            
            // Global event delegation for assign buttons
            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('assign-sme-btn')) {
                    const questionElement = e.target.closest('.pending-question');
                    if (questionElement) {
                        currentQuestionId = questionElement.getAttribute('data-question-id');
                        const questionText = questionElement.querySelector('.question-text').textContent;
                        
                        // Update modal with question details
                        document.getElementById('modal-question').textContent = questionText;
                        
                        // Show modal
                        smeAssignmentModal.classList.remove('hidden');
                    }
                }
            });
        }
        
        // Function to add a pending question to the SME panel
        function addPendingQuestion(question) {
            const pendingQuestionsContainer = document.getElementById('pending-questions');
            const template = document.querySelector('.pending-question-template');
            const noQuestionsMessage = pendingQuestionsContainer.querySelector('.text-gray-500.italic');
            
            if (pendingQuestionsContainer && template) {
                // Remove the no questions message if it exists
                if (noQuestionsMessage) {
                    noQuestionsMessage.remove();
                }
                
                // Clone the template
                const newQuestion = template.cloneNode(true);
                newQuestion.classList.remove('hidden', 'pending-question-template');
                newQuestion.classList.add('pending-question');
                newQuestion.setAttribute('data-question-id', 'q' + Date.now()); // Unique ID
                
                // Set question text
                const questionTextElement = newQuestion.querySelector('.question-text');
                if (questionTextElement) {
                    questionTextElement.textContent = question;
                }
                
                // Update status element class for targeting
                const statusElement = newQuestion.querySelector('.text-xs.text-gray-500');
                if (statusElement) {
                    statusElement.classList.add('question-status');
                }
                
                // Add to container
                pendingQuestionsContainer.appendChild(newQuestion);
                
                // Update partial deliverables download section
                document.getElementById('partial-download-section').classList.remove('hidden');
            }
        }
        
        // Function to update deliverable preview based on selected framework
        function updateDeliverablePreview(framework) {
            // Hide all framework content sections
            const frameworkContents = document.querySelectorAll('.framework-specific-content');
            frameworkContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Hide the no framework selected message
            const noFrameworkMessage = document.getElementById('no-framework-selected');
            if (noFrameworkMessage) {
                noFrameworkMessage.classList.add('hidden');
            }
            
            // Show the selected framework content
            const selectedContent = document.getElementById(`${framework}-content`);
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
            } else if (noFrameworkMessage) {
                // If no matching content, show the no framework message
                noFrameworkMessage.classList.remove('hidden');
            }
        }
        
        // Function to update deliverable progress in the preview panel
        function updateDeliverables(deliverables) {
            if (!deliverables || !Array.isArray(deliverables)) return;
            
            deliverables.forEach(deliverable => {
                // Find all list items that match this deliverable name
                const deliverableItems = document.querySelectorAll(`#deliverable-content li span.flex-grow`);
                
                deliverableItems.forEach(item => {
                    if (item.textContent.trim() === deliverable.name) {
                        // Get the status indicator and update it
                        const statusIndicator = item.closest('li').querySelector('.w-2.h-2');
                        const percentIndicator = item.closest('li').querySelector('.text-xs');
                        
                        if (statusIndicator && percentIndicator) {
                            const progress = deliverable.progress || 0;
                            
                            // Update color based on progress
                            statusIndicator.className = statusIndicator.className.replace(/bg-\w+-\d+/, '');
                            if (progress === 0) {
                                statusIndicator.classList.add('bg-gray-300');
                            } else if (progress < 50) {
                                statusIndicator.classList.add('bg-yellow-400');
                            } else if (progress < 100) {
                                statusIndicator.classList.add('bg-blue-400');
                            } else {
                                statusIndicator.classList.add('bg-green-500');
                            }
                            
                            // Update percentage
                            percentIndicator.textContent = `${progress}%`;
                            percentIndicator.className = percentIndicator.className.replace(/text-\w+-\d+/, '');
                            if (progress === 100) {
                                percentIndicator.classList.add('text-green-600');
                            } else {
                                percentIndicator.classList.add('text-gray-400');
                            }
                        }
                    }
                });
            });
            
            // Show the partial download section
            document.getElementById('partial-download-section').classList.remove('hidden');
        }
        
        // Helper function to create a PRINCE2 process map
        function createPRINCE2ProcessMap() {
            return `
            <svg width="100%" height="100%" viewBox="0 0 800 300" xmlns="http://www.w3.org/2000/svg">
                <style>
                    .box { fill: #E5E7EB; stroke: #4F46E5; stroke-width: 2; }
                    .arrow { stroke: #4F46E5; stroke-width: 2; fill: none; }
                    .text { font-family: Arial; font-size: 14px; fill: #1F2937; }
                    .phase { font-family: Arial; font-size: 12px; fill: #4F46E5; font-weight: bold; }
                </style>
                
                <!-- Starting Up Phase -->
                <rect class="box" x="50" y="50" width="120" height="60" rx="5" />
                <text class="phase" x="110" y="45">Starting Up</text>
                <text class="text" x="110" y="80" text-anchor="middle">Project Mandate</text>
                
                <!-- Initiating Phase -->
                <rect class="box" x="250" y="50" width="120" height="60" rx="5" />
                <text class="phase" x="310" y="45">Initiating</text>
                <text class="text" x="310" y="80" text-anchor="middle">Project Brief</text>
                
                <!-- Controlling Phase -->
                <rect class="box" x="450" y="50" width="120" height="60" rx="5" />
                <text class="phase" x="510" y="45">Controlling</text>
                <text class="text" x="510" y="80" text-anchor="middle">Work Packages</text>
                
                <!-- Closing Phase -->
                <rect class="box" x="650" y="50" width="120" height="60" rx="5" />
                <text class="phase" x="710" y="45">Closing</text>
                <text class="text" x="710" y="80" text-anchor="middle">Final Report</text>
                
                <!-- Managing Phase -->
                <rect class="box" x="350" y="200" width="120" height="60" rx="5" />
                <text class="phase" x="410" y="195">Managing</text>
                <text class="text" x="410" y="225" text-anchor="middle">Direction</text>
                <text class="text" x="410" y="245" text-anchor="middle">Project Board</text>
                
                <!-- Arrows -->
                <path class="arrow" d="M170 80 H 250" marker-end="url(#arrowhead)" />
                <path class="arrow" d="M370 80 H 450" marker-end="url(#arrowhead)" />
                <path class="arrow" d="M570 80 H 650" marker-end="url(#arrowhead)" />
                
                <path class="arrow" d="M110 110 V 230 H 350" marker-end="url(#arrowhead)" />
                <path class="arrow" d="M310 110 V 170 H 375" marker-end="url(#arrowhead)" />
                <path class="arrow" d="M510 110 V 170 H 450" marker-end="url(#arrowhead)" />
                <path class="arrow" d="M710 110 V 230 H 470" marker-end="url(#arrowhead)" />
                
                <!-- Arrowhead marker -->
                <defs>
                    <marker id="arrowhead" markerWidth="10" markerHeight="7" 
                    refX="9" refY="3.5" orient="auto">
                    <polygon points="0 0, 10 3.5, 0 7" fill="#4F46E5" />
                    </marker>
                </defs>
            </svg>
            `;
        }
        
        // Helper function to create an Idea Management process map
        function createIdeaManagementProcessMap() {
            return `
            <svg width="100%" height="100%" viewBox="0 0 800 300" xmlns="http://www.w3.org/2000/svg">
                <style>
                    .box { fill: #E0F2FE; stroke: #0284C7; stroke-width: 2; }
                    .arrow { stroke: #0284C7; stroke-width: 2; fill: none; }
                    .text { font-family: Arial; font-size: 14px; fill: #1F2937; }
                    .phase { font-family: Arial; font-size: 12px; fill: #0284C7; font-weight: bold; }
                </style>
                
                <!-- Idea Generation -->
                <rect class="box" x="50" y="100" width="120" height="60" rx="5" />
                <text class="phase" x="110" y="95">Phase 1</text>
                <text class="text" x="110" y="130" text-anchor="middle">Idea Generation</text>
                
                <!-- Initial Screening -->
                <rect class="box" x="250" y="100" width="120" height="60" rx="5" />
                <text class="phase" x="310" y="95">Phase 2</text>
                <text class="text" x="310" y="130" text-anchor="middle">Initial Screening</text>
                
                <!-- Idea Evaluation -->
                <rect class="box" x="450" y="100" width="120" height="60" rx="5" />
                <text class="phase" x="510" y="95">Phase 3</text>
                <text class="text" x="510" y="130" text-anchor="middle">Idea Evaluation</text>
                
                <!-- Implementation -->
                <rect class="box" x="650" y="100" width="120" height="60" rx="5" />
                <text class="phase" x="710" y="95">Phase 4</text>
                <text class="text" x="710" y="130" text-anchor="middle">Implementation</text>
                
                <!-- Arrows -->
                <path class="arrow" d="M170 130 H 250" marker-end="url(#arrowhead-blue)" />
                <path class="arrow" d="M370 130 H 450" marker-end="url(#arrowhead-blue)" />
                <path class="arrow" d="M570 130 H 650" marker-end="url(#arrowhead-blue)" />
                
                <!-- Loop back arrow -->
                <path class="arrow" d="M450 100 C 450 50, 250 50, 250 100" marker-end="url(#arrowhead-blue)" />
                <text class="text" x="350" y="70" text-anchor="middle">Refinement Loop</text>
                
                <!-- Arrowhead marker -->
                <defs>
                    <marker id="arrowhead-blue" markerWidth="10" markerHeight="7" 
                    refX="9" refY="3.5" orient="auto">
                    <polygon points="0 0, 10 3.5, 0 7" fill="#0284C7" />
                    </marker>
                </defs>
            </svg>
            `;
        }
        
        // Helper function to create a generic process map
        function createGenericProcessMap(framework) {
            return `
            <svg width="100%" height="100%" viewBox="0 0 800 300" xmlns="http://www.w3.org/2000/svg">
                <style>
                    .box { fill: #F3F4F6; stroke: #4B5563; stroke-width: 2; }
                    .arrow { stroke: #4B5563; stroke-width: 2; fill: none; }
                    .text { font-family: Arial; font-size: 14px; fill: #1F2937; }
                    .title { font-family: Arial; font-size: 16px; fill: #1F2937; font-weight: bold; }
                </style>
                
                <text class="title" x="400" y="30" text-anchor="middle">${framework.toUpperCase().replace(/-/g, ' ')} Process</text>
                
                <!-- Input -->
                <rect class="box" x="100" y="100" width="120" height="60" rx="5" />
                <text class="text" x="160" y="130" text-anchor="middle">Input</text>
                
                <!-- Process -->
                <rect class="box" x="350" y="100" width="120" height="60" rx="5" />
                <text class="text" x="410" y="130" text-anchor="middle">Process</text>
                
                <!-- Output -->
                <rect class="box" x="600" y="100" width="120" height="60" rx="5" />
                <text class="text" x="660" y="130" text-anchor="middle">Output</text>
                
                <!-- Arrows -->
                <path class="arrow" d="M220 130 H 350" marker-end="url(#arrowhead-gray)" />
                <path class="arrow" d="M470 130 H 600" marker-end="url(#arrowhead-gray)" />
                
                <!-- Arrowhead marker -->
                <defs>
                    <marker id="arrowhead-gray" markerWidth="10" markerHeight="7" 
                    refX="9" refY="3.5" orient="auto">
                    <polygon points="0 0, 10 3.5, 0 7" fill="#4B5563" />
                    </marker>
                </defs>
            </svg>
            `;
        }
        
        // Helper function to create a data model
        function createDataModel(framework) {
            return `
            <svg width="100%" height="100%" viewBox="0 0 800 300" xmlns="http://www.w3.org/2000/svg">
                <style>
                    .entity { fill: #EFF6FF; stroke: #2563EB; stroke-width: 2; }
                    .relation { stroke: #2563EB; stroke-width: 2; fill: none; }
                    .text { font-family: Arial; font-size: 14px; fill: #1F2937; }
                    .entity-title { font-family: Arial; font-size: 14px; fill: #2563EB; font-weight: bold; }
                    .entity-field { font-family: Arial; font-size: 12px; fill: #4B5563; }
                </style>
                
                <!-- Main Entity -->
                <rect class="entity" x="300" y="50" width="200" height="120" rx="5" />
                <text class="entity-title" x="400" y="75" text-anchor="middle">${framework.toUpperCase().replace(/-/g, ' ')}</text>
                <line x1="310" y1="85" x2="490" y2="85" stroke="#2563EB" stroke-width="1" />
                <text class="entity-field" x="320" y="105">id (PK)</text>
                <text class="entity-field" x="320" y="125">name</text>
                <text class="entity-field" x="320" y="145">description</text>
                
                <!-- Related Entity 1 -->
                <rect class="entity" x="100" y="180" width="180" height="100" rx="5" />
                <text class="entity-title" x="190" y="205" text-anchor="middle">Documentation</text>
                <line x1="110" y1="215" x2="270" y2="215" stroke="#2563EB" stroke-width="1" />
                <text class="entity-field" x="120" y="235">id (PK)</text>
                <text class="entity-field" x="120" y="255">${framework}_id (FK)</text>
                
                <!-- Related Entity 2 -->
                <rect class="entity" x="520" y="180" width="180" height="100" rx="5" />
                <text class="entity-title" x="610" y="205" text-anchor="middle">Deliverables</text>
                <line x1="530" y1="215" x2="690" y2="215" stroke="#2563EB" stroke-width="1" />
                <text class="entity-field" x="540" y="235">id (PK)</text>
                <text class="entity-field" x="540" y="255">${framework}_id (FK)</text>
                
                <!-- Relationship Lines -->
                <path class="relation" d="M300 110 H 200 V 180" marker-end="url(#relation-end)" />
                <path class="relation" d="M500 110 H 600 V 180" marker-end="url(#relation-end)" />
                
                <!-- Relationship markers -->
                <defs>
                    <marker id="relation-end" markerWidth="10" markerHeight="7" 
                    refX="9" refY="3.5" orient="auto">
                    <polygon points="0 0, 10 3.5, 0 7" fill="#2563EB" />
                    </marker>
                </defs>
            </svg>
            `;
        }
        
        // Voice input button handler (placeholder for future implementation)
        voiceInputButton.addEventListener('click', function() {
            // This is just a UI notification - actual speech recognition would be implemented here
            userMessageInput.placeholder = "Voice input not available yet...";
            setTimeout(() => {
                userMessageInput.placeholder = "Type your message here...";
                userMessageInput.focus();
            }, 2000);
        });
        
        // Function to toggle input state during processing
        function toggleInputState(disabled) {
            isTyping = disabled;
            userMessageInput.disabled = disabled;
            sendButton.disabled = disabled;
            if (disabled) {
                sendButton.classList.add('opacity-50');
            } else {
                sendButton.classList.remove('opacity-50');
            }
        }
        
        // Function to show typing indicator
        function showTypingIndicator() {
            typingIndicator.classList.remove('hidden');
            scrollToBottom();
        }
        
        // Function to hide typing indicator
        function hideTypingIndicator() {
            typingIndicator.classList.add('hidden');
        }
        
        // Function to add a message to the chat
        function addMessage(sender, content, withAvatar = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}-message`;
            
            if (sender === 'ai' && withAvatar) {
                // Add AI avatar
                const avatar = document.createElement('div');
                avatar.className = 'message-avatar';
                avatar.innerHTML = `<svg class="w-4 h-4 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>`;
                messageDiv.appendChild(avatar);
            }
            
            const messageContent = document.createElement('div');
            messageContent.className = 'message-content';
            
            // Format content with enhanced parsing
            const formattedContent = formatMessageContent(content);
            messageContent.innerHTML = formattedContent;
            
            messageDiv.appendChild(messageContent);
            
            // Add timestamp
            const timestamp = document.createElement('div');
            timestamp.className = 'message-timestamp';
            timestamp.textContent = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            messageContent.appendChild(timestamp);
            
            // Add message to chat with subtle animation delay
            setTimeout(() => {
                chatContainer.appendChild(messageDiv);
                scrollToBottom();
                
                // Add subtle highlight effect to new message
                setTimeout(() => {
                    messageDiv.style.backgroundColor = 'rgba(219, 234, 254, 0.1)';
                    setTimeout(() => {
                        messageDiv.style.backgroundColor = 'transparent';
                        messageDiv.style.transition = 'background-color 1s ease';
                    }, 300);
                }, 50);
            }, 100);
        }
        
        // Function to format message content (handle links, line breaks, etc.)
        function formatMessageContent(content) {
            // Handle code blocks with syntax highlighting
            content = content.replace(/```([\s\S]*?)```/g, function(match, p1) {
                return `<pre><code>${escapeHtml(p1)}</code></pre>`;
            });
            
            // Handle inline code
            content = content.replace(/`([^`]+)`/g, function(match, p1) {
                return `<code>${escapeHtml(p1)}</code>`;
            });
            
            // Replace URLs with clickable links
            const urlRegex = /(https?:\/\/[^\s]+)/g;
            content = content.replace(urlRegex, url => `<a href="${url}" target="_blank" class="text-blue-600 hover:underline">${url}</a>`);
            
            // Replace line breaks with <br> if not already in HTML
            if (!content.includes('<ul>') && !content.includes('<div>')) {
                content = content.replace(/\n/g, '<br>');
            }
            
            return content;
        }
        
        // Helper function to escape HTML
        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
        
        // Function to scroll chat to bottom
        function scrollToBottom() {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
        
        // Function to update progress bar
        function updateProgress(progress) {
            const progressBar = document.getElementById('journey-progress');
            if (progressBar) {
                // Animate the progress change
                const currentWidth = parseInt(progressBar.getAttribute('aria-valuenow') || 10);
                const targetWidth = progress;
                
                // Simple animation
                const step = 1;
                const duration = 500; // ms
                const steps = Math.abs(targetWidth - currentWidth) / step;
                const stepTime = duration / steps;
                
                let currentStep = 0;
                let currentValue = currentWidth;
                
                const interval = setInterval(() => {
                    if (currentValue < targetWidth) {
                        currentValue += step;
                    } else if (currentValue > targetWidth) {
                        currentValue -= step;
                    }
                    
                    progressBar.style.width = `${currentValue}%`;
                    progressBar.setAttribute('aria-valuenow', currentValue);
                    
                    currentStep++;
                    if (currentStep >= steps) {
                        clearInterval(interval);
                        progressBar.style.width = `${targetWidth}%`;
                        progressBar.setAttribute('aria-valuenow', targetWidth);
                    }
                }, stepTime);
            }
        }
        
        // Function to update journey stage
        function updateJourneyStage(stage) {
            const stageElement = document.getElementById('journey-stage');
            if (stageElement && stage) {
                stageElement.textContent = stage;
                stageElement.classList.add('text-blue-700');
                setTimeout(() => {
                    stageElement.classList.remove('text-blue-700');
                }, 2000);
            }
        }
        
        // Handle input field keypress - send on Enter, new line on Shift+Enter
        userMessageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                chatForm.dispatchEvent(new Event('submit'));
            }
        });
    });
</script>

<!-- Implementación definitiva: Cargar solo la solución autónoma -->
<script>
    // Sistema de carga autónoma - independiente de errores DOM
    document.addEventListener('DOMContentLoaded', function() {
        console.log('✨ Iniciando sistema independiente de visualización...');
        
        // Cargar de forma segura el script autónomo
        const script = document.createElement('script');
        script.src = '{{ asset("js/ai-journey-standalone.js") }}';
        script.onerror = function() {
            console.error('❌ Error al cargar el script de visualización autónomo');
            showErrorMessage();
        };
        document.body.appendChild(script);
        
        // Mensaje de error como último recurso
        function showErrorMessage() {
            // Buscar un lugar donde mostrar el error
            const container = document.querySelector('.process-visualization-panel') || 
                              document.querySelector('.ai-journey-container') ||
                              document.querySelector('main .container');
            
            if (container) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'mt-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700';
                errorDiv.innerHTML = `
                    <p class="font-medium">Error de visualización</p>
                    <p class="text-sm">No se pudo cargar el componente de visualización del proceso. Por favor, recarga la página o contacta a soporte.</p>
                `;
                container.appendChild(errorDiv);
            }
        }
    });
</script>

<!-- Script desactivado para permitir que las respuestas vengan directamente de la API real -->
<!-- <script src="{{ asset('js/ai-journey-chat-fix-new.js') }}" defer></script> -->

<!-- Mensaje de confirmación para verificar que estamos usando la API directamente -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('%c✅ API DIRECTA ACTIVADA: Los mensajes de chat vendrán directamente de la API oficial de OpenAI', 'color: green; font-weight: bold; font-size: 14px');
        console.log('API Key Length:', {{ strlen(env('OPENAI_API_KEY', '')) }});
        console.log('API Model:', '{{ env('OPENAI_MODEL', 'undefined') }}');
    });
</script>
@endsection
