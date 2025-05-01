@extends('layouts.dashboard')

@section('title', 'User Settings')

@section('content')
<div class="bg-white min-h-screen p-6">
    <!-- Cabecera -->
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center">
            <div class="text-blue-600 mr-2">
                <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-semibold text-blue-700">Settings</h1>
                <p class="text-blue-600 text-sm">Manage your account and application preferences</p>
            </div>
        </div>
        <div>
            <button class="text-gray-400 rounded-full p-2 hover:bg-gray-100">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Mensajes -->
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif
    
    <!-- Contenedor principal -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Menú de navegación con enlaces directos -->
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
                <a href="{{ route('user.notification-preferences') }}" class="{{ request('tab') == 'notifications' || request()->routeIs('user.notification-preferences') ? 'text-blue-600 border-b-2 border-blue-500' : 'text-gray-500 hover:text-blue-600' }} whitespace-nowrap py-4 px-6 font-medium text-sm">
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
        
        <!-- Contenido de las pestañas -->
        <div class="p-6">
            <!-- Perfil -->
            <div id="profile" @if(request('tab') != null && request('tab') != 'profile') style="display: none;" @endif>
                <form action="{{ route('user.settings.profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Encabezado de sección con icono de usuario -->
                    <div class="flex items-center px-6 py-4">
                        <div class="flex-shrink-0 mr-3 text-blue-600">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-medium text-blue-900">Profile Information</h2>
                            <p class="text-xs text-gray-500">Update your personal details</p>
                        </div>
                    </div>
                    
                    <!-- Contenido del perfil -->
                    <div class="bg-white border rounded-lg m-6 p-6">
                        <!-- Foto de perfil -->
                        <div class="mb-8">
                            <div class="flex flex-col items-center sm:items-start">
                                <div class="mb-4">
                                    @if($user->profile_image)
                                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="profile-image h-20 w-20 rounded-full object-cover border-2 border-white shadow">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=0D8ABC&color=fff&size=160" alt="Avatar" class="profile-image h-20 w-20 rounded-full object-cover border-2 border-white shadow">
                                    @endif
                                </div>
                                
                                <div>
                                    <input type="file" name="profile_image" id="profile_image" class="hidden" accept="image/*" onchange="uploadProfileImage(this)">
                                    <input type="hidden" name="remove_profile_image" id="remove_profile_image" value="0">
                                    <div class="flex space-x-2">
                                        <button type="button" onclick="document.getElementById('profile_image').click();" class="px-3 py-1 border border-blue-300 rounded-md text-blue-600 text-sm font-medium bg-white hover:bg-blue-50">
                                            Change
                                        </button>
                                        <button type="button" onclick="document.getElementById('remove_profile_image').value = '1'; this.form.submit();" class="px-3 py-1 border border-red-300 rounded-md text-red-600 text-sm font-medium bg-white hover:bg-red-50">
                                            Remove
                                        </button>
                                    </div>
                                    
                                    <div id="upload-status" class="mt-2 hidden">
                                        <div class="flex items-center">
                                            <svg class="animate-spin h-5 w-5 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <p class="text-sm text-blue-600">Uploading...</p>
                                        </div>
                                    </div>
                                    
                                    <div id="image-preview-container" class="mt-2 hidden">
                                        <p class="text-sm text-gray-500">Preview:</p>
                                        <img id="image-preview" class="mt-1 h-16 w-16 rounded-full object-cover border border-gray-200" src="#" alt="Preview">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Campos de formulario -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mb-6">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <input type="text" name="first_name" id="first_name" value="{{ $user->first_name ?? explode(' ', $user->name)[0] ?? '' }}" required class="w-full px-3 py-2 border border-blue-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input type="text" name="last_name" id="last_name" value="{{ $user->last_name ?? explode(' ', $user->name)[1] ?? '' }}" required class="w-full px-3 py-2 border border-blue-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ $user->email }}" required class="w-full px-3 py-2 border border-blue-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="job_title" class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                                <input type="text" name="job_title" id="job_title" value="{{ $user->job_title ?? '' }}" class="w-full px-3 py-2 border border-blue-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="flex justify-end space-x-3">
                            <button type="button" class="px-5 py-2 border border-gray-300 rounded-md text-gray-700 bg-white text-sm font-medium hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="px-5 py-2 bg-blue-700 text-white rounded-md text-sm font-medium hover:bg-blue-800">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Contraseña -->
            <div id="password" class="tab-content hidden">
                <form action="{{ route('user.settings.password') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="old_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                            <input type="password" name="current_password" id="old_password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @error('current_password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                            <input type="password" name="password" id="new_password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="confirm_password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        
                        <div>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Seguridad de la cuenta -->
            <div id="security" @if(request('tab') != 'security') style="display: none;" @endif>
                <form action="{{ route('user.settings.password') }}" method="POST">
                    @csrf
                    
                    <!-- Encabezado de sección con icono de candado -->
                    <div class="flex items-center px-6 py-4">
                        <div class="flex-shrink-0 mr-3 text-blue-600">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-medium text-blue-900">Change Password</h2>
                            <p class="text-xs text-gray-500">Manage your password and security settings</p>
                        </div>
                    </div>
                    
                    <!-- Contenido del formulario de seguridad -->
                    <div class="bg-white border rounded-lg m-6 p-6">
                        <!-- Campo de contraseña actual -->
                        <div class="mb-6">
                            <label for="security_current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password <span class="text-red-500">*</span></label>
                            <input type="password" name="current_password" id="security_current_password" required class="w-full px-3 py-2 border border-blue-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Campos de nueva contraseña y confirmación en dos columnas -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mb-6">
                            <div>
                                <label for="security_new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password <span class="text-red-500">*</span></label>
                                <input type="password" name="password" id="security_new_password" required class="w-full px-3 py-2 border border-blue-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="security_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password <span class="text-red-500">*</span></label>
                                <input type="password" name="password_confirmation" id="security_password_confirmation" required class="w-full px-3 py-2 border border-blue-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="flex justify-end space-x-3">
                            <button type="button" class="px-5 py-2 border border-gray-300 rounded-md text-gray-700 bg-white text-sm font-medium hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="px-5 py-2 bg-blue-700 text-white rounded-md text-sm font-medium hover:bg-blue-800">
                                Update Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Add Member -->
            <div id="team" class="tab-content" @if(request('tab') != 'team') style="display: none;" @endif>
                <div class="bg-gray-50 rounded-lg p-6">
                    <!-- Sección de miembros actuales del equipo -->
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="mr-3 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-medium text-gray-900">Team Members</h2>
                                <p class="text-sm text-gray-500">Current team members and their roles</p>
                            </div>
                        </div>
                        
                        <!-- Tabla de miembros del equipo -->
                        @if($teamMembers->isEmpty())
                            <div class="bg-white p-4 rounded-lg border border-gray-200 text-gray-700 text-sm">
                                <p>No team members added yet. Add your first team member below.</p>
                            </div>
                        @else
                            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($teamMembers as $member)
                                                <tr>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                                                                {{ strtoupper(substr($member->name, 0, 1)) }}
                                                            </div>
                                                            <div class="ml-3">
                                                                <p class="text-sm font-medium text-gray-900">{{ $member->name }}</p>
                                                                <p class="text-xs text-gray-500">{{ $member->email }}</p>
                                                                @if($member->job_title)
                                                                    <p class="text-xs text-gray-500">{{ $member->job_title }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $member->role === 'admin' ? 'bg-purple-100 text-purple-800' : ($member->role === 'member' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                                            {{ ucfirst($member->role) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        @if($member->invitation_accepted)
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                                        @else
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                        <div class="flex justify-end space-x-2">
                                                            <button type="button" onclick="editMember('{{ $member->id }}')" class="text-indigo-600 hover:text-indigo-900">
                                                                Edit
                                                            </button>
                                                            <form action="{{ route('user.settings.team.remove', $member->id) }}" method="POST" class="inline-block ml-2">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to remove this team member?')">
                                                                    Remove
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Encabezado para añadir miembro -->
                    <div class="flex items-center mb-4">
                        <div class="mr-3 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">Add Team member</h2>
                            <p class="text-sm text-gray-500">Manage user roles and access controls</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('user.settings.team.add') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="member_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                <input type="text" name="name" id="member_name" placeholder="Mohamed Ragab" required class="w-full px-3 py-2 border border-blue-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label for="member_job_title" class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                                <input type="text" name="job_title" id="member_job_title" placeholder="Product Designer" class="w-full px-3 py-2 border border-blue-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="member_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" id="member_email" placeholder="mohamed@example.com" class="w-full px-3 py-2 border border-blue-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="member_role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <select id="member_role" name="role" class="w-full px-3 py-2 border border-blue-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="owner">Owner (Full Access)</option>
                                    <option value="admin">Administrator</option>
                                    <option value="manager">Project Manager</option>
                                    <option value="developer">Developer</option>
                                    <option value="analyst">Analyst</option>
                                    <option value="member" selected>Team Member</option>
                                    <option value="client">Client</option>
                                    <option value="viewer">Viewer (Read-only)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Permissions</h4>
                            
                            <div class="mb-3">
                                <h5 class="text-xs font-medium text-gray-500 uppercase mb-2">Dashboard &amp; Analytics</h5>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="perm_dashboard_view" name="permissions[]" value="dashboard_view" type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="perm_dashboard_view" class="font-medium text-gray-700">View Dashboard</label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="perm_analytics_view" name="permissions[]" value="analytics_view" type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="perm_analytics_view" class="font-medium text-gray-700">View Analytics</label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="perm_reports_export" name="permissions[]" value="reports_export" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="perm_reports_export" class="font-medium text-gray-700">Export Reports</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <h5 class="text-xs font-medium text-gray-500 uppercase mb-2">Projects &amp; Content</h5>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="perm_projects_view" name="permissions[]" value="projects_view" type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="perm_projects_view" class="font-medium text-gray-700">View Projects</label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="perm_projects_create" name="permissions[]" value="projects_create" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="perm_projects_create" class="font-medium text-gray-700">Create Projects</label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="perm_projects_edit" name="permissions[]" value="projects_edit" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="perm_projects_edit" class="font-medium text-gray-700">Edit Projects</label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="perm_projects_delete" name="permissions[]" value="projects_delete" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="perm_projects_delete" class="font-medium text-gray-700">Delete Projects</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                            
                            <div class="mb-3">
                                <h5 class="text-xs font-medium text-gray-500 uppercase mb-2">Team Management</h5>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="perm_team_view" name="permissions[]" value="team_view" type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="perm_team_view" class="font-medium text-gray-700">View Team Members</label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="perm_team_add" name="permissions[]" value="team_add" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="perm_team_add" class="font-medium text-gray-700">Add Team Members</label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="perm_team_remove" name="permissions[]" value="team_remove" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="perm_team_remove" class="font-medium text-gray-700">Remove Team Members</label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="perm_team_edit" name="permissions[]" value="team_edit" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="perm_team_edit" class="font-medium text-gray-700">Edit Team Members</label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="perm_roles_assign" name="permissions[]" value="roles_assign" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="perm_roles_assign" class="font-medium text-gray-700">Assign Roles</label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="perm_permissions_edit" name="permissions[]" value="permissions_edit" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="perm_permissions_edit" class="font-medium text-gray-700">Edit Permissions</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h5 class="text-xs font-medium text-gray-500 uppercase mb-2">Admin &amp; Settings</h5>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="perm_team_manage" name="permissions[]" value="team_manage" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="perm_team_manage" class="font-medium text-gray-700">Manage Team</label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="perm_settings_edit" name="permissions[]" value="settings_edit" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="perm_settings_edit" class="font-medium text-gray-700">Edit Settings</label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="perm_billing_manage" name="permissions[]" value="billing_manage" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="perm_billing_manage" class="font-medium text-gray-700">Manage Billing</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="flex justify-end space-x-3 mt-8">
                            <button type="reset" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 bg-white text-sm font-medium hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="px-6 py-2 bg-blue-700 text-white rounded-md text-sm font-medium hover:bg-blue-800">
                                Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Modal para editar miembro -->
            <div id="editMemberModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 hidden flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 max-h-screen overflow-y-auto">
                    <!-- Encabezado del modal -->
                    <div class="px-6 py-4 border-b flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="mr-3 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Edit Team Member</h3>
                        </div>
                        <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Contenido del modal -->
                    <form id="editMemberForm" action="" method="POST" class="px-6 py-4">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_member_id" name="member_id">
                        
                        <div class="space-y-4">
                            <div>
                                <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                <input type="text" name="name" id="edit_name" class="w-full px-3 py-2 border border-blue-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label for="edit_job_title" class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                                <input type="text" name="job_title" id="edit_job_title" class="w-full px-3 py-2 border border-blue-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" id="edit_email" class="w-full px-3 py-2 border border-blue-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label for="edit_role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <select id="edit_role" name="role" class="w-full px-3 py-2 border border-blue-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="owner">Owner (Full Access)</option>
                                    <option value="admin">Administrator</option>
                                    <option value="manager">Project Manager</option>
                                    <option value="developer">Developer</option>
                                    <option value="analyst">Analyst</option>
                                    <option value="member">Team Member</option>
                                    <option value="client">Client</option>
                                    <option value="viewer">Viewer (Read-only)</option>
                                </select>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Permissions</h4>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="edit_team_view" name="permissions[]" value="team_view" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="edit_team_view" class="font-medium text-gray-700">View Team</label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="edit_team_add" name="permissions[]" value="team_add" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="edit_team_add" class="font-medium text-gray-700">Add Members</label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="edit_team_edit" name="permissions[]" value="team_edit" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="edit_team_edit" class="font-medium text-gray-700">Edit Members</label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="edit_team_remove" name="permissions[]" value="team_remove" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="edit_team_remove" class="font-medium text-gray-700">Remove Members</label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="edit_projects_view" name="permissions[]" value="projects_view" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="edit_projects_view" class="font-medium text-gray-700">View Projects</label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="edit_projects_edit" name="permissions[]" value="projects_edit" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="edit_projects_edit" class="font-medium text-gray-700">Edit Projects</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Account Status</h4>
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="edit_active" name="active" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="edit_active" class="font-medium text-gray-700">Active Account</label>
                                        <p class="text-gray-500">Inactive accounts cannot log in to the system</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white text-sm font-medium hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md text-sm font-medium hover:bg-blue-800">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Notificaciones -->
            <div id="notifications" class="tab-content" @if(request('tab') != 'notifications') style="display: none;" @endif>
                <form action="{{ route('user.settings.notifications') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        @php
                            $notifications = $user->notification_preferences ? json_decode($user->notification_preferences, true) : [
                                'email_notifications' => true,
                                'project_updates' => true,
                                'idea_feedback' => true,
                                'system_updates' => true
                            ];
                        @endphp
                        
                        <div class="space-y-4">
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="email_notifications" name="email_notifications" type="checkbox" {{ $notifications['email_notifications'] ?? false ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="email_notifications" class="font-medium text-gray-700">Email Notifications</label>
                                    <p class="text-gray-500">Receive email notifications for important updates.</p>
                                </div>
                            </div>
                            
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="project_updates" name="project_updates" type="checkbox" {{ $notifications['project_updates'] ?? false ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="project_updates" class="font-medium text-gray-700">Project Updates</label>
                                    <p class="text-gray-500">Notify me about changes to my projects.</p>
                                </div>
                            </div>
                            
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="idea_feedback" name="idea_feedback" type="checkbox" {{ $notifications['idea_feedback'] ?? false ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="idea_feedback" class="font-medium text-gray-700">Idea Feedback</label>
                                    <p class="text-gray-500">Receive notifications when there's feedback on my ideas.</p>
                                </div>
                            </div>
                            
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="system_updates" name="system_updates" type="checkbox" {{ $notifications['system_updates'] ?? false ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="system_updates" class="font-medium text-gray-700">System Updates</label>
                                    <p class="text-gray-500">Get notified about system updates and new features.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Save Notification Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Branding -->
            <div id="branding" class="tab-content" @if(request('tab') != 'branding') style="display: none;" @endif>
                <div class="bg-blue-50 rounded-lg p-6 mb-6">
                    <h2 class="text-xl font-semibold text-blue-700 mb-1">Branding Settings</h2>
                    <p class="text-blue-400 text-sm mb-6">Customize your organization's branding</p>
                    
                    @php
                        $branding = $user->branding_settings ? json_decode($user->branding_settings, true) : [
                            'company_name' => 'Refine AI',
                            'website' => '',
                            'address' => 'UK'
                        ];
                    @endphp
                    
                    <form id="brandingForm" action="{{ route('user.settings.branding') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_form_id" value="branding_{{ time() }}">
                        
                        <!-- Company Logo -->
                        <div class="mb-8">
                            <h3 class="text-base font-medium text-blue-800 mb-3">Company Logo</h3>
                            
                            <div class="flex items-start space-x-4 mb-3">
                                <div class="w-36 h-28 bg-white border border-blue-100 rounded flex items-center justify-center">
                                    @if(!empty($branding['logo_path']) && file_exists(public_path('storage/' . $branding['logo_path'])))
                                        <img src="{{ asset('storage/' . $branding['logo_path']) }}" alt="Company Logo" class="max-w-full max-h-full p-2">
                                    @else
                                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    @endif
                                </div>
                                
                                <div>
                                    <p class="text-blue-400 text-sm">Upload your company logo</p>
                                    <p class="text-blue-300 text-sm">to be used in reports and exported documents</p>
                                </div>
                            </div>
                            
                            <button type="button" onclick="document.getElementById('company_logo').click();" class="flex items-center text-blue-600">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
                                </svg>
                                Upload
                            </button>
                            <input type="file" name="company_logo" id="company_logo" class="hidden" accept="image/*" onchange="document.getElementById('logo_preview').classList.remove('hidden'); document.getElementById('logo_preview_img').src = window.URL.createObjectURL(this.files[0])">
                            
                            <div id="logo_preview" class="mt-2 hidden">
                                <p class="text-sm text-blue-800">Logo Preview:</p>
                                <img id="logo_preview_img" class="mt-1 h-10 object-contain" src="#" alt="Logo Preview">
                            </div>
                        </div>
                        
                        <!-- Company Information -->
                        <div class="mb-8">
                            <h3 class="text-base font-medium text-blue-800 mb-3">Company Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                <div>
                                    <label for="company_name" class="block text-blue-800 text-sm mb-2">Company Name</label>
                                    <input type="text" name="company_name" id="company_name" value="{{ $branding['company_name'] ?? 'Refine AI' }}" class="w-full px-4 py-2 rounded border border-blue-100 text-blue-800">
                                </div>
                                
                                <div>
                                    <label for="website" class="block text-blue-800 text-sm mb-2">Website</label>
                                    <input type="url" name="website" id="website" value="{{ $branding['website'] ?? '' }}" placeholder="WWW..." class="w-full px-4 py-2 rounded border border-blue-100 text-blue-800">
                                </div>
                            </div>
                            
                            <div>
                                <label for="address" class="block text-blue-800 text-sm mb-2">Address</label>
                                <input type="text" name="address" id="address" value="{{ $branding['address'] ?? 'UK' }}" class="w-full px-4 py-2 rounded border border-blue-100 text-blue-800">
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3">
                            <button type="button" id="reset-branding-button" class="px-8 py-2 border border-gray-300 rounded text-gray-700 bg-white inline-flex items-center justify-center">
                                Reset
                            </button>
                            <button type="submit" class="px-8 py-2 bg-blue-700 text-white rounded">
                                Save
                            </button>
                        </div>
                    </form>
                    
                    <form id="reset-branding-form" action="{{ route('user.settings.branding.reset') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
                
                <script>
                    // Store original values when page loads
                    document.addEventListener('DOMContentLoaded', function() {
                        window.originalBrandingValues = {
                            company_name: @json($branding['company_name'] ?? 'Refine AI'),
                            website: @json($branding['website'] ?? ''),
                            address: @json($branding['address'] ?? 'UK')
                        };
                        
                        // Add event listener for reset button
                        document.getElementById('reset-branding-button').addEventListener('click', function() {
                            document.getElementById('reset-branding-form').submit();
                        });
                    });
                    
                    function resetBrandingForm() {
                        // First do a normal form reset
                        const form = document.getElementById('brandingForm');
                        form.reset();
                        
                        // Hide logo preview if it's visible
                        if (document.getElementById('logo_preview')) {
                            document.getElementById('logo_preview').classList.add('hidden');
                        }
                        
                        // Set original values (stored when page loaded)
                        if (window.originalBrandingValues) {
                            document.getElementById('company_name').value = window.originalBrandingValues.company_name;
                            document.getElementById('website').value = window.originalBrandingValues.website;
                            document.getElementById('address').value = window.originalBrandingValues.address;
                        }
                        
                        // Clear file input
                        const fileInput = document.getElementById('company_logo');
                        if (fileInput) {
                            fileInput.value = '';
                        }
                    }
                </script>
            </div>
            
            <!-- Advanced -->
            <div id="advanced" class="tab-content" @if(request('tab') != 'advanced') style="display: none;" @endif>
                <form action="{{ route('user.settings.advanced') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        @php
                            $advanced = $user->advanced_settings ?? [
                                'export_data' => true,
                                'timezone' => 'UTC',
                                'date_format' => 'Y-m-d',
                                'last_updated' => now()->toDateTimeString()
                            ];
                        @endphp
                        
                        @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                            <p>{{ session('success') }}</p>
                        </div>
                        @endif
                        
                        @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                            <p>{{ session('error') }}</p>
                        </div>
                        @endif
                        
                        @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                            <ul class="list-disc ml-4">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        
                        <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg shadow-sm border border-blue-100">
                            <div class="flex items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="text-sm font-semibold text-gray-800">Current Settings Status</h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                                <div class="flex items-center">
                                    <span class="text-gray-600 font-medium mr-2">Timezone:</span>
                                    <span class="text-indigo-700">{{ $advanced['timezone'] ?? 'Not Set' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-600 font-medium mr-2">Date Format:</span>
                                    <span class="text-indigo-700">{{ $advanced['date_format'] ?? 'Not Set' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-600 font-medium mr-2">Data Export:</span>
                                    <span class="px-2 py-0.5 rounded-full text-xs {{ isset($advanced['export_data']) && $advanced['export_data'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ isset($advanced['export_data']) && $advanced['export_data'] ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-600 font-medium mr-2">Last Updated:</span>
                                    <span class="text-indigo-700">{{ $advanced['last_updated'] ?? 'Never' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900">Advanced Settings</h3>
                            </div>
                            <p class="text-sm text-gray-500 ml-8">These settings are for advanced users and can affect system behavior.</p>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Data Management Section -->
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="flex items-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                    </svg>
                                    <h3 class="text-md font-medium text-gray-900">Data Management</h3>
                                </div>
                                
                                <div class="mb-4">
                                    <div class="p-3 bg-white rounded-md border border-blue-100 hover:border-blue-200 transition-all duration-200 shadow-sm">
                                        <div class="relative flex items-start mb-2">
                                            <div class="flex items-center h-5 mt-0.5">
                                                <!-- Hidden field to ensure export_data is always sent in the form -->
                                                <input type="hidden" name="export_data" value="0">
                                                <input id="export_data" name="export_data" type="checkbox" value="1" {{ $advanced['export_data'] ?? false ? 'checked' : '' }} class="focus:ring-blue-500 h-5 w-5 text-blue-600 border-blue-300 rounded transition-colors duration-200 cursor-pointer">
                                            </div>
                                            <div class="ml-3">
                                                <label for="export_data" class="font-medium text-gray-800 text-sm cursor-pointer">Enable Data Export</label>
                                                <p class="text-gray-500 text-xs mt-1">Allow exporting your account data in PDF, CSV, and JSON formats.</p>
                                            </div>
                                        </div>
                                        <div class="mt-3 ml-8 text-xs text-blue-600">
                                            <p class="mb-1">When enabled, you can download your data from the export section below.</p>
                                            <p>Your settings are stored securely and updated in real-time.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Data Export Section -->
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex items-center mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        <h4 class="text-sm font-medium text-gray-800">Export Your Data</h4>
                                    </div>
                                    <p class="text-xs text-gray-500 mb-3 ml-6">Download your account data in your preferred format. This includes your profile information, settings, and activity.</p>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 ml-6">
                                        @if(isset($advanced['export_data']) && $advanced['export_data'])
                                            <!-- Export buttons when export is enabled -->
                                            <a href="{{ route('user.data.export', ['format' => 'json']) }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 hover:border-blue-300 hover:text-blue-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <span class="flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                </span>
                                                JSON Format
                                            </a>
                                            
                                            <a href="{{ route('user.data.export', ['format' => 'csv']) }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 hover:border-green-300 hover:text-green-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                <span class="flex items-center justify-center w-6 h-6 bg-green-100 rounded-full mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                </span>
                                                CSV Format
                                            </a>
                                            
                                            <a href="{{ route('user.data.export', ['format' => 'pdf']) }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 hover:border-red-300 hover:text-red-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                <span class="flex items-center justify-center w-6 h-6 bg-red-100 rounded-full mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                </span>
                                                PDF Format
                                            </a>
                                        @else
                                            <!-- Disabled export buttons when export is disabled -->
                                            <div class="col-span-3 p-4 bg-gray-50 border border-gray-200 rounded-md">
                                                <div class="flex items-center text-gray-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                    </svg>
                                                    <span class="text-sm font-medium">Data export is currently disabled</span>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-2 ml-7">Enable the "Data Export" option above and save your settings to access export functionality.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Date and Time Settings -->
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="flex items-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="text-md font-medium text-gray-900">Time & Localization</h3>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
                                        <select id="timezone" name="timezone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            <option value="UTC" {{ ($advanced['timezone'] ?? 'UTC') == 'UTC' ? 'selected' : '' }}>UTC (Coordinated Universal Time)</option>
                                            
                                            <!-- Africa -->
                                            <optgroup label="Africa">
                                                <option value="Africa/Cairo" {{ ($advanced['timezone'] ?? 'UTC') == 'Africa/Cairo' ? 'selected' : '' }}>Cairo (Egypt)</option>
                                                <option value="Africa/Casablanca" {{ ($advanced['timezone'] ?? 'UTC') == 'Africa/Casablanca' ? 'selected' : '' }}>Casablanca (Morocco)</option>
                                                <option value="Africa/Johannesburg" {{ ($advanced['timezone'] ?? 'UTC') == 'Africa/Johannesburg' ? 'selected' : '' }}>Johannesburg (South Africa)</option>
                                                <option value="Africa/Lagos" {{ ($advanced['timezone'] ?? 'UTC') == 'Africa/Lagos' ? 'selected' : '' }}>Lagos (Nigeria)</option>
                                                <option value="Africa/Nairobi" {{ ($advanced['timezone'] ?? 'UTC') == 'Africa/Nairobi' ? 'selected' : '' }}>Nairobi (Kenya)</option>
                                                <option value="Africa/Tunis" {{ ($advanced['timezone'] ?? 'UTC') == 'Africa/Tunis' ? 'selected' : '' }}>Tunis (Tunisia)</option>
                                            </optgroup>
                                            
                                            <!-- Americas -->
                                            <optgroup label="Americas">
                                                <option value="America/Anchorage" {{ ($advanced['timezone'] ?? 'UTC') == 'America/Anchorage' ? 'selected' : '' }}>Anchorage (USA)</option>
                                                <option value="America/Argentina/Buenos_Aires" {{ ($advanced['timezone'] ?? 'UTC') == 'America/Argentina/Buenos_Aires' ? 'selected' : '' }}>Buenos Aires (Argentina)</option>
                                                <option value="America/Bogota" {{ ($advanced['timezone'] ?? 'UTC') == 'America/Bogota' ? 'selected' : '' }}>Bogota (Colombia)</option>
                                                <option value="America/Chicago" {{ ($advanced['timezone'] ?? 'UTC') == 'America/Chicago' ? 'selected' : '' }}>Chicago (USA)</option>
                                                <option value="America/Denver" {{ ($advanced['timezone'] ?? 'UTC') == 'America/Denver' ? 'selected' : '' }}>Denver (USA)</option>
                                                <option value="America/Halifax" {{ ($advanced['timezone'] ?? 'UTC') == 'America/Halifax' ? 'selected' : '' }}>Halifax (Canada)</option>
                                                <option value="America/Lima" {{ ($advanced['timezone'] ?? 'UTC') == 'America/Lima' ? 'selected' : '' }}>Lima (Peru)</option>
                                                <option value="America/Los_Angeles" {{ ($advanced['timezone'] ?? 'UTC') == 'America/Los_Angeles' ? 'selected' : '' }}>Los Angeles (USA)</option>
                                                <option value="America/Mexico_City" {{ ($advanced['timezone'] ?? 'UTC') == 'America/Mexico_City' ? 'selected' : '' }}>Mexico City (Mexico)</option>
                                                <option value="America/New_York" {{ ($advanced['timezone'] ?? 'UTC') == 'America/New_York' ? 'selected' : '' }}>New York (USA)</option>
                                                <option value="America/Santiago" {{ ($advanced['timezone'] ?? 'UTC') == 'America/Santiago' ? 'selected' : '' }}>Santiago (Chile)</option>
                                                <option value="America/Sao_Paulo" {{ ($advanced['timezone'] ?? 'UTC') == 'America/Sao_Paulo' ? 'selected' : '' }}>Sao Paulo (Brazil)</option>
                                                <option value="America/Toronto" {{ ($advanced['timezone'] ?? 'UTC') == 'America/Toronto' ? 'selected' : '' }}>Toronto (Canada)</option>
                                                <option value="America/Vancouver" {{ ($advanced['timezone'] ?? 'UTC') == 'America/Vancouver' ? 'selected' : '' }}>Vancouver (Canada)</option>
                                            </optgroup>
                                            
                                            <!-- Asia -->
                                            <optgroup label="Asia">
                                                <option value="Asia/Baghdad" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Baghdad' ? 'selected' : '' }}>Baghdad (Iraq)</option>
                                                <option value="Asia/Bangkok" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Bangkok' ? 'selected' : '' }}>Bangkok (Thailand)</option>
                                                <option value="Asia/Beirut" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Beirut' ? 'selected' : '' }}>Beirut (Lebanon)</option>
                                                <option value="Asia/Dhaka" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Dhaka' ? 'selected' : '' }}>Dhaka (Bangladesh)</option>
                                                <option value="Asia/Dubai" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Dubai' ? 'selected' : '' }}>Dubai (UAE)</option>
                                                <option value="Asia/Hong_Kong" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Hong_Kong' ? 'selected' : '' }}>Hong Kong</option>
                                                <option value="Asia/Istanbul" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Istanbul' ? 'selected' : '' }}>Istanbul (Turkey)</option>
                                                <option value="Asia/Jakarta" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Jakarta' ? 'selected' : '' }}>Jakarta (Indonesia)</option>
                                                <option value="Asia/Jerusalem" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Jerusalem' ? 'selected' : '' }}>Jerusalem (Israel)</option>
                                                <option value="Asia/Karachi" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Karachi' ? 'selected' : '' }}>Karachi (Pakistan)</option>
                                                <option value="Asia/Kolkata" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Kolkata' ? 'selected' : '' }}>Kolkata (India)</option>
                                                <option value="Asia/Kuala_Lumpur" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Kuala_Lumpur' ? 'selected' : '' }}>Kuala Lumpur (Malaysia)</option>
                                                <option value="Asia/Kuwait" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Kuwait' ? 'selected' : '' }}>Kuwait</option>
                                                <option value="Asia/Manila" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Manila' ? 'selected' : '' }}>Manila (Philippines)</option>
                                                <option value="Asia/Muscat" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Muscat' ? 'selected' : '' }}>Muscat (Oman)</option>
                                                <option value="Asia/Riyadh" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Riyadh' ? 'selected' : '' }}>Riyadh (Saudi Arabia)</option>
                                                <option value="Asia/Seoul" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Seoul' ? 'selected' : '' }}>Seoul (South Korea)</option>
                                                <option value="Asia/Shanghai" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Shanghai' ? 'selected' : '' }}>Shanghai (China)</option>
                                                <option value="Asia/Singapore" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Singapore' ? 'selected' : '' }}>Singapore</option>
                                                <option value="Asia/Taipei" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Taipei' ? 'selected' : '' }}>Taipei (Taiwan)</option>
                                                <option value="Asia/Tehran" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Tehran' ? 'selected' : '' }}>Tehran (Iran)</option>
                                                <option value="Asia/Tokyo" {{ ($advanced['timezone'] ?? 'UTC') == 'Asia/Tokyo' ? 'selected' : '' }}>Tokyo (Japan)</option>
                                            </optgroup>
                                            
                                            <!-- Australia & Pacific -->
                                            <optgroup label="Australia & Pacific">
                                                <option value="Australia/Adelaide" {{ ($advanced['timezone'] ?? 'UTC') == 'Australia/Adelaide' ? 'selected' : '' }}>Adelaide (Australia)</option>
                                                <option value="Australia/Brisbane" {{ ($advanced['timezone'] ?? 'UTC') == 'Australia/Brisbane' ? 'selected' : '' }}>Brisbane (Australia)</option>
                                                <option value="Australia/Melbourne" {{ ($advanced['timezone'] ?? 'UTC') == 'Australia/Melbourne' ? 'selected' : '' }}>Melbourne (Australia)</option>
                                                <option value="Australia/Perth" {{ ($advanced['timezone'] ?? 'UTC') == 'Australia/Perth' ? 'selected' : '' }}>Perth (Australia)</option>
                                                <option value="Australia/Sydney" {{ ($advanced['timezone'] ?? 'UTC') == 'Australia/Sydney' ? 'selected' : '' }}>Sydney (Australia)</option>
                                                <option value="Pacific/Auckland" {{ ($advanced['timezone'] ?? 'UTC') == 'Pacific/Auckland' ? 'selected' : '' }}>Auckland (New Zealand)</option>
                                                <option value="Pacific/Fiji" {{ ($advanced['timezone'] ?? 'UTC') == 'Pacific/Fiji' ? 'selected' : '' }}>Fiji</option>
                                                <option value="Pacific/Honolulu" {{ ($advanced['timezone'] ?? 'UTC') == 'Pacific/Honolulu' ? 'selected' : '' }}>Honolulu (USA)</option>
                                            </optgroup>
                                            
                                            <!-- Europe -->
                                            <optgroup label="Europe">
                                                <option value="Europe/Amsterdam" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Amsterdam' ? 'selected' : '' }}>Amsterdam (Netherlands)</option>
                                                <option value="Europe/Athens" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Athens' ? 'selected' : '' }}>Athens (Greece)</option>
                                                <option value="Europe/Berlin" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Berlin' ? 'selected' : '' }}>Berlin (Germany)</option>
                                                <option value="Europe/Brussels" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Brussels' ? 'selected' : '' }}>Brussels (Belgium)</option>
                                                <option value="Europe/Budapest" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Budapest' ? 'selected' : '' }}>Budapest (Hungary)</option>
                                                <option value="Europe/Copenhagen" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Copenhagen' ? 'selected' : '' }}>Copenhagen (Denmark)</option>
                                                <option value="Europe/Dublin" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Dublin' ? 'selected' : '' }}>Dublin (Ireland)</option>
                                                <option value="Europe/Helsinki" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Helsinki' ? 'selected' : '' }}>Helsinki (Finland)</option>
                                                <option value="Europe/Lisbon" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Lisbon' ? 'selected' : '' }}>Lisbon (Portugal)</option>
                                                <option value="Europe/London" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/London' ? 'selected' : '' }}>London (UK)</option>
                                                <option value="Europe/Madrid" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Madrid' ? 'selected' : '' }}>Madrid (Spain)</option>
                                                <option value="Europe/Moscow" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Moscow' ? 'selected' : '' }}>Moscow (Russia)</option>
                                                <option value="Europe/Oslo" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Oslo' ? 'selected' : '' }}>Oslo (Norway)</option>
                                                <option value="Europe/Paris" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Paris' ? 'selected' : '' }}>Paris (France)</option>
                                                <option value="Europe/Prague" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Prague' ? 'selected' : '' }}>Prague (Czech Republic)</option>
                                                <option value="Europe/Rome" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Rome' ? 'selected' : '' }}>Rome (Italy)</option>
                                                <option value="Europe/Stockholm" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Stockholm' ? 'selected' : '' }}>Stockholm (Sweden)</option>
                                                <option value="Europe/Vienna" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Vienna' ? 'selected' : '' }}>Vienna (Austria)</option>
                                                <option value="Europe/Warsaw" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Warsaw' ? 'selected' : '' }}>Warsaw (Poland)</option>
                                                <option value="Europe/Zurich" {{ ($advanced['timezone'] ?? 'UTC') == 'Europe/Zurich' ? 'selected' : '' }}>Zurich (Switzerland)</option>
                                            </optgroup>
                                        </select>
                                        <p class="mt-1 text-sm text-gray-500">Choose your local timezone for accurate time display.</p>
                                    </div>
                                    
                                    <div>
                                        <label for="date_format" class="block text-sm font-medium text-gray-700">Date Format</label>
                                        <select id="date_format" name="date_format" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            <option value="Y-m-d" {{ ($advanced['date_format'] ?? 'Y-m-d') == 'Y-m-d' ? 'selected' : '' }}>2025-04-28 (YYYY-MM-DD)</option>
                                            <option value="m/d/Y" {{ ($advanced['date_format'] ?? 'Y-m-d') == 'm/d/Y' ? 'selected' : '' }}>04/28/2025 (MM/DD/YYYY)</option>
                                            <option value="d/m/Y" {{ ($advanced['date_format'] ?? 'Y-m-d') == 'd/m/Y' ? 'selected' : '' }}>28/04/2025 (DD/MM/YYYY)</option>
                                            <option value="M j, Y" {{ ($advanced['date_format'] ?? 'Y-m-d') == 'M j, Y' ? 'selected' : '' }}>Apr 28, 2025</option>
                                            <option value="j F Y" {{ ($advanced['date_format'] ?? 'Y-m-d') == 'j F Y' ? 'selected' : '' }}>28 April 2025</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Language selector removed -->
                            </div>
                        
                        <div class="mt-8 p-5 bg-gradient-to-r from-yellow-50 to-amber-50 border-l-4 border-yellow-400 rounded-md shadow-sm">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-yellow-100 p-1 rounded-full">
                                    <svg class="h-5 w-5 text-yellow-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Important Note</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>Changing advanced settings may affect how the system functions. Please make sure you understand the effects before applying changes.</p>
                                        <ul class="list-disc ml-5 mt-2 space-y-1 text-xs">
                                            <li><span class="font-medium">Timezone</span>: Affects how dates and times are displayed throughout the application</li>
                                            <li><span class="font-medium">Date Format</span>: Changes how dates appear in reports and the interface</li>
                                            <li><span class="font-medium">Data Export</span>: Controls whether your data can be exported from the system</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <button type="submit" id="save-advanced-settings" class="inline-flex items-center justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Save Advanced Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Apariencia -->
            <div id="appearance" class="tab-content" @if(request('tab') != 'appearance') style="display: none;" @endif>
                <form action="{{ route('user.settings.appearance') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        @php
                            $appearance = $user->appearance_preferences ? json_decode($user->appearance_preferences, true) : [
                                'dark_mode' => false,
                                'compact_view' => false,
                                'show_tooltips' => true
                            ];
                        @endphp
                        
                        <div class="space-y-4">
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="dark_mode" name="dark_mode" type="checkbox" {{ $appearance['dark_mode'] ?? false ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="dark_mode" class="font-medium text-gray-700">Dark Mode</label>
                                    <p class="text-gray-500">Use dark theme throughout the application.</p>
                                </div>
                            </div>
                            
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="compact_view" name="compact_view" type="checkbox" {{ $appearance['compact_view'] ?? false ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="compact_view" class="font-medium text-gray-700">Compact View</label>
                                    <p class="text-gray-500">Use a more compact layout to see more content.</p>
                                </div>
                            </div>
                            
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="show_tooltips" name="show_tooltips" type="checkbox" {{ $appearance['show_tooltips'] ?? false ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="show_tooltips" class="font-medium text-gray-700">Show Tooltips</label>
                                    <p class="text-gray-500">Display helpful tooltips when hovering UI elements.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Save Appearance Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Advanced Settings Form Handler
document.addEventListener('DOMContentLoaded', function() {
    const advancedForm = document.querySelector("form[action='{{ route('user.settings.advanced') }}']");
    if (advancedForm) {
        advancedForm.addEventListener('submit', function(e) {
            const timezoneSelect = document.getElementById('timezone');
            const dateFormatSelect = document.getElementById('date_format');
            const exportDataCheckbox = document.getElementById('export_data');
            
            // Validation
            if (timezoneSelect && !timezoneSelect.value) {
                e.preventDefault();
                alert('Please select a timezone');
                return false;
            }
            
            if (dateFormatSelect && !dateFormatSelect.value) {
                e.preventDefault();
                alert('Please select a date format');
                return false;
            }
            
            // Show saving indicator
            const saveButton = document.getElementById('save-advanced-settings');
            if (saveButton) {
                const originalText = saveButton.innerHTML;
                saveButton.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...';
                saveButton.disabled = true;
                
                // Re-enable after submission
                setTimeout(function() {
                    saveButton.innerHTML = originalText;
                    saveButton.disabled = false;
                }, 3000);
            }
        });
    }
});

// Funciones para manejar el modal de edición
function editMember(memberId) {
    // Obtener datos del miembro del equipo mediante AJAX
    fetch(`/user/settings/team/${memberId}/edit`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Llenar el formulario con los datos del miembro
            document.getElementById('edit_member_id').value = data.id;
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_job_title').value = data.job_title || '';
            document.getElementById('edit_email').value = data.email;
            document.getElementById('edit_role').value = data.role;
            document.getElementById('edit_active').checked = data.invitation_accepted;
            
            // Configurar la URL del formulario
            document.getElementById('editMemberForm').action = `/user/settings/team/${data.id}/update`;
            
            // Marcar los permisos
            const permissions = JSON.parse(data.permissions || '[]');
            document.querySelectorAll('input[name="permissions[]"]').forEach(checkbox => {
                checkbox.checked = permissions.includes(checkbox.value);
            });
            
            // Actualizar rol y permisos basados en el rol
            document.getElementById('edit_role').addEventListener('change', updateEditPermissionsByRole);
            
            // Mostrar el modal
            document.getElementById('editMemberModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load team member data.');
        });
}

function closeEditModal() {
    document.getElementById('editMemberModal').classList.add('hidden');
}

function updateEditPermissionsByRole() {
    const roleSelect = document.getElementById('edit_role');
    if (!roleSelect) return;
    
    const selectedRole = roleSelect.value;
    
    // Definir permisos por rol
    const rolePermissions = {
        'owner': [
            'dashboard_view', 'analytics_view', 'reports_export', 
            'projects_view', 'projects_create', 'projects_edit', 'projects_delete',
            'team_view', 'team_add', 'team_edit', 'team_remove', 'roles_assign', 'permissions_edit',
            'team_manage', 'settings_edit', 'billing_manage'
        ],
        'admin': [
            'dashboard_view', 'analytics_view', 'reports_export', 
            'projects_view', 'projects_create', 'projects_edit', 'projects_delete',
            'team_view', 'team_add', 'team_edit', 'team_remove', 'roles_assign',
            'team_manage', 'settings_edit', 'billing_manage'
        ],
        'manager': [
            'dashboard_view', 'analytics_view', 'reports_export', 
            'projects_view', 'projects_create', 'projects_edit',
            'team_view', 'team_add', 'team_edit',
            'team_manage'
        ],
        'developer': [
            'dashboard_view', 'analytics_view',
            'projects_view', 'projects_create', 'projects_edit',
            'team_view'
        ],
        'analyst': [
            'dashboard_view', 'analytics_view', 'reports_export', 'projects_view',
            'team_view'
        ],
        'member': [
            'dashboard_view', 'analytics_view', 'projects_view', 'projects_edit',
            'team_view'
        ],
        'client': [
            'dashboard_view', 'projects_view',
            'team_view'
        ],
        'viewer': [
            'dashboard_view', 'projects_view'
        ]
    };
    
    // Actualizar checkboxes
    document.querySelectorAll('input[id^="edit_"][name="permissions[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
    
    if (rolePermissions[selectedRole]) {
        rolePermissions[selectedRole].forEach(permission => {
            const checkbox = document.getElementById(`edit_${permission}`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
    }
}

// تحديث الصلاحيات تلقائياً بناءً على الدور المحدد
// نقوم بتنفيذ السكريبت مباشرة وليس في DOMContentLoaded لضمان تنفيذه مباشرة

// للتأكد من أن هذا السكريبت يعمل
console.log('Permission Script Loaded - v1.1');

// وظيفة تحديث الصلاحيات بناءً على الدور
function updatePermissionsByRole() {
    const roleSelect = document.getElementById('member_role');
    if (!roleSelect) {
        console.log('Role select not found');
        return;
    }
    
    console.log('Updating permissions for role:', roleSelect.value);
        // تعريف الصلاحيات لكل دور
    const rolePermissions = {
        'owner': [
            'dashboard_view', 'analytics_view', 'reports_export', 
            'projects_view', 'projects_create', 'projects_edit', 'projects_delete',
            'team_view', 'team_add', 'team_edit', 'team_remove', 'roles_assign', 'permissions_edit',
            'team_manage', 'settings_edit', 'billing_manage'
        ],
        'admin': [
            'dashboard_view', 'analytics_view', 'reports_export', 
            'projects_view', 'projects_create', 'projects_edit', 'projects_delete',
            'team_view', 'team_add', 'team_edit', 'team_remove', 'roles_assign',
            'team_manage', 'settings_edit', 'billing_manage'
        ],
        'manager': [
            'dashboard_view', 'analytics_view', 'reports_export', 
            'projects_view', 'projects_create', 'projects_edit',
            'team_view', 'team_add', 'team_edit',
            'team_manage'
        ],
        'developer': [
            'dashboard_view', 'analytics_view',
            'projects_view', 'projects_create', 'projects_edit',
            'team_view'
        ],
        'analyst': [
            'dashboard_view', 'analytics_view', 'reports_export', 'projects_view',
            'team_view'
        ],
        'member': [
            'dashboard_view', 'analytics_view', 'projects_view', 'projects_edit',
            'team_view'
        ],
        'client': [
            'dashboard_view', 'projects_view',
            'team_view'
        ],
        'viewer': [
            'dashboard_view', 'projects_view'
        ]
    };
    
    const selectedRole = roleSelect.value;
    console.log('Selected role:', selectedRole);
    
    // أولاً، إلغاء تحديد جميع الصلاحيات
    const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
    console.log('Found checkboxes:', checkboxes.length);
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    
    // ثم تحديد الصلاحيات المناسبة للدور المحدد
    if (rolePermissions[selectedRole]) {
        rolePermissions[selectedRole].forEach(permission => {
            const checkbox = document.getElementById(`perm_${permission}`);
            if (checkbox) {
                checkbox.checked = true;
                console.log(`Setting ${permission} to checked`);
            } else {
                console.log(`Checkbox for ${permission} not found`);
            }
        });
    }
}

// تنفيذ بعد تحميل الصفحة لضمان وجود جميع العناصر
window.onload = function() {
    console.log('Window loaded, initializing permissions');
    updatePermissionsByRole();
    
    // الاستماع لأحداث تغيير الدور
    const roleSelect = document.getElementById('member_role');
    if (roleSelect) {
        roleSelect.addEventListener('change', function() {
            console.log('Role changed to:', roleSelect.value);
            updatePermissionsByRole();
        });
    }
};

// للتأكد فورًا من وجود العناصر
setTimeout(function() {
    console.log('Running delayed check');
    const roleSelect = document.getElementById('member_role');
    const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
    console.log('Role select exists:', !!roleSelect);
    console.log('Checkboxes found:', checkboxes.length);
    
    if (roleSelect && checkboxes.length > 0) {
        updatePermissionsByRole();
    }
}, 500);

// Script para tablas con solución directa: script reescrito sin dependencias
document.addEventListener('DOMContentLoaded', function() {
    // Registrar todos los botones de pestañas y su funcionamiento en consola
    const tabs = [
        {button: 'profile', content: 'profile'},
        {button: 'security', content: 'security'},
        {button: 'team', content: 'team'},
        {button: 'notifications', content: 'notifications'},
        {button: 'branding', content: 'branding'},
        {button: 'advanced', content: 'advanced'}
    ];
    
    // Comprobar todos los elementos
    console.log('Comprobando elementos de pestañas:');
    tabs.forEach(tab => {
        const btn = document.querySelector(`[data-tab="${tab.button}"]`);
        const content = document.getElementById(tab.content);
        console.log(`Tab ${tab.button}: botón ${btn ? 'encontrado' : 'NO ENCONTRADO'}, contenido ${content ? 'encontrado' : 'NO ENCONTRADO'}`);
    });
    
    // Ocultar primero todos los contenidos
    tabs.forEach(tab => {
        const content = document.getElementById(tab.content);
        if (content) {
            content.classList.add('hidden');
        }
    });
    
    // Remover clases activas de todos los botones
    tabs.forEach(tab => {
        const btn = document.querySelector(`[data-tab="${tab.button}"]`);
        if (btn) {
            btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
            btn.classList.add('border-transparent', 'text-gray-500');
        }
    });
    
    // Mostrar la primera pestaña por defecto
    const firstContentEl = document.getElementById('profile');
    const firstBtnEl = document.querySelector('[data-tab="profile"]');
    if (firstContentEl) firstContentEl.classList.remove('hidden');
    if (firstBtnEl) {
        firstBtnEl.classList.add('active', 'border-blue-500', 'text-blue-600');
        firstBtnEl.classList.remove('border-transparent', 'text-gray-500');
    }
    
    // Configurar eventos de clic para cada botón de pestaña
    tabs.forEach(tab => {
        const btn = document.querySelector(`[data-tab="${tab.button}"]`);
        if (btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log(`Clic en pestaña: ${tab.button}`);
                
                // Ocultar todos los contenidos
                tabs.forEach(t => {
                    const c = document.getElementById(t.content);
                    if (c) c.classList.add('hidden');
                    
                    const b = document.querySelector(`[data-tab="${t.button}"]`);
                    if (b) {
                        b.classList.remove('active', 'border-blue-500', 'text-blue-600');
                        b.classList.add('border-transparent', 'text-gray-500');
                    }
                });
                
                // Mostrar el contenido seleccionado
                const selectedContent = document.getElementById(tab.content);
                if (selectedContent) {
                    selectedContent.classList.remove('hidden');
                    console.log(`Mostrando contenido de: ${tab.content}`);
                } else {
                    console.error(`No se encontró contenido para: ${tab.content}`);
                }
                
                // Activar el botón seleccionado
                btn.classList.add('active', 'border-blue-500', 'text-blue-600');
                btn.classList.remove('border-transparent', 'text-gray-500');
            });
        }
    });
    
    // Funcionalidad para el formulario de branding
    const logoSettingSelect = document.getElementById('logo_setting');
    const textLogoContainer = document.getElementById('textLogoContainer');
    
    if (logoSettingSelect && textLogoContainer) {
        // Inicializar visibilidad del campo de texto del logo
        textLogoContainer.classList.toggle('hidden', logoSettingSelect.value !== 'text');
        
        // Manejar cambio en la selección del tipo de logo
        logoSettingSelect.addEventListener('change', function() {
            textLogoContainer.classList.toggle('hidden', this.value !== 'text');
        });
    }
    
    // Actualizar los campos de texto del color cuando cambian los inputs de color
    const primaryColorInput = document.getElementById('primary_color');
    const secondaryColorInput = document.getElementById('secondary_color');
    const primaryColorHex = document.getElementById('primary_color_hex');
    const secondaryColorHex = document.getElementById('secondary_color_hex');
    
    if (primaryColorInput && primaryColorHex) {
        primaryColorInput.addEventListener('input', function() {
            primaryColorHex.value = this.value;
        });
    }
    
    if (secondaryColorInput && secondaryColorHex) {
        secondaryColorInput.addEventListener('input', function() {
            secondaryColorHex.value = this.value;
        });
    }
});

// Función para previsualizar la imagen de perfil
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('image-preview').src = e.target.result;
            document.getElementById('image-preview-container').classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

function uploadProfileImage(input) {
    if (input.files && input.files[0]) {
        // Mostrar vista previa primero
        previewImage(input);
        
        // Mostrar estado de carga
        document.getElementById('upload-status').classList.remove('hidden');
        
        // Crear FormData para enviar el archivo
        const formData = new FormData();
        formData.append('profile_image', input.files[0]);
        formData.append('_token', '{{ csrf_token() }}');
        
        // Realizar la petición AJAX
        fetch('{{ route("user.settings.upload-profile-image") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Ocultar estado de carga
            document.getElementById('upload-status').classList.add('hidden');
            
            if (data.success) {
                // Actualizar la imagen de perfil en la página
                const profileImages = document.querySelectorAll('.profile-image');
                profileImages.forEach(img => {
                    img.src = data.imageUrl;
                });
                
                // Mostrar mensaje de éxito
                const successAlert = document.createElement('div');
                successAlert.className = 'mt-2 text-sm text-green-600';
                successAlert.textContent = data.message;
                document.getElementById('image-preview-container').after(successAlert);
                
                // Quitar el mensaje después de 3 segundos
                setTimeout(() => {
                    successAlert.remove();
                }, 3000);
            } else {
                // Mostrar mensaje de error
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            // Ocultar estado de carga
            document.getElementById('upload-status').classList.add('hidden');
            console.error('Error:', error);
            alert('An error occurred while uploading the image.');
        });
    }
}

// Agregar evento de carga de imagen de perfil
document.getElementById('profile_image').addEventListener('change', function() {
    uploadProfileImage(this);
});
</script>
@endsection
