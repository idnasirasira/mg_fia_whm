@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-neutral-900">Outbound Shipment</h1>
                <p class="text-sm text-neutral-500 mt-1">Tracking: {{ $outboundShipment->tracking_number }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('outbound-shipments.shipping-label', $outboundShipment) }}" target="_blank" class="px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Label
                </a>
                <a href="{{ route('outbound-shipments.picking-list', $outboundShipment) }}" class="px-4 py-2 bg-secondary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary-700">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Picking List
                </a>
                <x-button-edit href="{{ route('outbound-shipments.edit', $outboundShipment) }}" />
                <x-button-back href="{{ route('outbound-shipments.index') }}" />
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
                    <dd class="mt-1 text-sm text-neutral-900">{{ $outboundShipment->customer->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Shipping Date</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $outboundShipment->shipping_date->format('M d, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Destination Country</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ config('countries.countries')[$outboundShipment->destination_country] ?? $outboundShipment->destination_country }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Courier</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $outboundShipment->carrier ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Status</dt>
                    <dd class="mt-1">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $outboundShipment->status === 'delivered' ? 'bg-secondary-100 text-secondary-800' : 
                               ($outboundShipment->status === 'returned' ? 'bg-red-100 text-red-800' : 'bg-accent-100 text-accent-800') }}">
                            {{ ucfirst(str_replace('_', ' ', $outboundShipment->status)) }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Shipping Zone</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $outboundShipment->shippingZone ? $outboundShipment->shippingZone->name : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Customs Value</dt>
                    <dd class="mt-1 text-sm text-neutral-900">${{ number_format($outboundShipment->customs_value, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Shipping Cost</dt>
                    <dd class="mt-1 text-sm text-neutral-900">${{ number_format($outboundShipment->shipping_cost, 2) }}</dd>
                </div>
            </dl>
        </div>

        <!-- Packages -->
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-200">
                <h2 class="text-lg font-semibold text-neutral-900">Packages ({{ $outboundShipment->packages->count() }})</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead class="bg-neutral-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Weight</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Value</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">HS Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-neutral-200">
                        @foreach($outboundShipment->packages as $package)
                        <tr class="hover:bg-neutral-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                {{ $package->product ? $package->product->name : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ $package->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ $package->weight ? $package->weight . ' kg' : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">${{ number_format($package->value, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-neutral-500">
                                {{ $package->customs_info['hs_code'] ?? '-' }}
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