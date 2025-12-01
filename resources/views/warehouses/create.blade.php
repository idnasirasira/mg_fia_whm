@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-neutral-900 mb-6">Create Warehouse</h1>
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
            <form action="{{ route('warehouses.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-neutral-700">Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('name') border-status-error @enderror">
                        @error('name')<p class="mt-1 text-sm text-status-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-neutral-700">Address *</label>
                        <textarea name="address" id="address" rows="3" required
                                  class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('address') border-status-error @enderror">{{ old('address') }}</textarea>
                        @error('address')<p class="mt-1 text-sm text-status-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="type" class="block text-sm font-medium text-neutral-700">Type *</label>
                            <select name="type" id="type" required
                                    class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="warehouse" {{ old('type') == 'warehouse' ? 'selected' : '' }}>Warehouse</option>
                                <option value="location" {{ old('type') == 'location' ? 'selected' : '' }}>Location</option>
                                <option value="zone" {{ old('type') == 'zone' ? 'selected' : '' }}>Zone</option>
                            </select>
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-neutral-700">Status *</label>
                            <select name="status" id="status" required
                                    class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="capacity" class="block text-sm font-medium text-neutral-700">Capacity</label>
                        <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}" min="0"
                               class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('warehouses.index') }}" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 bg-white hover:bg-neutral-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">Create Warehouse</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

