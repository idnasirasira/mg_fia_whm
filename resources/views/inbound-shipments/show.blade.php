@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-neutral-900">Inbound Shipment</h1>
                <p class="text-sm text-neutral-500 mt-1">Tracking: {{ $inboundShipment->tracking_number }}</p>
            </div>
            <div class="flex space-x-3">
                <x-button-edit href="{{ route('inbound-shipments.edit', $inboundShipment) }}" />
                <x-button-back href="{{ route('inbound-shipments.index') }}" />
            </div>
        </div>

        @if(session('success'))
        <div class="mb-4 bg-secondary-50 border border-secondary-200 text-secondary-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <!-- Shipment Details -->
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6 mb-6">
            <h2 class="text-lg font-semibold text-neutral-900 mb-4">Shipment Details</h2>
            <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Customer</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $inboundShipment->customer->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Received Date</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $inboundShipment->received_date->format('M d, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Status</dt>
                    <dd class="mt-1">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $inboundShipment->status === 'stored' ? 'bg-secondary-100 text-secondary-800' : 
                               ($inboundShipment->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-accent-100 text-accent-800') }}">
                            {{ ucfirst($inboundShipment->status) }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Total Items</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $inboundShipment->total_items }}</dd>
                </div>
                @if($inboundShipment->notes)
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-neutral-500">Notes</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $inboundShipment->notes }}</dd>
                </div>
                @endif
            </dl>
        </div>

        <!-- Packages -->
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-200">
                <h2 class="text-lg font-semibold text-neutral-900">Packages ({{ $inboundShipment->packages->count() }})</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead class="bg-neutral-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Weight</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Value</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-neutral-200">
                        @foreach($inboundShipment->packages as $package)
                        <tr class="hover:bg-neutral-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                {{ $package->product ? $package->product->name : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ $package->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ $package->weight ? $package->weight . ' kg' : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">${{ number_format($package->value, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                {{ $package->location ? $package->location->name : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-primary-100 text-primary-800">
                                    {{ ucfirst($package->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection