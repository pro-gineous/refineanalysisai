@extends('layouts.app')

@section('title', 'Notifications Center')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="py-10">
        <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-3xl font-bold leading-tight text-gray-900">
                        Notification Center
                    </h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <form action="{{ route('user.notifications.read-all') }}" method="POST" class="inline-block mr-2">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Mark All as Read
                        </button>
                    </form>
                    <form action="{{ route('user.notifications.delete-all') }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete all notifications?')" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Clear All
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mt-8">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @if($notifications->isEmpty())
                    <div class="bg-white shadow rounded-lg p-12 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">No notifications</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            You don't have any notifications yet. We'll notify you when something important happens.
                        </p>
                    </div>
                @else
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <ul class="divide-y divide-gray-200">
                            @foreach($notifications as $notification)
                                <li class="relative {{ $notification->is_read ? 'bg-white' : 'bg-blue-50' }}">
                                    <div class="px-4 py-5 sm:px-6 flex">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-{{ $notification->type === 'system' ? 'gray' : ($notification->type === 'team' ? 'blue' : 'green') }}-100 flex items-center justify-center">
                                            <!-- Standard notification icon -->
                                            <svg class="w-5 h-5 text-{{ $notification->type === 'system' ? 'gray' : ($notification->type === 'team' ? 'blue' : 'green') }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="flex items-center justify-between">
                                                <h3 class="text-sm font-medium text-gray-900">{{ $notification->title }}</h3>
                                                <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-600">{{ $notification->message }}</p>
                                            
                                            <div class="mt-2 flex space-x-4">
                                                @if(!$notification->is_read)
                                                    <form action="{{ route('user.notifications.read', $notification->id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        <button type="submit" class="text-sm text-blue-600 hover:text-blue-900">
                                                            Mark as read
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                @if($notification->action_url)
                                                    <a href="{{ $notification->action_url }}" class="text-sm text-blue-600 hover:text-blue-900">
                                                        View details
                                                    </a>
                                                @endif
                                                
                                                <form action="{{ route('user.notifications.delete', $notification->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm text-red-600 hover:text-red-900">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
