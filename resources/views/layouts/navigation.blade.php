<nav class="bg-white border-b border-gray-200">
    <div class="w-full px-6 sm:px-10 md:px-16 lg:px-24 xl:px-40">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 ml-0 sm:ml-2 md:ml-4">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('images/logos/refineanalysis.svg') }}" alt="Refine Analysis" class="h-6 sm:h-7 md:h-8 w-auto">
                </a>
            </div>
            
            <!-- Navigation Links - centered with responsive sizing -->
            <div class="hidden md:flex md:flex-1 items-center justify-center space-x-2 sm:space-x-3 md:space-x-4 lg:space-x-5 xl:space-x-6">
                <a href="{{ route('home') }}" class="font-medium text-sm sm:text-base text-[#004D9D] whitespace-nowrap transition-all duration-200 hover:opacity-80">
                    Home
                </a>
                <a href="{{ route('services') }}" class="text-sm sm:text-base text-gray-500 hover:text-gray-900 font-medium whitespace-nowrap transition-all duration-200">
                    Services
                </a>
                <a href="{{ route('solutions') }}" class="text-sm sm:text-base text-gray-500 hover:text-gray-900 font-medium whitespace-nowrap transition-all duration-200">
                    Solutions
                </a>
                <a href="{{ route('features') }}" class="text-sm sm:text-base text-gray-500 hover:text-gray-900 font-medium whitespace-nowrap transition-all duration-200">
                    Features
                </a>
                <a href="{{ route('pricing') }}" class="text-sm sm:text-base text-gray-500 hover:text-gray-900 font-medium whitespace-nowrap transition-all duration-200">
                    Pricing
                </a>
                <a href="{{ route('blog') }}" class="text-sm sm:text-base text-gray-500 hover:text-gray-900 font-medium whitespace-nowrap transition-all duration-200">
                    Blog
                </a>
            </div>
            
            <!-- CTA Buttons -->
            <div class="hidden md:flex items-center space-x-2 sm:space-x-3 lg:space-x-4">
                @guest
                <a href="{{ route('signup') }}" class="bg-[#004D9D] border border-[#004D9D] text-white px-3 sm:px-4 md:px-5 py-1.5 sm:py-2 rounded-md text-xs sm:text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 whitespace-nowrap transition-all duration-200">
                    Get a demo
                </a>
                @endguest
                @guest
                    <a href="{{ route('signin') }}" class="border border-[#004D9D] text-[#004D9D] px-3 sm:px-4 md:px-5 py-1.5 sm:py-2 rounded-md text-xs sm:text-sm font-medium hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 whitespace-nowrap transition-all duration-200">
                        Sign in
                    </a>
                @else
                    <!-- Simplified Notifications Dropdown -->
                    <div class="relative mr-3">
                        <a href="{{ route('user.notifications') }}" class="relative p-1 text-gray-600 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-full">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </a>
                    </div>
                    
                    <a href="{{ route('user.dashboard') }}" class="bg-emerald-600 text-white px-3 sm:px-4 md:px-5 py-1.5 sm:py-2 rounded-md text-xs sm:text-sm font-medium hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 whitespace-nowrap transition-all duration-200 mr-2">
                        My Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0 inline-block">
                        @csrf
                        <button type="submit" class="border border-red-500 text-red-500 px-3 sm:px-4 md:px-5 py-1.5 sm:py-2 rounded-md text-xs sm:text-sm font-medium hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 whitespace-nowrap transition-all duration-200">
                            Sign out
                        </button>
                    </form>
                @endguest
            </div>
            
            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button type="button" id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" aria-controls="mobile-menu" aria-expanded="false">
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile menu -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="flex flex-col items-center text-center pt-4 pb-4 space-y-2 px-4 sm:px-6 md:px-8">
            <a href="{{ route('home') }}" class="block py-2 text-lg font-medium text-[#004D9D] focus:outline-none transition-colors duration-200 w-full">
                Home
            </a>
            <a href="{{ route('services') }}" class="block py-2 text-lg font-medium text-gray-500 hover:text-gray-900 focus:outline-none transition-colors duration-200 w-full">
                Services
            </a>
            <a href="{{ route('solutions') }}" class="block py-2 text-lg font-medium text-gray-500 hover:text-gray-900 focus:outline-none transition-colors duration-200 w-full">
                Solutions
            </a>
            <a href="{{ route('features') }}" class="block py-2 text-lg font-medium text-gray-500 hover:text-gray-900 focus:outline-none transition-colors duration-200 w-full">
                Features
            </a>
            <a href="{{ route('pricing') }}" class="block py-2 text-lg font-medium text-gray-500 hover:text-gray-900 focus:outline-none transition-colors duration-200 w-full">
                Pricing
            </a>
            <a href="{{ route('blog') }}" class="block py-2 text-lg font-medium text-gray-500 hover:text-gray-900 focus:outline-none transition-colors duration-200 w-full">
                Blog
            </a>
            <div class="mt-4 space-y-2 w-full px-4 sm:px-6 md:px-8">
                @guest
                <a href="{{ route('signup') }}" class="block bg-[#004D9D] border border-[#004D9D] text-white px-4 py-2 rounded-md text-lg font-medium transition-colors duration-200 w-full sm:w-4/5 mx-auto">
                    Get a demo
                </a>
                @endguest
                @guest
                    <a href="{{ route('signin') }}" class="block border border-[#004D9D] text-[#004D9D] px-4 py-2 rounded-md text-lg font-medium transition-colors duration-200 w-full sm:w-4/5 mx-auto">
                        Sign in
                    </a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="block bg-emerald-600 text-white px-4 py-2 rounded-md text-lg font-medium transition-colors duration-200 w-full sm:w-4/5 mx-auto mb-2">
                        My Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="sm:w-4/5 mx-auto">
                        @csrf
                        <button type="submit" class="block border border-red-500 text-red-500 px-4 py-2 rounded-md text-lg font-medium transition-colors duration-200 w-full">
                            Sign out
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</nav>

<!-- JavaScript for mobile menu toggle -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    });
</script>