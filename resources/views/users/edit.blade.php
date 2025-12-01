@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-neutral-900 mb-6">Edit User</h1>
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-neutral-700">Full Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                               class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('name') border-status-error @enderror">
                        @error('name')<p class="mt-1 text-sm text-status-error">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-neutral-700">Email Address *</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                               class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('email') border-status-error @enderror">
                        @error('email')<p class="mt-1 text-sm text-status-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="password" class="block text-sm font-medium text-neutral-700">New Password (Leave blank to keep current)</label>
                            <input type="password" name="password" id="password"
                                   class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('password') border-status-error @enderror">
                            @error('password')<p class="mt-1 text-sm text-status-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-neutral-700">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-neutral-700">Role *</label>
                        <select name="role" id="role" required
                                class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('role') border-status-error @enderror">
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                        @error('role')<p class="mt-1 text-sm text-status-error">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="warehouse_id" class="block text-sm font-medium text-neutral-700">Warehouse (Optional)</label>
                        <select name="warehouse_id" id="warehouse_id"
                                class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('warehouse_id') border-status-error @enderror">
                            <option value="">No Warehouse Assignment</option>
                            @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ old('warehouse_id', $user->warehouse_id) == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }} ({{ $warehouse->address }})
                                </option>
                            @endforeach
                        </select>
                        @error('warehouse_id')<p class="mt-1 text-sm text-status-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('users.index') }}" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 bg-white hover:bg-neutral-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

