<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Refine Analysis') }}</title>
    
    <!-- Protección DOM Global - AI Journey Fix -->
    <script src="{{ asset('js/ai-journey-global-fix.js') }}"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS - Production Version -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Custom Styles for Sidebar and Tooltips -->
    <style>
        /* Tooltip styles */
        .sidebar-tooltip {
            position: relative;
        }
        
        .sidebar-tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(17, 24, 39, 0.9);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            white-space: nowrap;
            z-index: 50;
            margin-left: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        
        /* Logo transitions */
        #fullLogo, #iconLogo {
            transition: opacity 0.3s ease-in-out;
        }
        
        #iconLogo {
            transform: scale(0.8);
        }
        
        /* Sidebar transitions */
        .sidebar-collapsed .sidebar-menu a svg,
        .sidebar-collapsed .bottom-actions a svg,
        .sidebar-collapsed .bottom-actions button svg {
            margin-right: 0 !important;
        }
        
        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .sidebar-collapsed {
                transform: translateX(-100%);
            }
        }
        
        /* Smooth icon transitions */
        .sidebar-menu a svg,
        .bottom-actions a svg,
        .bottom-actions button svg {
            transition: margin 0.3s ease, transform 0.3s ease;
        }
        
        .sidebar-tooltip:hover svg {
            transform: scale(1.1);
            color: #3B82F6;
        }
        
        /* Active menu item adjustments for collapsed state */
        .sidebar-collapsed .sidebar-menu a.bg-blue-600 {
            background-color: transparent !important;
        }
        
        .sidebar-collapsed .sidebar-menu a.bg-blue-600 svg {
            color: #3B82F6;
        }
        
        /* Bottom actions styling in collapsed state */
        .sidebar-collapsed .bottom-actions a,
        .sidebar-collapsed .bottom-actions button {
            padding: 0.75rem 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: transparent !important;
            border: none !important;
            /* Remove border, background and other styles */
            box-shadow: none !important;
        }
        
        .sidebar-collapsed .bottom-actions a svg,
        .sidebar-collapsed .bottom-actions button svg {
            color: #6B7280 !important; /* Default gray color */
        }
        
        /* Keep special colors for hover */
        .sidebar-collapsed .bottom-actions a:hover svg,
        .sidebar-collapsed .bottom-actions button:hover svg {
            color: #3B82F6 !important; /* Blue on hover */
        }
        
        /* Special color for Home icon */
        .sidebar-collapsed .bottom-actions a[data-tooltip-text="Home"]:hover svg {
            color: #3B82F6 !important;
        }
        
        /* Special color for Sign out icon */
        .sidebar-collapsed .bottom-actions button[data-tooltip-text="Sign out"]:hover svg {
            color: #EF4444 !important; /* Red on hover */
        }
        
        /* Remove form margin */
        .sidebar-collapsed .sign-out-form {
            margin: 0 !important;
        }
    </style>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        blue: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        primary: {
                            DEFAULT: '#0284c7',
                            dark: '#0369a1',
                        },
                        background: '#F0F4F9'
                    }
                }
            }
        }
    </script>
    
    <!-- Custom CSS -->
    <style>
        [x-cloak] { display: none !important; }
        .fade-enter-active, .fade-leave-active {
            transition: opacity .3s;
        }
        .fade-enter, .fade-leave-to {
            opacity: 0;
        }
    </style>
    
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
</head>
<body class="font-sans antialiased bg-white">
    <div class="flex min-h-screen">
        <!-- Left Sidebar -->
        <div id="sidebar" class="w-[280px] bg-[#f3f8ff] border-r border-gray-200 flex flex-col fixed h-full left-0 top-0 z-20 transition-all duration-300 ease-in-out overflow-x-hidden">
            <div class="sidebar-overlay fixed inset-0 bg-gray-800 bg-opacity-50 z-10 lg:hidden hidden" id="sidebarOverlay"></div>
            <!-- Logo Section -->
            <div class="h-[72px] border-b border-gray-200 flex items-center justify-center transition-all duration-300">
                <!-- Logo full version (visible when sidebar expanded) -->
                <img id="fullLogo" src="{{ asset('images/logos/refineanalysis.svg') }}" alt="Refine Analysis" class="h-8 transition-opacity duration-300" onerror="this.onerror=null; this.src='https://placeholder.pics/svg/180x40/2079FF-2079FF/FFFFFF-FFFFFF/Refine%20Analysis'; this.classList.add('rounded')">
                
                <!-- Icon version (visible when sidebar collapsed) -->
                <img id="iconLogo" src="{{ asset('images/logos/Refine-Analysis-icon.svg') }}" alt="Refine Analysis" class="h-8 absolute opacity-0 transition-opacity duration-300" onerror="this.onerror=null; this.src='https://placeholder.pics/svg/40x40/2079FF-2079FF/FFFFFF-FFFFFF/RA'; this.classList.add('rounded')">
            </div>
            
            <!-- Navigation Menu -->
            <div class="flex-1 overflow-y-auto pt-3 sidebar-menu">
                <a href="{{ route('user.dashboard') }}" class="flex items-center px-5 py-3 bg-blue-600 text-white mb-1 mx-3 rounded-lg">
                    <svg class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('user.ideas-projects') }}" class="flex items-center px-5 py-3 text-blue-300 hover:text-blue-500 hover:bg-blue-50 mb-1 mx-3 rounded-lg {{ request()->routeIs('user.ideas-projects') || request()->routeIs('user.ideas*') || request()->routeIs('user.projects*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <svg class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <span class="font-medium">Ideas & Projects</span>
                </a>
                
                <a href="#" class="flex items-center px-5 py-3 text-blue-300 hover:text-blue-500 mb-1 mx-3 rounded-lg">
                    <svg class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">Testing & Quality</span>
                </a>
                
                <a href="#" class="flex items-center px-5 py-3 text-blue-300 hover:text-blue-500 mb-1 mx-3 rounded-lg">
                    <svg class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    <span class="font-medium">Activity Feed</span>
                </a>
                
                <a href="#" class="flex items-center px-5 py-3 text-blue-300 hover:text-blue-500 mb-1 mx-3 rounded-lg">
                    <svg class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span class="font-medium">Analytics & Reports</span>
                </a>
                
                <a href="#" class="flex items-center px-5 py-3 text-blue-300 hover:text-blue-500 mb-1 mx-3 rounded-lg">
                    <svg class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span class="font-medium">Knowledge Base</span>
                </a>
                
                <a href="#" class="flex items-center px-5 py-3 text-blue-300 hover:text-blue-500 mb-1 mx-3 rounded-lg">
                    <svg class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                    </svg>
                    <span class="font-medium">Templates</span>
                </a>
                
                <a href="#" class="flex items-center px-5 py-3 text-blue-300 hover:text-blue-500 mb-1 mx-3 rounded-lg">
                    <svg class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                    <span class="font-medium">Integrations</span>
                </a>
            </div>
            
            <!-- Bottom Actions -->
            <div class="mt-auto p-4 border-t border-gray-100 bottom-actions">
                <a href="#" class="flex items-center px-5 py-3 text-gray-600 mb-2 mx-3 rounded-lg bottom-link" data-tooltip-text="Help & Support">
                    <svg class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">Help & Support</span>
                </a>
                
                <a href="{{ route('home') }}" class="flex items-center justify-center px-5 py-3 bg-blue-500 text-white mb-2 mx-3 rounded-lg bottom-link" data-tooltip-text="Home">
                    <svg class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="font-medium">Home</span>
                </a>
                
                <a href="{{ route('user.settings') }}" class="flex items-center justify-center px-5 py-3 border border-gray-200 text-gray-600 mb-2 mx-3 rounded-lg bottom-link" data-tooltip-text="Settings">
                    <svg class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c-.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-medium">Settings</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="mb-2 mx-3 sign-out-form">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-5 py-3 border border-red-200 rounded-lg text-red-500 bottom-link" data-tooltip-text="Sign out">
                        <svg class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v6" />
                        </svg>
                        <span class="font-medium">Sign out</span>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div id="mainContent" class="ml-[280px] flex-1 transition-all duration-300 ease-in-out">
            <!-- Top Navigation Bar - Ahora es fixed en lugar de sticky -->
            <header class="bg-white border-b border-gray-200 fixed top-0 right-0 left-[280px] z-10 transition-all duration-300 ease-in-out">
                <div class="h-[72px] flex items-center justify-between px-6">
                    <!-- Left: Menu Toggle -->
                    <div class="flex items-center">
                        <button id="sidebarToggle" class="text-gray-500 hover:text-blue-600 focus:outline-none transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Center: Search -->
                    <div class="flex-1 flex justify-center px-6">
                        <form action="{{ route('user.search') }}" method="GET" class="w-full max-w-md" id="searchForm">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="query" id="search" placeholder="Search in your data" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm" autocomplete="off">
                                <div id="searchResults" class="absolute left-0 right-0 mt-2 bg-white rounded-lg shadow-lg border border-gray-200 z-20 max-h-64 overflow-y-auto hidden"></div>
                            </div>
                        </form>
                        
                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const searchInput = document.getElementById('search');
                            const searchResults = document.getElementById('searchResults');
                            const searchForm = document.getElementById('searchForm');
                            
                            // Búsqueda en tiempo real
                            searchInput.addEventListener('input', debounce(function() {
                                const query = searchInput.value.trim();
                                if (query.length < 2) {
                                    searchResults.innerHTML = '';
                                    searchResults.classList.add('hidden');
                                    return;
                                }
                                
                                fetch(`/api/user-search?query=${encodeURIComponent(query)}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        searchResults.innerHTML = '';
                                        searchResults.classList.remove('hidden');
                                        
                                        if (data.length === 0) {
                                            searchResults.innerHTML = '<div class="p-3 text-sm text-gray-500">No results found</div>';
                                            return;
                                        }
                                        
                                        data.forEach(item => {
                                            const resultItem = document.createElement('a');
                                            resultItem.href = item.url;
                                            resultItem.className = 'block p-3 hover:bg-gray-50 border-b border-gray-100 last:border-0';
                                            
                                            resultItem.innerHTML = `
                                                <div class="text-sm font-medium text-gray-900">${item.title}</div>
                                                <div class="text-xs text-gray-500">${item.type}</div>
                                            `;
                                            
                                            searchResults.appendChild(resultItem);
                                        });
                                    });
                            }, 300));
                            
                            // Ocultar resultados al hacer clic fuera
                            document.addEventListener('click', function(e) {
                                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                                    searchResults.classList.add('hidden');
                                }
                            });
                            
                            // Enviar formulario
                            searchForm.addEventListener('submit', function(e) {
                                const query = searchInput.value.trim();
                                if (query.length < 2) {
                                    e.preventDefault();
                                }
                            });
                            
                            // Función auxiliar para debounce
                            function debounce(func, wait) {
                                let timeout;
                                return function() {
                                    const context = this;
                                    const args = arguments;
                                    clearTimeout(timeout);
                                    timeout = setTimeout(() => func.apply(context, args), wait);
                                };
                            }
                        });
                        </script>

                        <!-- Sidebar Toggle Script -->
                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const sidebar = document.getElementById('sidebar');
                            const mainContent = document.getElementById('mainContent');
                            const sidebarToggle = document.getElementById('sidebarToggle');
                            const sidebarOverlay = document.getElementById('sidebarOverlay');
                            const isMobile = window.innerWidth < 1024;
                            
                            // Check for saved state
                            const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                            
                            // Initialize sidebar state
                            if (sidebarCollapsed) {
                                collapseSidebar();
                            }
                            
                            // Toggle sidebar on button click
                            sidebarToggle.addEventListener('click', function() {
                                if (sidebar.classList.contains('sidebar-collapsed')) {
                                    expandSidebar();
                                } else {
                                    collapseSidebar();
                                }
                            });
                            
                            // Close sidebar when clicking overlay on mobile
                            sidebarOverlay.addEventListener('click', function() {
                                if (isMobile) {
                                    collapseSidebar();
                                }
                            });
                            
                            // Functions to collapse and expand sidebar
                            function collapseSidebar() {
                                if (isMobile) {
                                    sidebar.classList.add('-translate-x-full');
                                    sidebarOverlay.classList.add('hidden');
                                } else {
                                    sidebar.classList.add('sidebar-collapsed');
                                    document.body.classList.add('sidebar-collapsed-body');
                                    sidebar.style.width = '72px';
                                    mainContent.style.marginLeft = '72px';
                                    
                                    // Ajustar la barra superior
                                    const header = document.querySelector('header');
                                    if (header) {
                                        header.style.left = '72px';
                                    }
                                    
                                    // Switch logo
                                    const fullLogo = document.getElementById('fullLogo');
                                    const iconLogo = document.getElementById('iconLogo');
                                    if (fullLogo && iconLogo) {
                                        fullLogo.classList.add('opacity-0');
                                        iconLogo.classList.remove('opacity-0');
                                    }
                                    
                                    // Style sidebar links for collapsed state
                                    const sidebarMenuLinks = sidebar.querySelectorAll('.sidebar-menu a');
                                    sidebarMenuLinks.forEach(link => {
                                        // Center icons and add tooltip
                                        link.classList.add('justify-center', 'sidebar-tooltip');
                                        
                                        // Create tooltip with link text
                                        const span = link.querySelector('span');
                                        if (span) {
                                            const tooltipText = span.textContent.trim();
                                            link.setAttribute('data-tooltip', tooltipText);
                                            span.classList.add('hidden');
                                        }
                                        
                                        // Adjust padding for collapsed state
                                        link.classList.add('px-2');
                                        link.classList.remove('px-5');
                                    });
                                    
                                    // Style bottom action links differently (only icons)
                                    const bottomLinks = sidebar.querySelectorAll('.bottom-actions a, .bottom-actions button');
                                    bottomLinks.forEach(link => {
                                        // Center icons and add tooltip
                                        link.classList.add('justify-center', 'sidebar-tooltip', 'icon-only');
                                        
                                        // Create tooltip with link text
                                        const span = link.querySelector('span');
                                        if (span) {
                                            const tooltipText = span.textContent.trim();
                                            link.setAttribute('data-tooltip', tooltipText);
                                            span.classList.add('hidden');
                                        } else if (link.hasAttribute('data-tooltip-text')) {
                                            // Use predefined tooltip text for bottom links
                                            const tooltipText = link.getAttribute('data-tooltip-text');
                                            link.setAttribute('data-tooltip', tooltipText);
                                        }
                                    });
                                }
                                localStorage.setItem('sidebarCollapsed', 'true');
                            }
                            
                            function expandSidebar() {
                                if (isMobile) {
                                    sidebar.classList.remove('-translate-x-full');
                                    sidebarOverlay.classList.remove('hidden');
                                } else {
                                    sidebar.classList.remove('sidebar-collapsed');
                                    document.body.classList.remove('sidebar-collapsed-body');
                                    sidebar.style.width = '280px';
                                    mainContent.style.marginLeft = '280px';
                                    
                                    // Ajustar la barra superior al expandir
                                    const header = document.querySelector('header');
                                    if (header) {
                                        header.style.left = '280px';
                                    }
                                    
                                    // Switch logo back
                                    const fullLogo = document.getElementById('fullLogo');
                                    const iconLogo = document.getElementById('iconLogo');
                                    if (fullLogo && iconLogo) {
                                        fullLogo.classList.remove('opacity-0');
                                        iconLogo.classList.add('opacity-0');
                                    }
                                    
                                    // Restore all sidebar links to expanded state
                                    const allLinks = sidebar.querySelectorAll('.sidebar-menu a, .bottom-actions a, .bottom-actions button');
                                    allLinks.forEach(link => {
                                        // Remove tooltip, center alignment and icon-only class
                                        link.classList.remove('justify-center', 'sidebar-tooltip', 'icon-only');
                                        link.removeAttribute('data-tooltip');
                                        
                                        // Show text
                                        const span = link.querySelector('span');
                                        if (span) span.classList.remove('hidden');
                                    });
                                    
                                    // Restore padding only for menu links
                                    const menuLinks = sidebar.querySelectorAll('.sidebar-menu a');
                                    menuLinks.forEach(link => {
                                        link.classList.remove('px-2');
                                        link.classList.add('px-5');
                                    });
                                    
                                    // Restore bottom links styles
                                    const bottomLinks = sidebar.querySelectorAll('.bottom-actions a, .bottom-actions button');
                                    bottomLinks.forEach(link => {
                                        if (link.classList.contains('bg-blue-500')) {
                                            link.classList.add('text-white');
                                        }
                                    });
                                }
                                localStorage.setItem('sidebarCollapsed', 'false');
                            }
                            
                            // Handle window resize
                            window.addEventListener('resize', function() {
                                const newIsMobile = window.innerWidth < 1024;
                                if (newIsMobile !== isMobile) {
                                    location.reload();
                                }
                            });
                        });
                        </script>
                    </div>
                    
                    <!-- Right: User -->
                    <div class="flex items-center">
                        <!-- Notifications Dropdown -->
                        <div class="relative mr-3" x-data="{ open: false, notifications: [], unreadCount: 0 }" @click.away="open = false" x-init="
                            // Load notifications on page load
                            fetch('{{ route("user.notifications.header") }}')
                                .then(response => response.json())
                                .then(data => {
                                    notifications = data.notifications;
                                    unreadCount = data.unreadCount;
                                });
                                
                            // Refresh notifications every minute
                            setInterval(() => {
                                fetch('{{ route("user.notifications.header") }}')
                                    .then(response => response.json())
                                    .then(data => {
                                        notifications = data.notifications;
                                        unreadCount = data.unreadCount;
                                    });
                            }, 60000);
                        ">
                            <button @click="open = !open" class="relative p-1 text-gray-600 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-full">
                                <span class="sr-only">View notifications</span>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <!-- Notification Badge -->
                                <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"></span>
                            </button>
                            
                            <!-- Dropdown menu -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-100" 
                                 x-transition:enter-start="transform opacity-0 scale-95" 
                                 x-transition:enter-end="transform opacity-100 scale-100" 
                                 x-transition:leave="transition ease-in duration-75" 
                                 x-transition:leave-start="transform opacity-100 scale-100" 
                                 x-transition:leave-end="transform opacity-0 scale-95" 
                                 class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" 
                                 x-cloak>
                                <div class="py-1">
                                    <div class="px-4 py-2 border-b border-gray-100 flex justify-between items-center">
                                        <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                                        <a href="{{ route('user.notifications') }}" class="text-xs text-blue-600 hover:text-blue-900">View all</a>
                                    </div>
                                    
                                    <template x-if="notifications.length === 0">
                                        <div class="px-4 py-3 text-sm text-gray-500 text-center">
                                            No notifications yet
                                        </div>
                                    </template>
                                    
                                    <template x-for="notification in notifications" :key="notification.id">
                                        <div :class="{'bg-blue-50': !notification.is_read, 'hover:bg-gray-50': notification.is_read}" class="group">
                                            <a :href="notification.action_url || '{{ route("user.notifications") }}'" class="block px-4 py-2">
                                                <div class="flex items-start">
                                                    <div class="flex-shrink-0 mt-0.5">
                                                        <div class="h-5 w-5 text-gray-400">
                                                            <template x-if="notification.icon">
                                                                <div x-html="notification.icon"></div>
                                                            </template>
                                                            <template x-if="!notification.icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                                                </svg>
                                                            </template>
                                                        </div>
                                                    </div>
                                                    <div class="ml-3 flex-1">
                                                        <p class="text-sm font-medium text-gray-800" x-text="notification.title"></p>
                                                        <p class="mt-1 text-xs text-gray-500" x-text="notification.message"></p>
                                                        <p class="mt-1 text-xs text-gray-400" x-text="notification.created_at"></p>
                                                        <div class="mt-1 flex justify-between items-center">
                                                            <button @click.stop.prevent="
                                                                let token = document.querySelector('meta[name=\'csrf-token\']').getAttribute('content');
                                                                fetch('/user/notifications/' + notification.id + '/read', {
                                                                    method: 'POST',
                                                                    headers: {
                                                                        'Content-Type': 'application/json',
                                                                        'X-CSRF-TOKEN': token
                                                                    }
                                                                })
                                                                .then(response => response.json())
                                                                .then(data => {
                                                                    if (data.success) {
                                                                        notification.is_read = true;
                                                                        unreadCount = Math.max(0, unreadCount - 1);
                                                                    }
                                                                });
                                                            " x-show="!notification.is_read" class="text-xs text-blue-600 hover:text-blue-900 hidden group-hover:block">Mark as read</button>
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </template>
                                    
                                    <div class="border-t border-gray-100 px-4 py-2">
                                        <div class="flex justify-between">
                                            <button @click.stop.prevent="
                                                let token = document.querySelector('meta[name=\'csrf-token\']').getAttribute('content');
                                                fetch('{{ route("user.notifications.read-all") }}', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': token
                                                    }
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.success) {
                                                        notifications.forEach(n => n.is_read = true);
                                                        unreadCount = 0;
                                                    }
                                                })
                                                .catch(error => console.error('Error marking all as read:', error));
                                            " class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed" :disabled="unreadCount === 0">
                                                Mark all as read
                                            </button>
                                            <a href="{{ route('user.notifications') }}" class="text-xs text-gray-500 hover:text-gray-700">
                                                Manage notifications
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('user.settings') }}" class="overflow-hidden rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @if(Auth::user()->profile_image)
                                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }}" class="profile-image h-8 w-8 rounded-full object-cover border border-gray-200">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=905&color=fff" alt="User" class="profile-image h-8 w-8 rounded-full">
                            @endif
                        </a>
                    </div>
                </div>
            </header>
            
            <!-- Main Content -->
            <main class="p-6 pt-[84px]">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
