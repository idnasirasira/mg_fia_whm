@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-neutral-900 mb-6">Edit Shipping Zone</h1>
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
            <form action="{{ route('shipping-zones.update', $shippingZone) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-neutral-700">Zone Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $shippingZone->name) }}" required
                               class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('name') border-status-error @enderror">
                        @error('name')<p class="mt-1 text-sm text-status-error">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Countries *</label>
                        <div class="border border-neutral-300 rounded-lg p-4 max-h-64 overflow-y-auto">
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach(config('countries.countries') as $code => $name)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="countries[]" value="{{ $code }}" 
                                               class="rounded border-neutral-300 text-primary-600 focus:ring-primary-500"
                                               {{ in_array($code, old('countries', $shippingZone->countries ?? [])) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-neutral-700">{{ $name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        @error('countries')<p class="mt-1 text-sm text-status-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                        <div>
                            <label for="base_rate" class="block text-sm font-medium text-neutral-700">Base Rate ($)</label>
                            <input type="number" step="0.01" name="base_rate" id="base_rate" value="{{ old('base_rate', $shippingZone->shipping_rates['base_rate'] ?? 0) }}" min="0"
                                   class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label for="per_kg_rate" class="block text-sm font-medium text-neutral-700">Per Kg Rate ($)</label>
                            <input type="number" step="0.01" name="per_kg_rate" id="per_kg_rate" value="{{ old('per_kg_rate', $shippingZone->shipping_rates['per_kg_rate'] ?? 0) }}" min="0"
                                   class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label for="estimated_delivery" class="block text-sm font-medium text-neutral-700">Est. Delivery (days)</label>
                            <input type="number" name="estimated_delivery" id="estimated_delivery" value="{{ old('estimated_delivery', $shippingZone->estimated_delivery) }}" min="1"
                                   class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('shipping-zones.index') }}" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 bg-white hover:bg-neutral-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">Update Zone</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

