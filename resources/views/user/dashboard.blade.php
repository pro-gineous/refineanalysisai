@extends('layouts.dashboard')

@section('head_styles')
<style>
    /* Estilos para el efecto glassmorphism y papel plegado */
    .shadow-glow {
        box-shadow: 0 0 15px rgba(59, 130, 246, 0.6);
        transform: translateY(-5px) scale(1.02);
        transition: all 0.3s ease;
    }
    
    /* Efecto de papel plegado en la esquina */
    .fold-effect {
        position: relative;
        overflow: hidden;
    }
    
    .fold-effect::before {
        content: '';
        position: absolute;
        top: -20px;
        right: -20px;
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, transparent 49%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0.4) 100%);
        transform: rotate(45deg);
        box-shadow: 2px -2px 5px rgba(0,0,0,0.1);
        z-index: 2;
        pointer-events: none;
    }
    
    /* Efecto glassmorphism mejorado */
    .glass {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .modal-appear {
        animation: appearEffect 0.4s ease-out forwards;
    }
    
    @keyframes appearEffect {
        0% {
            opacity: 0;
            transform: scale(0.8) translateY(20px);
        }
        60% {
            transform: scale(1.05) translateY(-10px);
        }
        100% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
</style>
@endsection

@section('content')
<!-- Welcome Section with Assistant and Create New buttons -->
<div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 bg-gray-50 bg-opacity-50 px-6 py-6 rounded-xl">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-1">Welcome, <span class="text-blue-500">{{ Auth::user()->name }}</span>!</h1>
        <p class="text-gray-500 text-sm">Let's continue from where you left off.</p>
    </div>
    <div class="flex items-center space-x-3 mt-4 lg:mt-0">
        <a href="{{ route('user.ai-assistant') }}" id="assistantBtn" class="flex items-center px-5 py-2.5 rounded-lg bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 transition-all shadow-sm cursor-pointer">
            <svg class="w-5 h-5 mr-2 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 8v.01M12 12v.01M12 16v.01M12 20a8 8 0 100-16 8 8 0 000 16z" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Assistant
        </a>
        <button id="createNewBtn" class="flex items-center px-5 py-2.5 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all shadow-sm cursor-pointer">
            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 4v16m-8-8h16" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Create New
        </button>
        <button class="p-2 rounded-full text-gray-400 hover:bg-gray-100 transition-all">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <path d="M12 16v-4m0-4h.01" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>
</div>

<!-- Overview Section -->
<div class="mb-8">
    <div class="flex items-center mb-6">
        <svg class="h-6 w-6 text-blue-600 mr-2" viewBox="0 0 24 24" fill="currentColor">
            <path d="M11 3a8 8 0 100 16 8 8 0 000-16zm0 14.5a6.5 6.5 0 110-13 6.5 6.5 0 010 13zm1-4h1v2h-4v-5h3v3z"/>
        </svg>
        <h2 class="text-2xl font-bold text-gray-800">Overview</h2>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Active Ideas -->
        <div class="bg-gradient-to-r from-green-400 to-green-500 text-white rounded-xl p-5 flex justify-between items-center shadow-sm">
            <div>
                <p class="text-lg font-bold mb-1">{{ $activeIdeas ?? 0 }}</p>
                <p class="text-sm">Active Ideas</p>
            </div>
            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                </svg>
            </div>
        </div>
        
        <!-- Card 2: Active Projects -->
        <div class="bg-gradient-to-r from-blue-400 to-blue-500 text-white rounded-xl p-5 flex justify-between items-center shadow-sm">
            <div>
                <p class="text-lg font-bold mb-1">{{ $totalProjects ?? count($projects) }}</p>
                <p class="text-sm">Active Projects</p>
            </div>
            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 13h8v2H3v-2zm0 4h8v2H3v-2zm0-8h8v2H3V9zm0-4h8v2H3V5zm10 0v17h11V5H13zm9 15h-7V7h7v13z" />
                </svg>
            </div>
        </div>
        
        <!-- Card 3: Tracked Time -->
        <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-xl p-5 flex justify-between items-center shadow-sm">
            <div>
                <p class="text-lg font-bold mb-1">{{ $trackedHours ?? 0 }}h</p>
                <p class="text-sm">Tracked This Week</p>
            </div>
            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.2 3.2.8-1.3-4.5-2.7V7z" />
                </svg>
            </div>
        </div>
        
        <!-- Card 4: Blockers -->
        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl p-5 flex justify-between items-center shadow-sm">
            <div>
                <p class="text-lg font-bold mb-1">{{ $blockers ?? 0 }}</p>
                <p class="text-sm">Blockers</p>
            </div>
            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm-1-13h2v7h-2zm0 8h2v2h-2z" />
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Tab Navigation -->
<div class="flex flex-nowrap items-center mb-6 bg-gray-50 bg-opacity-50 rounded-lg p-1 overflow-x-auto">
    <button class="px-4 py-2 bg-blue-500 text-white rounded-lg font-medium whitespace-nowrap">
        Active Projects
    </button>
    <button class="px-4 py-2 text-gray-500 font-medium hover:bg-white hover:text-gray-800 rounded-lg whitespace-nowrap mx-1">
        Upcoming Tasks
    </button>
    <button class="px-4 py-2 text-gray-500 font-medium hover:bg-white hover:text-gray-800 rounded-lg whitespace-nowrap mx-1">
        Recent Ideas
    </button>
    <button class="px-4 py-2 text-gray-500 font-medium hover:bg-white hover:text-gray-800 rounded-lg whitespace-nowrap mx-1">
        Immediate Action
    </button>
    <div class="ml-auto flex items-center">
        <button class="p-2 text-gray-400 hover:text-gray-600 rounded">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <button class="p-2 text-gray-400 hover:text-gray-600 rounded">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M10 3H3v7h7V3zM21 3h-7v7h7V3zM21 14h-7v7h7v-7zM10 14H3v7h7v-7z" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
    </div>
</div>

<!-- Projects Section -->
<div class="flex items-center mb-4">
    <svg class="h-6 w-6 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z"></path>
    </svg>
    <h2 class="text-2xl font-bold text-gray-800">Projects</h2>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
    @forelse ($projects as $project)
        <!-- Project Card -->
        <div class="bg-white rounded-xl shadow-sm p-5">
            <div class="flex justify-between items-center mb-4">
                <!-- Status indicator and title -->
                <div class="flex items-center">
                    <span class="w-2 h-2 rounded-full mr-2 @if($project->status == 'active') bg-green-500 @elseif($project->status == 'in_progress') bg-blue-500 @else bg-red-500 @endif"></span>
                    <span class="text-xs font-semibold uppercase @if($project->status == 'active') text-green-600 @elseif($project->status == 'in_progress') text-blue-600 @else text-red-600 @endif">
                        @if($project->status == 'active') Active @elseif($project->status == 'in_progress') New @else OnHold @endif
                    </span>
                </div>
                <!-- High Priority Tag -->
                <div>
                    <span class="text-xs font-semibold text-red-600 bg-red-50 rounded-full px-2 py-0.5">High</span>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-600 border border-gray-200 rounded-full px-2 py-0.5">Set 1</span>
                </div>
                <!-- Action button -->
                <button class="text-blue-600 flex items-center justify-center w-6 h-6 rounded-full">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Project Title -->
            <h3 class="text-lg font-semibold text-gray-800 mb-3">{{ $project->title }}</h3>
            
            <!-- Progress Bar -->
            <div class="mb-4">
                <div class="flex justify-between items-center mb-1 text-xs">
                    <span class="font-medium">Progress</span>
                    <span>75%</span>
                </div>
                <div class="h-1.5 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-1.5 bg-blue-500 rounded-full" style="width: 75%;"></div>
                </div>
            </div>
            
            <!-- Milestone Bar -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-1 text-xs">
                    <span class="font-medium">Milestone</span>
                    <span>50%</span>
                </div>
                <div class="h-1.5 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-1.5 bg-blue-500 rounded-full" style="width: 50%;"></div>
                </div>
            </div>
            
            <!-- Due Date -->
            <div class="text-sm text-gray-500 mb-1">
                <span class="font-medium">Due Date:</span> {{ \Carbon\Carbon::parse($project->end_date)->format('M d, Y') }}
            </div>
            
            <!-- Next Task Date -->
            <div class="text-sm text-gray-500 mb-5">
                <span class="font-medium">Next Task Due:</span> May 20, 2025
            </div>
            
            <!-- View Button -->
            <div class="text-center">
                <button class="flex items-center justify-center w-full text-blue-600 hover:text-blue-800">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View
                </button>
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">No projects found</h3>
            <p class="mt-1 text-gray-500">Get started by creating a new project</p>
            <div class="mt-6">
                <button type="button" id="openCreateModal" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2H9V4a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    New Project
                </button>
            </div>
        </div>
    @endforelse
</div>

<div class="flex justify-center mb-8">
    <button id="viewAllProjects" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium shadow-sm cursor-pointer">View all projects</button>
</div>

<!-- Skill Matrix and Project Timeline Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Skill Matrix -->
    <div class="bg-white rounded-xl shadow-sm p-5">
        <div class="flex items-center mb-3">
            <svg class="h-5 w-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"/>
            </svg>
            <h3 class="text-lg font-bold text-gray-800">Skill Matrix</h3>
            <span class="ml-auto text-xs text-gray-500">AI-generated skills assessment</span>
        </div>
            
        @if(count($skills ?? []) > 0)
            @foreach($skills as $skill)
            <div class="mb-{{ $loop->last ? 3 : 5 }}">
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">{{ $skill['name'] }}</span>
                    <span class="text-xs font-semibold text-blue-700">{{ $skill['level'] }}</span>
                </div>
                <div class="h-2 w-full bg-blue-100 rounded-full overflow-hidden">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $skill['percentage'] }}%"></div>
                </div>
                <div class="text-xs {{ isset($skill['trend']) && $skill['trend'] == 'up' ? 'text-green-600' : 'text-gray-500' }} mt-1">
                    {{ isset($skill['change']) ? $skill['change'] . ' since last month' : 'No change' }}
                    @if(isset($skill['recommendation']))
                        <br>Recommendation: {{ $skill['recommendation'] }}
                    @endif
                </div>
            </div>
            @endforeach
        @else
            <div class="flex flex-col items-center justify-center py-6">
                <svg class="h-10 w-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 01-2 2v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                <p class="text-gray-500 text-sm text-center">No skills data available yet.<br>Start using frameworks in your projects to build your skill matrix.</p>
            </div>
        @endif

        <div class="text-center mt-5">
            <a href="#" class="text-blue-600 text-sm font-medium hover:text-blue-800">View all Analysis</a>
        </div>
    </div>
    
    <!-- Project Timeline -->
    <div class="bg-white rounded-xl shadow-sm p-5">
        <div class="flex items-center mb-4">
            <svg class="h-5 w-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            <h3 class="text-lg font-bold text-gray-800">Project Timeline</h3>
        </div>
        
        <!-- Timeline component -->
        @if(count($timeline ?? []) > 0)
        <div class="relative pl-6">
            <!-- The vertical line -->
            <div class="absolute left-0 top-0 h-full w-0.5 bg-gray-200"></div>
            
            @foreach($timeline as $index => $milestone)
            <!-- Milestone {{ $index + 1 }} -->
            <div class="relative mb-{{ $loop->last ? 0 : 6 }}">
                <!-- The circle indicator -->
                <div class="absolute -left-2 w-4 h-4 bg-{{ $index === 0 ? 'blue-600' : 'gray-400' }} rounded-full mt-1"></div>
                <div class="flex items-center ml-2">
                    <span class="text-xs font-medium bg-{{ $index === 0 ? 'blue-50 text-blue-700' : 'gray-100 text-gray-700' }} px-2 py-1 rounded">{{ $milestone['date_display'] }}</span>
                    <span class="ml-2 text-sm font-medium text-gray-800">{{ $milestone['title'] }}</span>
                    <span class="ml-auto text-xs px-2 py-1 rounded
                        @if(isset($milestone['priority']))
                            @if($milestone['priority'] === 'Critical') bg-red-50 text-red-700 @endif
                            @if($milestone['priority'] === 'Important') bg-orange-50 text-orange-700 @endif
                            @if($milestone['priority'] === 'Normal') bg-blue-50 text-blue-700 @endif
                        @else
                            bg-blue-50 text-blue-700
                        @endif
                    ">{{ $milestone['priority'] ?? 'Normal' }}</span>
                </div>
                <div class="mt-1 ml-2">
                    <p class="text-xs text-gray-500">{{ $milestone['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="flex flex-col items-center justify-center py-6">
            <svg class="h-10 w-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="text-gray-500 text-sm text-center">No timeline data available yet.<br>Create projects with deadlines to see your timeline.</p>
        </div>
        @endif
        
        <div class="text-center mt-5">
            <a href="#" class="text-blue-600 text-sm font-medium hover:text-blue-800">View Full Timeline</a>
        </div>
    </div>
</div>

<!-- Modal con diseño consistente con el dashboard -->
<div id="createModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <!-- Overlay de fondo -->
    <div class="absolute inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity duration-300 ease-out opacity-0" id="modalOverlay"></div>
    
    <!-- Contenedor principal del modal -->
    <div class="relative w-full max-w-2xl transform transition-all duration-300 ease-out scale-95 opacity-0 translate-y-4" id="modalContent">
        <!-- Panel principal con efecto glassmorphism -->
        <div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg rounded-xl shadow-lg overflow-hidden border border-white border-opacity-30">

            <!-- Cabecera con estilo consistente -->
            <div class="bg-blue-600 p-5">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold text-white">Create New</h3>
                    <button id="closeModal" class="text-white hover:text-gray-200 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Contenido del modal con fondo transparente para el efecto glassmorphism -->
            <div class="p-6 bg-gray-50 bg-opacity-30 backdrop-filter backdrop-blur-sm">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-5">
                    <!-- Opción Ideas -->
                    <div class="group cursor-pointer transform transition duration-200 hover:-translate-y-1">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 rounded-xl shadow-sm border border-white border-opacity-20">
                            <div class="flex flex-col items-center">
                                <div class="p-3 bg-white bg-opacity-20 rounded-full mb-3">
                                    <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 01-2 2v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-white font-medium text-sm">Ideas</h4>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Opción Projects -->
                    <div class="group cursor-pointer transform transition duration-200 hover:-translate-y-1">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 rounded-xl shadow-sm border border-white border-opacity-20">
                            <div class="flex flex-col items-center">
                                <a href="{{ route('user.ai-assistant') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-100">
                                    <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                    </svg>
                                    Assistant
                                </a>
                                <h4 class="text-white font-medium text-sm">Projects</h4>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Opción Testing -->
                    <div class="group cursor-pointer transform transition duration-200 hover:-translate-y-1">
                        <div class="bg-gradient-to-r from-blue-400 to-blue-600 p-4 rounded-xl shadow-sm border border-white border-opacity-20">
                            <div class="flex flex-col items-center">
                                <div class="p-3 bg-white bg-opacity-20 rounded-full mb-3">
                                    <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-white font-medium text-sm">Testing</h4>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Opción Quality -->
                    <div class="group cursor-pointer transform transition duration-200 hover:-translate-y-1">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-4 rounded-xl shadow-sm border border-white border-opacity-20">
                            <div class="flex flex-col items-center">
                                <div class="p-3 bg-white bg-opacity-20 rounded-full mb-3">
                                    <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-white font-medium text-sm">Quality</h4>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Opción Analytics -->
                    <div class="group cursor-pointer transform transition duration-200 hover:-translate-y-1">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 rounded-xl shadow-sm border border-white border-opacity-20">
                            <div class="flex flex-col items-center">
                                <div class="p-3 bg-white bg-opacity-20 rounded-full mb-3">
                                    <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-white font-medium text-sm">Analytics</h4>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Opción Reports -->
                    <div class="group cursor-pointer transform transition duration-200 hover:-translate-y-1">
                        <div class="bg-gradient-to-r from-blue-400 to-blue-500 p-4 rounded-xl shadow-sm border border-white border-opacity-20">
                            <div class="flex flex-col items-center">
                                <div class="p-3 bg-white bg-opacity-20 rounded-full mb-3">
                                    <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-white font-medium text-sm">Reports</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para el modal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('createModal');
        const overlay = document.getElementById('modalOverlay');
        const content = document.getElementById('modalContent');
        
        // Nuevos botones para abrir el modal
        const assistantBtn = document.getElementById('assistantBtn');
        const createNewBtn = document.getElementById('createNewBtn');
        
        // Botones existentes
        const openCreateModalBtn = document.getElementById('openCreateModal');
        const viewAllProjectsBtn = document.getElementById('viewAllProjects');
        const closeModalBtn = document.getElementById('closeModal');
        
        function openModal() {
            // Mostrar el modal
            modal.classList.remove('hidden');
            
            // Animar entrada con efecto de plegado de papel
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                content.classList.remove('scale-90', 'opacity-0', 'translate-y-4');
                content.classList.add('scale-100', 'opacity-100', 'translate-y-0');
            }, 10);
        }
        
        function closeModal() {
            // Animar salida con efecto de plegado
            overlay.classList.add('opacity-0');
            content.classList.remove('scale-100', 'opacity-100', 'translate-y-0');
            content.classList.add('scale-90', 'opacity-0', 'translate-y-4');
            
            // Ocultar el modal después de la animación
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
        
        // Añadir efecto de hover a las tarjetas para mejorar el efecto glassmorphism
        const optionCards = document.querySelectorAll('.group');
        optionCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.classList.add('shadow-glow');
            });
            card.addEventListener('mouseleave', function() {
                this.classList.remove('shadow-glow');
            });
            // Añadir click para cerrar el modal después de seleccionar una opción
            card.addEventListener('click', function() {
                setTimeout(closeModal, 300); // Pequeña demora para ver la animación de hover
            });
        });
        
        // Solo el botón "Create New" abrirá el modal
        if (createNewBtn) createNewBtn.addEventListener('click', openModal);
        closeModalBtn.addEventListener('click', closeModal);
        overlay.addEventListener('click', closeModal);
    });
</script>
@endsection