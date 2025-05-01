@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F0F4F9] flex flex-col justify-center items-center">
    <!-- Hero Dashboard Banner -->
    <div class="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20 py-4 sm:py-6 md:py-8">
        <div class="max-w-4xl mx-auto">
            <div class="relative overflow-hidden">
                <img src="{{ asset('images/banners/dashboard.png') }}" alt="Dashboard" class="w-full max-w-3xl mx-auto object-cover object-center">
                <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-white to-transparent"></div>
            </div>
        </div>
    </div>
    
    <!-- Frameworks Section with Blue Background -->
    <div class="bg-[#F0F4F9] py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 md:gap-4 lg:gap-6">
                <!-- AI-Powered -->
                <div>
                    <div class="flex items-center mb-3">
                        <div class="text-[#1A8AFF] mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <h3 class="text-xl text-[#1A8AFF] font-bold">AI-Powered</h3>
                    </div>
                    <p class="text-[#85BFFC] ml-13">Get intelligent suggestions at every step</p>
                </div>
                
                <!-- Idea to Project -->
                <div>
                    <div class="flex items-center mb-3">
                        <div class="text-[#1A8AFF] mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl text-[#1A8AFF] font-bold">Idea to Project</h3>
                    </div>
                    <p class="text-[#85BFFC] ml-13">Seamless transition from concept to execution</p>
                </div>
                
                <!-- Multiple Frameworks -->
                <div>
                    <div class="flex items-center mb-3">
                        <div class="text-[#1A8AFF] mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl text-[#1A8AFF] font-bold">Multiple Frameworks</h3>
                    </div>
                    <p class="text-[#85BFFC] ml-13">Choose the right approach for your project</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Available Frameworks Section -->
    <div class="bg-[#F0F4F9] py-10 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Heading with icon -->
            <div class="flex items-center mb-6">
                <div class="text-[#1A8AFF] mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-[#1A8AFF]">Available Frameworks</h2>
            </div>
            
            <!-- Search input -->
            <div class="max-w-md mb-8">
                <div class="relative">
                    <input type="text" id="framework-search" class="w-full rounded-lg border-gray-200 bg-white px-4 py-3 pl-10 focus:border-[#1A8AFF] focus:ring-[#1A8AFF]" placeholder="Search Framework">
                    <div class="absolute left-0 inset-y-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#85BFFC]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Framework cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 framework-cards">
                <!-- Project Management -->
                <div class="bg-[#004D9D] text-white rounded-lg overflow-hidden shadow-md framework-card">
                    <div class="p-6">
                        <div class="flex items-start mb-4">
                            <div class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg">Project Management (PMBOK)</h3>
                        </div>
                        <p class="text-sm mb-6 opacity-90">Project Management Body of Knowledge - a comprehensive project management framework.</p>
                        <div class="text-sm">
                            <a href="#" class="inline-flex items-center text-white">
                                Explore
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Knowledge Management -->
                <div class="bg-[#004D9D] text-white rounded-lg overflow-hidden shadow-md framework-card">
                    <div class="p-6">
                        <div class="flex items-start mb-4">
                            <div class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg">Knowledge Management</h3>
                        </div>
                        <p class="text-sm mb-6 opacity-90">Strategies and processes to identify, capture, structure, and share knowledge within an organization.</p>
                        <div class="text-sm">
                            <a href="#" class="inline-flex items-center text-white">
                                Explore
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Scrum -->
                <div class="bg-[#004D9D] text-white rounded-lg overflow-hidden shadow-md framework-card">
                    <div class="p-6">
                        <div class="flex items-start mb-4">
                            <div class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg">Scrum</h3>
                        </div>
                        <p class="text-sm mb-6 opacity-90">An agile framework for complex product development and delivery.</p>
                        <div class="text-sm">
                            <a href="#" class="inline-flex items-center text-white">
                                Explore
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- PRINCE2 -->
                <div class="bg-[#004D9D] text-white rounded-lg overflow-hidden shadow-md framework-card hidden search-only-card" data-title="PRINCE2" data-description="Projects IN Controlled Environments - a structured project management methodology">
                    <div class="p-6">
                        <div class="flex items-start mb-4">
                            <div class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg">PRINCE2</h3>
                        </div>
                        <p class="text-sm mb-6 opacity-90">Projects IN Controlled Environments - a structured project management methodology.</p>
                        <div class="text-sm">
                            <a href="#" class="inline-flex items-center text-white">
                                Explore
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- TOGAF -->
                <div class="bg-[#004D9D] text-white rounded-lg overflow-hidden shadow-md framework-card hidden search-only-card" data-title="TOGAF" data-description="The Open Group Architecture Framework - enterprise architecture methodology">
                    <div class="p-6">
                        <div class="flex items-start mb-4">
                            <div class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2 0 012-2h2v2" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg">TOGAF</h3>
                        </div>
                        <p class="text-sm mb-6 opacity-90">The Open Group Architecture Framework - enterprise architecture methodology.</p>
                        <div class="text-sm">
                            <a href="#" class="inline-flex items-center text-white">
                                Explore
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Business Analysis -->
                <div class="bg-[#004D9D] text-white rounded-lg overflow-hidden shadow-md framework-card hidden search-only-card" data-title="Business Analysis" data-description="Methods for analyzing business needs and requirements">
                    <div class="p-6">
                        <div class="flex items-start mb-4">
                            <div class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg">Business Analysis</h3>
                        </div>
                        <p class="text-sm mb-6 opacity-90">Methods for analyzing business needs and requirements.</p>
                        <div class="text-sm">
                            <a href="#" class="inline-flex items-center text-white">
                                Explore
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Design Thinking -->
                <div class="bg-[#004D9D] text-white rounded-lg overflow-hidden shadow-md framework-card hidden search-only-card" data-title="Design Thinking" data-description="Human-centered approach to innovation">
                    <div class="p-6">
                        <div class="flex items-start mb-4">
                            <div class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg">Design Thinking</h3>
                        </div>
                        <p class="text-sm mb-6 opacity-90">Human-centered approach to innovation.</p>
                        <div class="text-sm">
                            <a href="#" class="inline-flex items-center text-white">
                                Explore
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Lean -->
                <div class="bg-[#004D9D] text-white rounded-lg overflow-hidden shadow-md framework-card hidden search-only-card" data-title="Lean" data-description="Methodology focused on eliminating waste">
                    <div class="p-6">
                        <div class="flex items-start mb-4">
                            <div class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11H6.248l4.443 4.443a1 1 0 001.414 0l4.443-4.443A1 1 0 0014.752 9l-1.476 1.476z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg">Lean</h3>
                        </div>
                        <p class="text-sm mb-6 opacity-90">Methodology focused on eliminating waste.</p>
                        <div class="text-sm">
                            <a href="#" class="inline-flex items-center text-white">
                                Explore
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- TQM -->
                <div class="bg-[#004D9D] text-white rounded-lg overflow-hidden shadow-md framework-card hidden search-only-card" data-title="TQM" data-description="Total Quality Management">
                    <div class="p-6">
                        <div class="flex items-start mb-4">
                            <div class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg">TQM</h3>
                        </div>
                        <p class="text-sm mb-6 opacity-90">Total Quality Management.</p>
                        <div class="text-sm">
                            <a href="#" class="inline-flex items-center text-white">
                                Explore
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- System Thinking -->
                <div class="bg-[#004D9D] text-white rounded-lg overflow-hidden shadow-md framework-card hidden search-only-card" data-title="System Thinking" data-description="Approach to understanding complex systems">
                    <div class="p-6">
                        <div class="flex items-start mb-4">
                            <div class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg">System Thinking</h3>
                        </div>
                        <p class="text-sm mb-6 opacity-90">Approach to understanding complex systems.</p>
                        <div class="text-sm">
                            <a href="#" class="inline-flex items-center text-white">
                                Explore
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Add all other frameworks as hidden elements -->
            </div>
            
            <!-- More frameworks button -->
            <div class="text-center mt-8">
                <button id="more-frameworks-btn" class="bg-white text-[#1A8AFF] border border-[#1A8AFF] rounded-lg px-8 py-2 font-medium hover:bg-[#F0F4F9] transition duration-200">
                    more frameworks
                </button>
            </div>
        </div>
    </div>
    
    <!-- Frameworks Modal -->
    <div id="frameworks-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="min-h-screen px-4 flex items-center justify-center">
            <div class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm transition-opacity" id="modal-backdrop"></div>
            
            <div class="bg-[#F0F4F9] bg-opacity-95 rounded-xl overflow-hidden shadow-2xl transform transition-all max-w-5xl w-full modal-content relative">
                <!-- Decorative elements -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#004D9D] via-[#1A8AFF] to-[#004D9D]"></div>
                <div class="absolute -top-24 -right-24 w-48 h-48 rounded-full bg-[#1A8AFF] opacity-10 blur-xl"></div>
                <div class="absolute -bottom-32 -left-32 w-64 h-64 rounded-full bg-[#004D9D] opacity-10 blur-xl"></div>
                
                <div class="p-8 relative z-10">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h3 class="text-2xl font-bold text-[#004D9D]">All Frameworks <span class="text-[#1A8AFF]">(43)</span></h3>
                            <p class="text-gray-500 text-sm mt-1">Choose the perfect methodology for your project</p>
                        </div>
                        <button id="close-modal-btn" class="text-[#004D9D] hover:text-[#003980] transition-colors duration-200 bg-white bg-opacity-50 p-2 rounded-full hover:bg-opacity-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mb-6">
                        <div class="relative">
                            <input type="text" id="modal-search" class="w-full rounded-lg border-0 ring-1 ring-gray-200 px-4 py-3 pl-10 focus:border-[#1A8AFF] focus:ring-[#1A8AFF] bg-white shadow-sm" placeholder="Search from all frameworks">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-[#85BFFC]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    
                    <div id="frameworks-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 max-h-[60vh] overflow-y-auto px-1 pb-2 frameworks-grid">
                        <!-- Frameworks will be generated here dynamically -->
                        <div class="bg-[#004D9D] text-white rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl framework-item opacity-0">
                            <div class="p-5">
                                <div class="mb-4 flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-lg text-white">PMBOK</h4>
                                </div>
                                <p class="text-sm text-white opacity-90 mb-4">Project Management Body of Knowledge</p>
                                <div class="flex justify-between items-center">
                                    <div class="text-xs bg-white bg-opacity-20 rounded-full px-2 py-1">Project Management</div>
                                    <a href="#" class="inline-flex items-center justify-center bg-white text-[#004D9D] rounded-lg px-4 py-2 text-sm font-medium hover:bg-opacity-90 transition-all duration-200 shadow-sm">
                                        Explore
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="bg-[#004D9D] text-white rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl framework-item opacity-0">
                            <div class="p-5">
                                <div class="mb-4 flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    </div>
                                    <h4 class="font-semibold text-lg text-white">PRINCE2</h4>
                                </div>
                                <p class="text-sm text-white opacity-90 mb-4">Projects in Controlled Environments</p>
                                <div class="flex justify-between items-center">
                                    <div class="text-xs bg-white bg-opacity-20 rounded-full px-2 py-1">Project Management</div>
                                    <a href="#" class="inline-flex items-center justify-center bg-white text-[#004D9D] rounded-lg px-4 py-2 text-sm font-medium hover:bg-opacity-90 transition-all duration-200 shadow-sm">
                                        Explore
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="bg-[#004D9D] text-white rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl framework-item opacity-0">
                            <div class="p-5">
                                <div class="mb-4 flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    </div>
                                    <h4 class="font-semibold text-lg text-white">Scrum</h4>
                                </div>
                                <p class="text-sm text-white opacity-90 mb-4">Agile project management framework</p>
                                <div class="flex justify-between items-center">
                                    <div class="text-xs bg-white bg-opacity-20 rounded-full px-2 py-1">Agile</div>
                                    <a href="#" class="inline-flex items-center justify-center bg-white text-[#004D9D] rounded-lg px-4 py-2 text-sm font-medium hover:bg-opacity-90 transition-all duration-200 shadow-sm">
                                        Explore
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Project Management (PM) Frameworks -->
                        <div class="bg-[#004D9D] text-white rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl framework-item opacity-0">
                            <div class="p-5">
                                <div class="mb-4 flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2 0 012-2h2v2" />
                                    </svg>
                                    </div>
                                    <h4 class="font-semibold text-lg text-white">TOGAF</h4>
                                </div>
                                <p class="text-sm text-white opacity-90 mb-4">The Open Group Architecture Framework</p>
                                <div class="flex justify-between items-center">
                                    <div class="text-xs bg-white bg-opacity-20 rounded-full px-2 py-1">Architecture</div>
                                    <a href="#" class="inline-flex items-center justify-center bg-white text-[#004D9D] rounded-lg px-4 py-2 text-sm font-medium hover:bg-opacity-90 transition-all duration-200 shadow-sm">
                                        Explore
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#004D9D] text-white rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl framework-item opacity-0">
                            <div class="p-5">
                                <div class="mb-4 flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                    </div>
                                    <h4 class="font-semibold text-lg text-white">Business Analysis</h4>
                                </div>
                                <p class="text-sm text-white opacity-90 mb-4">Methods for analyzing business needs and requirements</p>
                                <div class="flex justify-between items-center">
                                    <div class="text-xs bg-white bg-opacity-20 rounded-full px-2 py-1">Analysis</div>
                                    <a href="#" class="inline-flex items-center justify-center bg-white text-[#004D9D] rounded-lg px-4 py-2 text-sm font-medium hover:bg-opacity-90 transition-all duration-200 shadow-sm">
                                        Explore
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#004D9D] text-white rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl framework-item opacity-0">
                            <div class="p-5">
                                <div class="mb-4 flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                    </svg>
                                    </div>
                                    <h4 class="font-semibold text-lg text-white">Design Thinking</h4>
                                </div>
                                <p class="text-sm text-white opacity-90 mb-4">Human-centered approach to innovation</p>
                                <div class="flex justify-between items-center">
                                    <div class="text-xs bg-white bg-opacity-20 rounded-full px-2 py-1">Innovation</div>
                                    <a href="#" class="inline-flex items-center justify-center bg-white text-[#004D9D] rounded-lg px-4 py-2 text-sm font-medium hover:bg-opacity-90 transition-all duration-200 shadow-sm">
                                        Explore
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#004D9D] text-white rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl framework-item opacity-0">
                            <div class="p-5">
                                <div class="mb-4 flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11H6.248l4.443 4.443a1 1 0 001.414 0l4.443-4.443A1 1 0 0014.752 9l-1.476 1.476z" />
                                    </svg>
                                    </div>
                                    <h4 class="font-semibold text-lg text-white">Lean</h4>
                                </div>
                                <p class="text-sm text-white opacity-90 mb-4">Methodology focused on eliminating waste</p>
                                <div class="flex justify-between items-center">
                                    <div class="text-xs bg-white bg-opacity-20 rounded-full px-2 py-1">Process Improvement</div>
                                    <a href="#" class="inline-flex items-center justify-center bg-white text-[#004D9D] rounded-lg px-4 py-2 text-sm font-medium hover:bg-opacity-90 transition-all duration-200 shadow-sm">
                                        Explore
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#004D9D] text-white rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl framework-item opacity-0">
                            <div class="p-5">
                                <div class="mb-4 flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                    </svg>
                                    </div>
                                    <h4 class="font-semibold text-lg text-white">TQM</h4>
                                </div>
                                <p class="text-sm text-white opacity-90 mb-4">Total Quality Management</p>
                                <div class="flex justify-between items-center">
                                    <div class="text-xs bg-white bg-opacity-20 rounded-full px-2 py-1">Quality</div>
                                    <a href="#" class="inline-flex items-center justify-center bg-white text-[#004D9D] rounded-lg px-4 py-2 text-sm font-medium hover:bg-opacity-90 transition-all duration-200 shadow-sm">
                                        Explore
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#004D9D] text-white rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl framework-item opacity-0">
                            <div class="p-5">
                                <div class="mb-4 flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    </div>
                                    <h4 class="font-semibold text-lg text-white">System Thinking</h4>
                                </div>
                                <p class="text-sm text-white opacity-90 mb-4">Approach to understanding complex systems</p>
                                <div class="flex justify-between items-center">
                                    <div class="text-xs bg-white bg-opacity-20 rounded-full px-2 py-1">Strategy</div>
                                    <a href="#" class="inline-flex items-center justify-center bg-white text-[#004D9D] rounded-lg px-4 py-2 text-sm font-medium hover:bg-opacity-90 transition-all duration-200 shadow-sm">
                                        Explore
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#004D9D] text-white rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl framework-item opacity-0">
                            <div class="p-5">
                                <div class="mb-4 flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                    </div>
                                    <h4 class="font-semibold text-lg text-white">Change Management</h4>
                                </div>
                                <p class="text-sm text-white opacity-90 mb-4">Structured approach to organizational change</p>
                                <div class="flex justify-between items-center">
                                    <div class="text-xs bg-white bg-opacity-20 rounded-full px-2 py-1">Transformation</div>
                                    <a href="#" class="inline-flex items-center justify-center bg-white text-[#004D9D] rounded-lg px-4 py-2 text-sm font-medium hover:bg-opacity-90 transition-all duration-200 shadow-sm">
                                        Explore
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#004D9D] text-white rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl framework-item opacity-0">
                            <div class="p-5">
                                <div class="mb-4 flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                    </div>
                                    <h4 class="font-semibold text-lg text-white">Kaizen</h4>
                                </div>
                                <p class="text-sm text-white opacity-90 mb-4">Continuous improvement methodology</p>
                                <div class="flex justify-between items-center">
                                    <div class="text-xs bg-white bg-opacity-20 rounded-full px-2 py-1">Improvement</div>
                                    <a href="#" class="inline-flex items-center justify-center bg-white text-[#004D9D] rounded-lg px-4 py-2 text-sm font-medium hover:bg-opacity-90 transition-all duration-200 shadow-sm">
                                        Explore
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#004D9D] text-white rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl framework-item opacity-0">
                            <div class="p-5">
                                <div class="mb-4 flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                    </div>
                                    <h4 class="font-semibold text-lg text-white">Idea Management</h4>
                                </div>
                                <p class="text-sm text-white opacity-90 mb-4">Process for capturing and implementing ideas</p>
                                <div class="flex justify-between items-center">
                                    <div class="text-xs bg-white bg-opacity-20 rounded-full px-2 py-1">Innovation</div>
                                    <a href="#" class="inline-flex items-center justify-center bg-white text-[#004D9D] rounded-lg px-4 py-2 text-sm font-medium hover:bg-opacity-90 transition-all duration-200 shadow-sm">
                                        Explore
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#004D9D] text-white rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl framework-item opacity-0">
                            <div class="p-5">
                                <div class="mb-4 flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    </div>
                                    <h4 class="font-semibold text-lg text-white">Digital Transformation</h4>
                                </div>
                                <p class="text-sm text-white opacity-90 mb-4">Strategic integration of digital technologies</p>
                                <div class="flex justify-between items-center">
                                    <div class="text-xs bg-white bg-opacity-20 rounded-full px-2 py-1">Technology</div>
                                    <a href="#" class="inline-flex items-center justify-center bg-white text-[#004D9D] rounded-lg px-4 py-2 text-sm font-medium hover:bg-opacity-90 transition-all duration-200 shadow-sm">
                                        Explore
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#004D9D] text-white rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl framework-item opacity-0">
                            <div class="p-5">
                                <div class="mb-4 flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    </div>
                                    <h4 class="font-semibold text-lg text-white">Six Sigma</h4>
                                </div>
                                <p class="text-sm text-white opacity-90 mb-4">Data-driven methodology for eliminating defects</p>
                                <div class="flex justify-between items-center">
                                    <div class="text-xs bg-white bg-opacity-20 rounded-full px-2 py-1">Quality</div>
                                    <a href="#" class="inline-flex items-center justify-center bg-white text-[#004D9D] rounded-lg px-4 py-2 text-sm font-medium hover:bg-opacity-90 transition-all duration-200 shadow-sm">
                                        Explore
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#004D9D] text-white rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl framework-item opacity-0">
                            <div class="p-5">
                                <div class="mb-4 flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    </div>
                                    <h4 class="font-semibold text-lg text-white">Agile</h4>
                                </div>
                                <p class="text-sm text-white opacity-90 mb-4">Iterative approach to project management</p>
                                <div class="flex justify-between items-center">
                                    <div class="text-xs bg-white bg-opacity-20 rounded-full px-2 py-1">Development</div>
                                    <a href="#" class="inline-flex items-center justify-center bg-white text-[#004D9D] rounded-lg px-4 py-2 text-sm font-medium hover:bg-opacity-90 transition-all duration-200 shadow-sm">
                                        Explore
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#004D9D] text-white rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl framework-item opacity-0">
                            <div class="p-5">
                                <div class="mb-4 flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2 0 012-2h2v2" />
                                    </svg>
                                    </div>
                                    <h4 class="font-semibold text-lg text-white">Customer Experience (CX)</h4>
                                </div>
                                <p class="text-sm text-white opacity-90 mb-4">Framework focused on customer interactions</p>
                                <div class="flex justify-between items-center">
                                    <div class="text-xs bg-white bg-opacity-20 rounded-full px-2 py-1">Customer Focus</div>
                                    <a href="#" class="inline-flex items-center justify-center bg-white text-[#004D9D] rounded-lg px-4 py-2 text-sm font-medium hover:bg-opacity-90 transition-all duration-200 shadow-sm">
                                        Explore
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript for framework search and modal functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Framework search functionality
            const searchInput = document.getElementById('framework-search');
            const frameworkCards = document.querySelectorAll('.framework-card');
            
            searchInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                
                frameworkCards.forEach(card => {
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    const description = card.querySelector('p').textContent.toLowerCase();
                    
                    if (title.includes(searchTerm) || description.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
            
            // Modal functionality with enhanced professional animations
            const modal = document.getElementById('frameworks-modal');
            const modalContent = document.querySelector('.modal-content');
            const modalBtn = document.getElementById('more-frameworks-btn');
            const closeBtn = document.getElementById('close-modal-btn');
            const modalBackdrop = document.getElementById('modal-backdrop');
            const frameworkItems = document.querySelectorAll('.framework-item');
            
            modalBtn.addEventListener('click', function () {
                // First show the modal but keep content hidden
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                
                // Apply initial folded state
                modalContent.style.opacity = '0';
                modalContent.style.transform = 'scale(0.9) rotateX(45deg)';
                modalContent.style.transformOrigin = 'center top';
                modalContent.style.transition = 'transform 0.6s cubic-bezier(0.23, 1, 0.32, 1), opacity 0.5s cubic-bezier(0.23, 1, 0.32, 1)';
                
                // Add blur effect to backdrop
                modalBackdrop.style.backdropFilter = 'blur(0px)';
                modalBackdrop.style.transition = 'backdrop-filter 0.8s ease-out, opacity 0.6s ease-out';
                
                // Force reflow to ensure initial state is applied
                void modalContent.offsetWidth;
                
                // Then unfold with animation
                setTimeout(() => {
                    modalContent.style.opacity = '1';
                    modalContent.style.transform = 'scale(1) rotateX(0deg)';
                    modalBackdrop.style.backdropFilter = 'blur(2px)';
                    
                    // Animate framework cards with staggered timing
                    frameworkItems.forEach((item, index) => {
                        item.style.opacity = '0';
                        item.style.transform = 'translateY(20px)';
                        item.style.transition = 'opacity 0.4s ease-out, transform 0.5s ease-out';
                        
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'translateY(0)';
                        }, 100 + (index * 50)); // Staggered timing
                    });
                }, 50);
            });
            
            function closeModal() {
                // Fold the paper (modal) before hiding
                modalContent.style.opacity = '0';
                modalContent.style.transform = 'scale(0.9) rotateX(45deg)';
                modalBackdrop.style.backdropFilter = 'blur(0px)';
                
                // Reset all framework items
                frameworkItems.forEach(item => {
                    item.style.opacity = '0';
                });
                
                // Wait for animation to complete before hiding the modal
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    
                    // Reset transform for next opening
                    setTimeout(() => {
                        modalContent.style.opacity = '0';
                        modalContent.style.transform = 'scale(0.9) rotateX(45deg)';
                    }, 100);
                }, 500);
            }
            
            closeBtn.addEventListener('click', closeModal);
            modalBackdrop.addEventListener('click', closeModal);
            
            // Modal search functionality with refined animation
            const modalSearch = document.getElementById('modal-search');
            const frameworksContainer = document.getElementById('frameworks-container');
            
            modalSearch.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                let matchCount = 0;
                
                frameworkItems.forEach(item => {
                    const title = item.querySelector('h4').textContent.toLowerCase();
                    const description = item.querySelector('p').textContent.toLowerCase();
                    const shouldShow = title.includes(searchTerm) || description.includes(searchTerm);
                    
                    if (shouldShow) {
                        matchCount++;
                        item.style.display = 'block';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'translateY(0)';
                        }, 50);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'translateY(10px)';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 300);
                    }
                });
                
                // Remove existing message if any
                const existingMessage = document.getElementById('no-results-message');
                if (existingMessage) {
                    existingMessage.remove();
                }
                
                // Show message based on search results
                if (searchTerm && matchCount === 0) {
                    const noResultsMessage = document.createElement('div');
                    noResultsMessage.id = 'no-results-message';
                    noResultsMessage.className = 'col-span-3 text-center py-8 text-gray-500';
                    noResultsMessage.innerHTML = `No frameworks found matching "<strong>${searchTerm}</strong>"`;
                    frameworksContainer.appendChild(noResultsMessage);
                }
                
                // Always ensure search area is visible regardless of search results
                document.querySelector('.mb-6 .relative').style.display = 'block';
            });
        });
        
        // Setup search for main framework cards
        const frameworkSearch = document.getElementById('framework-search');
        const mainFrameworkCards = document.querySelectorAll('.framework-card');
        const searchOnlyCards = document.querySelectorAll('.search-only-card');
        
        frameworkSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            let hasResults = false;
            
            // Remove any no results message
            const existingMessage = document.getElementById('main-no-results');
            if (existingMessage) {
                existingMessage.remove();
            }
            
            // Handle main visible cards
            mainFrameworkCards.forEach(card => {
                if (!card.classList.contains('search-only-card')) {
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    const description = card.querySelector('p').textContent.toLowerCase();
                    
                    if (searchTerm === '' || title.includes(searchTerm) || description.includes(searchTerm)) {
                        card.classList.remove('hidden');
                        hasResults = true;
                    } else {
                        card.classList.add('hidden');
                    }
                }
            });
            
            // Handle hidden cards that should only appear in search results
            searchOnlyCards.forEach(card => {
                const title = card.getAttribute('data-title').toLowerCase();
                const description = card.getAttribute('data-description').toLowerCase();
                
                if (searchTerm !== '' && (title.includes(searchTerm) || description.includes(searchTerm))) {
                    card.classList.remove('hidden');
                    hasResults = true;
                } else {
                    card.classList.add('hidden');
                }
            });
            
            // Show no results message if needed
            if (searchTerm !== '' && !hasResults) {
                const noResults = document.createElement('div');
                noResults.id = 'main-no-results';
                noResults.className = 'col-span-1 sm:col-span-2 lg:col-span-3 text-center py-8 text-gray-500';
                noResults.innerHTML = `No frameworks found matching "<strong>${searchTerm}</strong>"`;
                document.querySelector('.framework-cards').appendChild(noResults);
            }
        });
    </script>
    
    <!-- Available Frameworks -->
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 mb-6 sm:mb-10">
        <h2 class="text-lg sm:text-2xl font-semibold text-gray-800 mb-6">Available Frameworks</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div class="bg-white p-3 sm:p-4 rounded-md shadow border-t-4 border-[#004D9D]">
                <h3 class="text-base sm:text-lg font-medium text-gray-800 mb-2">Project Management</h3>
                <p class="text-sm sm:text-base text-gray-600 mb-4">PRINCE2, Scrum, Kanban, and more for managing projects effectively</p>
                <a href="#" class="bg-[#004D9D] text-white px-4 py-2 rounded-md text-sm font-medium">Explore</a>
            </div>
            <div class="bg-white p-3 sm:p-4 rounded-md shadow border-t-4 border-[#004D9D]">
                <h3 class="text-base sm:text-lg font-medium text-gray-800 mb-2">Quality Management</h3>
                <p class="text-sm sm:text-base text-gray-600 mb-4">Six Sigma, TQM, and other quality assurance methodologies</p>
                <a href="#" class="bg-[#004D9D] text-white px-4 py-2 rounded-md text-sm font-medium">Explore</a>
            </div>
            <div class="bg-white p-3 sm:p-4 rounded-md shadow border-t-4 border-[#004D9D]">
                <h3 class="text-base sm:text-lg font-medium text-gray-800 mb-2">Supply Chain</h3>
                <p class="text-sm sm:text-base text-gray-600 mb-4">Blockchain Supply Chain, SCOR, and other supply chain frameworks</p>
                <a href="#" class="bg-[#004D9D] text-white px-4 py-2 rounded-md text-sm font-medium">Explore</a>
            </div>
        </div>
    </div>
    
    <!-- Features Section -->
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
        <h2 class="text-lg sm:text-2xl font-semibold text-gray-800 mb-6">Features</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 sm:gap-x-6 gap-y-6 sm:gap-y-8">
            <!-- Feature 1 -->
            <div>
                <div class="flex items-center mb-3">
                    <div class="text-[#004D9D] mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-medium text-gray-800">AI-Powered Project Builder</h3>
                </div>
                <p class="text-sm sm:text-base text-gray-600 ml-9">Automatically convert ideas into actionable projects using advanced AI algorithms that analyze your objectives and suggest optimal steps.</p>
            </div>
            
            <!-- Feature 2 -->
            <div>
                <div class="flex items-center mb-3">
                    <div class="text-[#004D9D] mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-medium text-gray-800">Smart Task Management</h3>
                </div>
                <p class="text-sm sm:text-base text-gray-600 ml-9">Intelligent task assignment and tracking that ensures optimal resource allocation and workflow management for maximum efficiency.</p>
            </div>
            
            <!-- Feature 3 -->
            <div>
                <div class="flex items-center mb-3">
                    <div class="text-[#004D9D] mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-medium text-gray-800">Methodology Integration</h3>
                </div>
                <p class="text-sm sm:text-base text-gray-600 ml-9">Seamlessly integrate 43 different frameworks and methodologies to match your specific project requirements and organizational processes.</p>
            </div>
            
            <!-- Feature 4 -->
            <div>
                <div class="flex items-center mb-3">
                    <div class="text-[#004D9D] mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-medium text-gray-800">Live Progress Tracking</h3>
                </div>
                <p class="text-sm sm:text-base text-gray-600 ml-9">Real-time visualization of project progress, resource allocation, and milestone achievement to keep everyone informed and aligned.</p>
            </div>
            
            <!-- Feature 5 -->
            <div>
                <div class="flex items-center mb-3">
                    <div class="text-[#004D9D] mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-medium text-gray-800">Automated Deliverables</h3>
                </div>
                <p class="text-sm sm:text-base text-gray-600 ml-9">Automatically generate professional documentation, reports, and deliverables based on project data and industry best practices.</p>
            </div>
            
            <!-- Feature 6 -->
            <div>
                <div class="flex items-center mb-3">
                    <div class="text-[#004D9D] mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-medium text-gray-800">Enhancing Productivity with AI</h3>
                </div>
                <p class="text-sm sm:text-base text-gray-600 ml-9">Our AI-powered system analyzes patterns and optimizes workflows to increase efficiency and maximize output with minimal human intervention.</p>
            </div>
        </div>
    </div>
    
    <!-- User Types Section -->
    <div class="bg-[#F0F4F9]">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 md:py-12">
            <h2 class="text-lg sm:text-2xl font-semibold text-gray-800 mb-6 sm:mb-10 text-center">Why Choose Refine Analysis?</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
                <!-- For Freelancers -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-base sm:text-xl font-semibold text-gray-800 mb-4">For Freelancers</h3>
                        <p class="text-sm sm:text-base text-gray-600 mb-6">Enhance your productivity and deliver professional results with AI-powered tools and ready-to-use templates.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">✓</span>
                                <span class="text-sm sm:text-base text-gray-700">One-click project setup</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">✓</span>
                                <span class="text-sm sm:text-base text-gray-700">Client-ready professional templates</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">✓</span>
                                <span class="text-sm sm:text-base text-gray-700">AI-generated proposals and contracts</span>
                            </li>
                        </ul>
                        <a href="#" class="inline-block bg-[#004D9D] text-white px-4 py-2 rounded-md text-sm font-medium">Learn More</a>
                    </div>
                    <div class="bg-[#F0F4F9] px-4 sm:px-6 py-4">
                        <img src="https://via.placeholder.com/400x200" class="w-full rounded object-cover object-center" alt="Freelancer Dashboard">
                    </div>
                </div>
                
                <!-- For Agencies -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-base sm:text-xl font-semibold text-gray-800 mb-4">For Agencies</h3>
                        <p class="text-sm sm:text-base text-gray-600 mb-6">Standardize processes, improve collaboration, and scale your consultation services efficiently.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">✓</span>
                                <span class="text-sm sm:text-base text-gray-700">Team collaboration features</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">✓</span>
                                <span class="text-sm sm:text-base text-gray-700">Client portal with real-time updates</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">✓</span>
                                <span class="text-sm sm:text-base text-gray-700">Customizable workflows and templates</span>
                            </li>
                        </ul>
                        <a href="#" class="inline-block bg-[#004D9D] text-white px-4 py-2 rounded-md text-sm font-medium">Learn More</a>
                    </div>
                    <div class="bg-[#F0F4F9] px-4 sm:px-6 py-4">
                        <img src="https://via.placeholder.com/400x200" class="w-full rounded object-cover object-center" alt="Agency Dashboard">
                    </div>
                </div>
                
                <!-- For Enterprises -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-base sm:text-xl font-semibold text-gray-800 mb-4">For Enterprises</h3>
                        <p class="text-sm sm:text-base text-gray-600 mb-6">Transform your business with enterprise-grade project management and knowledge base capabilities.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">✓</span>
                                <span class="text-sm sm:text-base text-gray-700">Enterprise SSO and security features</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">✓</span>
                                <span class="text-sm sm:text-base text-gray-700">Advanced analytics and reporting</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">✓</span>
                                <span class="text-sm sm:text-base text-gray-700">Dedicated support and custom integration</span>
                            </li>
                        </ul>
                        <a href="#" class="inline-block bg-[#004D9D] text-white px-4 py-2 rounded-md text-sm font-medium">Learn More</a>
                    </div>
                    <div class="bg-[#F0F4F9] px-4 sm:px-6 py-4">
                        <img src="https://via.placeholder.com/400x200" class="w-full rounded object-cover object-center" alt="Enterprise Dashboard">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Call to Action -->
    <div class="bg-[#004D9D] text-white py-6 sm:py-8 md:py-12">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-lg sm:text-2xl md:text-3xl font-bold mb-4">Ready to transform your workflow?</h2>
            <p class="text-sm sm:text-base md:text-xl opacity-90 mb-6 sm:mb-8 max-w-3xl mx-auto">
                Start using our AI-powered platform today and experience the future of project management.
            </p>
            <div class="flex flex-wrap justify-center space-x-0 space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="#" class="w-full sm:w-auto bg-white text-[#004D9D] px-6 py-3 rounded-md text-base font-medium hover:bg-opacity-90 transition-all duration-200">
                    Get Started Free
                </a>
                <a href="#" class="w-full sm:w-auto border border-white text-white px-6 py-3 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10 transition-all duration-200">
                    Request Demo
                </a>
            </div>
        </div>
    </div>
</div>
@endsection