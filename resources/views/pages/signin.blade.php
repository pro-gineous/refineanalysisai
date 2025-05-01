@extends('layouts.app')

@section('content')
<div class="bg-[#1A8AFF] min-h-screen flex justify-center items-center p-4">
    <div class="bg-white rounded-3xl overflow-hidden shadow-xl flex flex-col md:flex-row max-w-6xl w-full">
        <!-- Sign in form on the left -->
        <div class="w-full md:w-1/2 p-8 md:p-10">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h2 class="text-gray-800 text-lg font-medium">Welcome back to <span class="text-[#1A8AFF] font-bold">Refine Analysis</span></h2>
                    <h1 class="text-[#1A8AFF] text-5xl font-bold mt-2">Sign in</h1>
                </div>
                <div class="text-right">
                    <p class="text-gray-500 text-sm">Need an Account?</p>
                    <a href="{{ route('signup') }}" class="text-[#1A8AFF] font-medium text-sm">Sign up</a>
                </div>
            </div>

            <!-- Display validation errors if any -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Google Sign In Button -->
                <div class="mb-8">
                    <button type="button" class="w-full bg-[#F0F4F9] hover:bg-gray-100 text-[#1A56DB] font-medium py-4 px-6 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        Sign In with Google
                    </button>
                </div>

                <!-- Username/Email Field -->
                <div class="mb-6">
                    <label class="flex items-center text-gray-700 mb-2 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Enter your username or email address
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1A8AFF]" placeholder="Email address" required>
                </div>

                <!-- Password Field -->
                <div class="mb-4">
                    <label class="flex items-center text-gray-700 mb-2 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Enter your Password
                    </label>
                    <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1A8AFF]" placeholder="Password" required>
                </div>

                <!-- Forgot Password -->
                <div class="flex justify-end mb-8">
                    <a href="{{ route('forgotpassword') }}" class="text-[#1A8AFF] text-sm font-medium hover:underline">Forgot password?</a>
                </div>

                <!-- Sign In Button -->
                <button type="submit" class="w-full bg-[#0047AB] hover:bg-[#003380] text-white font-medium py-4 px-4 rounded-lg text-lg">
                    Sign in
                </button>
            </form>
        </div>

        <!-- Dashboard Image on the right -->
        <div class="hidden md:block w-1/2 bg-[#1A8AFF]">
            <div class="h-full flex items-center justify-center p-6 relative">
                <img src="{{ asset('images/banners/dashboard.png') }}" alt="Dashboard Preview" class="w-full h-auto object-contain max-w-lg">
                <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-[#1A8AFF] to-transparent"></div>
            </div>
        </div>
    </div>
</div>
@endsection