@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-neutral-900">Warehouse Details</h1>
            <div class="flex space-x-3">
                <x-button-edit href="{{ route('warehouses.edit', $warehouse) }}" />
                <x-button-back href="{{ route('warehouses.index') }}" />
            </div>
        </div>
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
            <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Name</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $warehouse->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Type</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ ucfirst($warehouse->type) }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-neutral-500">Address</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $warehouse->address }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Status</dt>
                    <dd class="mt-1">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $warehouse->status === 'active' ? 'bg-secondary-100 text-secondary-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($warehouse->status) }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Capacity</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $warehouse->capacity ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Products</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $warehouse->products->count() }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Packages</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $warehouse->packages->count() }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection