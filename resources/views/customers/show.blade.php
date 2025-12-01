@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-neutral-900">Customer Details</h1>
            <div class="flex space-x-3">
                <x-button-edit href="{{ route('customers.edit', $customer) }}" />
                <x-button-back href="{{ route('customers.index') }}" />
            </div>
        </div>
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
            <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Name</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $customer->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Email</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $customer->email ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Phone</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $customer->phone ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Country</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ config('countries.countries')[$customer->country] ?? $customer->country }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-neutral-500">Address</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $customer->address }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Tax ID</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $customer->tax_id ?: '-' }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection