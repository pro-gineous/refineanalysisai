@extends('layouts.dashboard')

@section('content')
<div class="bg-white min-h-screen">
    <!-- Header -->
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center">
            <div class="text-blue-600 mr-2">
                <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-semibold text-blue-700">Settings</h1>
                <p class="text-blue-600 text-sm">Manage your account and application preferences</p>
            </div>
        </div>
    </div>
    
    <!-- Success messages -->
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif
    
    <!-- Main container -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Navigation menu -->
        <div class="bg-white border-b border-gray-100">
            <nav class="flex" aria-label="Tabs">
                <a href="{{ route('user.settings', ['tab' => 'profile']) }}" class="{{ request('tab') == 'profile' || request('tab') == null ? 'text-blue-600 border-b-2 border-blue-500' : 'text-gray-500 hover:text-blue-600' }} whitespace-nowrap py-4 px-6 font-medium text-sm">
                    Profile
                </a>
                <a href="{{ route('user.settings', ['tab' => 'security']) }}" class="{{ request('tab') == 'security' ? 'text-blue-600 border-b-2 border-blue-500' : 'text-gray-500 hover:text-blue-600' }} whitespace-nowrap py-4 px-6 font-medium text-sm">
                    Account Security
                </a>
                <a href="{{ route('user.settings', ['tab' => 'team']) }}" class="{{ request('tab') == 'team' ? 'text-blue-600 border-b-2 border-blue-500' : 'text-gray-500 hover:text-blue-600' }} whitespace-nowrap py-4 px-6 font-medium text-sm">
                    Add Member
                </a>
                <a href="{{ route('user.notification-preferences') }}" class="{{ request()->routeIs('user.notification-preferences') || request('tab') == 'notifications' ? 'text-blue-600 border-b-2 border-blue-500' : 'text-gray-500 hover:text-blue-600' }} whitespace-nowrap py-4 px-6 font-medium text-sm">
                    Notifications
                </a>
                <a href="{{ route('user.settings', ['tab' => 'branding']) }}" class="{{ request('tab') == 'branding' ? 'text-blue-600 border-b-2 border-blue-500' : 'text-gray-500 hover:text-blue-600' }} whitespace-nowrap py-4 px-6 font-medium text-sm">
                    Branding
                </a>
                <a href="{{ route('user.settings', ['tab' => 'advanced']) }}" class="{{ request('tab') == 'advanced' ? 'text-blue-600 border-b-2 border-blue-500' : 'text-gray-500 hover:text-blue-600' }} whitespace-nowrap py-4 px-6 font-medium text-sm">
                    Advanced
                </a>
            </nav>
        </div>
        
        <!-- Section content -->
        <div class="p-6">
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <div class="flex items-center mb-2">
                    <svg class="h-6 w-6 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <h2 class="text-lg font-semibold text-gray-900">Notification Preferences</h2>
                </div>
                <p class="text-gray-600 mb-6 ml-8">Control how and when you receive notifications</p>

                <form action="{{ route('user.notification-preferences.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Project Updates -->
                        <div>
                            <h3 class="text-base font-medium text-gray-900 mb-1">Project Updates</h3>
                            <p class="text-sm text-blue-400 mb-2">Receive notifications about project status change</p>
                            <div class="relative inline-block w-14 align-middle select-none">
                                <input type="checkbox" name="project_updates" id="project_updates" class="sr-only" {{ $preferences->project_updates ? 'checked' : '' }}>
                                <div class="block bg-blue-200 w-14 h-8 rounded-full toggle-bg"></div>
                                <label for="project_updates" class="toggle-label absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-transform duration-300 ease-in-out cursor-pointer"></label>
                            </div>
                        </div>

                        <!-- Mentions -->
                        <div>
                            <h3 class="text-base font-medium text-gray-900 mb-1">Mentions</h3>
                            <p class="text-sm text-blue-400 mb-2">Notify me when I'm mentioned in a comment</p>
                            <div class="relative inline-block w-14 align-middle select-none">
                                <input type="checkbox" name="mentions" id="mentions" class="sr-only" {{ $preferences->mentions ? 'checked' : '' }}>
                                <div class="block bg-blue-200 w-14 h-8 rounded-full toggle-bg"></div>
                                <label for="mentions" class="toggle-label absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-transform duration-300 ease-in-out cursor-pointer"></label>
                            </div>
                        </div>

                        <!-- Task Assignments -->
                        <div>
                            <h3 class="text-base font-medium text-gray-900 mb-1">Task Assignments</h3>
                            <p class="text-sm text-blue-400 mb-2">Notify me when I'm assigned a new task</p>
                            <div class="relative inline-block w-14 align-middle select-none">
                                <input type="checkbox" name="task_assignments" id="task_assignments" class="sr-only" {{ $preferences->task_assignments ? 'checked' : '' }}>
                                <div class="block bg-blue-200 w-14 h-8 rounded-full toggle-bg"></div>
                                <label for="task_assignments" class="toggle-label absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-transform duration-300 ease-in-out cursor-pointer"></label>
                            </div>
                        </div>

                        <!-- Deadlines -->
                        <div>
                            <h3 class="text-base font-medium text-gray-900 mb-1">Deadlines</h3>
                            <p class="text-sm text-blue-400 mb-2">Notify me about upcoming and overdue deadlines</p>
                            <div class="relative inline-block w-14 align-middle select-none">
                                <input type="checkbox" name="deadlines" id="deadlines" class="sr-only" {{ $preferences->deadlines ? 'checked' : '' }}>
                                <div class="block bg-blue-200 w-14 h-8 rounded-full toggle-bg"></div>
                                <label for="deadlines" class="toggle-label absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-transform duration-300 ease-in-out cursor-pointer"></label>
                            </div>
                        </div>

                        <!-- Comments -->
                        <div>
                            <h3 class="text-base font-medium text-gray-900 mb-1">Comments</h3>
                            <p class="text-sm text-blue-400 mb-2">Notify me when someone comments on my tasks</p>
                            <div class="relative inline-block w-14 align-middle select-none">
                                <input type="checkbox" name="comments" id="comments" class="sr-only" {{ $preferences->comments ? 'checked' : '' }}>
                                <div class="block bg-blue-200 w-14 h-8 rounded-full toggle-bg"></div>
                                <label for="comments" class="toggle-label absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-transform duration-300 ease-in-out cursor-pointer"></label>
                            </div>
                        </div>

                        <!-- Team Invitations -->
                        <div>
                            <h3 class="text-base font-medium text-gray-900 mb-1">Team Invitations</h3>
                            <p class="text-sm text-blue-400 mb-2">Notify me about team invitations and responses</p>
                            <div class="relative inline-block w-14 align-middle select-none">
                                <input type="checkbox" name="team_invitations" id="team_invitations" class="sr-only" {{ $preferences->team_invitations ? 'checked' : '' }}>
                                <div class="block bg-blue-200 w-14 h-8 rounded-full toggle-bg"></div>
                                <label for="team_invitations" class="toggle-label absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-transform duration-300 ease-in-out cursor-pointer"></label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-8">
                        <button type="reset" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 bg-white text-sm font-medium hover:bg-gray-50">
                            Reset
                        </button>
                        <button type="submit" class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Toggle switch design */
    input:checked ~ .toggle-bg {
        background-color: #1E40AF;
    }
    input:checked ~ .toggle-label {
        transform: translateX(100%);
        background-color: white;
    }
    .toggle-label {
        transform: translateX(0%);
    }
</style>
@endsection
