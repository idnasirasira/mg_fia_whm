@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-neutral-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="flex justify-center">
                <svg class="w-16 h-16 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-neutral-900">
                Add New User
            </h2>
            <p class="mt-2 text-center text-sm text-neutral-600">
                Create a new user account for the system
            </p>
        </div>
        
        @if(session('success'))
            <div class="bg-secondary-50 border border-secondary-200 text-secondary-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf

            <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6 space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-neutral-700">Full Name *</label>
                    <input id="name" name="name" type="text" required 
                           value="{{ old('name') }}"
                           class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('name') border-status-error @enderror"
                           placeholder="John Doe">
                    @error('name')
                        <p class="mt-1 text-sm text-status-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-neutral-700">Email Address *</label>
                    <input id="email" name="email" type="email" required 
                           value="{{ old('email') }}"
                           class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('email') border-status-error @enderror"
                           placeholder="john@example.com">
                    @error('email')
                        <p class="mt-1 text-sm text-status-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-neutral-700">Password *</label>
                    <input id="password" name="password" type="password" required 
                           class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('password') border-status-error @enderror"
                           placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-sm text-status-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-neutral-700">Confirm Password *</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                           class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                           placeholder="••••••••">
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-neutral-700">Role *</label>
                    <select id="role" name="role" required 
                            class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('role') border-status-error @enderror">
                        <option value="">Select Role</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-status-error">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-neutral-500">
                        <strong>Admin:</strong> Full system access<br>
                        <strong>Manager:</strong> Manage operations<br>
                        <strong>Staff:</strong> Basic access
                    </p>
                </div>

                <div>
                    <label for="warehouse_id" class="block text-sm font-medium text-neutral-700">Warehouse (Optional)</label>
                    <select id="warehouse_id" name="warehouse_id" 
                            class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('warehouse_id') border-status-error @enderror">
                        <option value="">No Warehouse Assignment</option>
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                {{ $warehouse->name }} ({{ $warehouse->address }})
                            </option>
                        @endforeach
                    </select>
                    @error('warehouse_id')
                        <p class="mt-1 text-sm text-status-error">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-neutral-500">Assign user to a specific warehouse</p>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="text-sm text-neutral-600 hover:text-primary-600">
                    ← Back to Dashboard
                </a>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent rounded-lg font-semibold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-primary-500 group-hover:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </span>
                    Create User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

