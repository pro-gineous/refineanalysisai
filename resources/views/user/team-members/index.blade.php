@extends('layouts.dashboard')

@section('content')
<div class="p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">Team Members</h1>

    @if (session('success'))
        <div class="mb-4 text-green-600 bg-green-100 p-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 text-red-600 bg-red-100 p-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('user.team-members.store') }}" method="POST" class="mb-6">
        @csrf
        <div class="flex items-center space-x-2">
            <input type="email" name="email" placeholder="Enter team member email" class="flex-1 p-2 border border-gray-300 rounded-lg" required>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Add Member</button>
        </div>
        @error('email')
            <div class="mt-2 text-red-600 text-sm">{{ $message }}</div>
        @enderror
    </form>

    <h2 class="text-xl font-semibold mb-2">Your Team Members</h2>
    <div class="space-y-4 mb-8">
        @foreach ($teamMembers as $member)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <span class="font-medium">{{ $member->teamMember->name }}</span>
                    <span class="text-sm text-gray-500">{{ $member->teamMember->email }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Status: {{ ucfirst($member->status) }}</span>
                    <form action="{{ route('user.team-members.destroy', $member) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Remove</button>
                    </form>
                </div>
            </div>
        @endforeach

        @if($teamMembers->isEmpty())
            <div class="text-center text-gray-500 py-6">No team members yet. Add members to collaborate on projects.</div>
        @endif
    </div>

    <h2 class="text-xl font-semibold mb-2">Invitations</h2>
    <div class="space-y-4">
        @foreach ($invitations as $invitation)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <span class="font-medium">{{ $invitation->user->name }}</span>
                    <span class="text-sm text-gray-500">{{ $invitation->user->email }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <form action="{{ route('user.team-members.update', $invitation) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="accepted">
                        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">Accept</button>
                    </form>
                    <form action="{{ route('user.team-members.update', $invitation) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Reject</button>
                    </form>
                </div>
            </div>
        @endforeach

        @if($invitations->isEmpty())
            <div class="text-center text-gray-500 py-6">No pending invitations.</div>
        @endif
    </div>
</div>
@endsection
