@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-neutral-900 mb-6">Edit Customer</h1>
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
            <form action="{{ route('customers.update', $customer) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium text-neutral-700">Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" required
                               class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('name') border-status-error @enderror">
                        @error('name')<p class="mt-1 text-sm text-status-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-neutral-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}"
                               class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('email') border-status-error @enderror">
                        @error('email')<p class="mt-1 text-sm text-status-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-neutral-700">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $customer->phone) }}"
                               class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="address" class="block text-sm font-medium text-neutral-700">Address *</label>
                        <textarea name="address" id="address" rows="3" required
                                  class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('address') border-status-error @enderror">{{ old('address', $customer->address) }}</textarea>
                        @error('address')<p class="mt-1 text-sm text-status-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="country" class="block text-sm font-medium text-neutral-700">Country *</label>
                        <select name="country" id="country" required
                                class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('country') border-status-error @enderror">
                            <option value="">Select Country</option>
                            @foreach(config('countries.countries') as $code => $name)
                                <option value="{{ $code }}" {{ old('country', $customer->country) == $code ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('country')<p class="mt-1 text-sm text-status-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="tax_id" class="block text-sm font-medium text-neutral-700">Tax ID</label>
                        <input type="text" name="tax_id" id="tax_id" value="{{ old('tax_id', $customer->tax_id) }}"
                               class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('customers.index') }}" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 bg-white hover:bg-neutral-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">Update Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

