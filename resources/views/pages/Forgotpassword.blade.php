@extends('layouts.app')

@section('content')
<div class="bg-[#1A8AFF] min-h-screen flex justify-center items-center p-4">
    <div class="bg-white rounded-3xl overflow-hidden shadow-xl flex flex-col md:flex-row max-w-6xl w-full">
        <!-- Forgot Password form on the left -->
        <div class="w-full md:w-1/2 p-8 md:p-10">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h2 class="text-gray-800 text-lg font-medium">Can't access your account?</h2>
                    <h1 class="text-[#1A8AFF] text-5xl font-bold mt-2">Reset Password</h1>
                </div>
                <div class="text-right">
                    <p class="text-gray-500 text-sm">Remember your password?</p>
                    <a href="{{ route('signin') }}" class="text-[#1A8AFF] font-medium text-sm">Sign in</a>
                </div>
            </div>

            <div class="mb-8">
                <p class="text-gray-600">Enter the email address associated with your account, and we'll send you a link to reset your password.</p>
            </div>

            <!-- Email Field -->
            <div class="mb-8">
                <label class="flex items-center text-gray-700 mb-2 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Enter your email address
                </label>
                <input type="email" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1A8AFF]" placeholder="Email address">
            </div>

            <!-- Send Reset Link Button -->
            <button type="submit" class="w-full bg-[#0047AB] hover:bg-[#003380] text-white font-medium py-4 px-4 rounded-lg text-lg mb-6">
                Send Reset Link
            </button>

            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('signup') }}" class="text-[#1A8AFF] font-medium">Sign up</a>
                </p>
            </div>
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