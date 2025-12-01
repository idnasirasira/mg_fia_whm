@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-neutral-900">Shipping Zone Details</h1>
            <div class="flex space-x-3">
                <x-button-edit href="{{ route('shipping-zones.edit', $shippingZone) }}" />
                <x-button-back href="{{ route('shipping-zones.index') }}" />
            </div>
        </div>

        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6 mb-6">
            <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Zone Name</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $shippingZone->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Estimated Delivery</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $shippingZone->estimated_delivery ? $shippingZone->estimated_delivery . ' days' : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Base Rate</dt>
                    <dd class="mt-1 text-sm text-neutral-900">${{ number_format($shippingZone->shipping_rates['base_rate'] ?? 0, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Per Kg Rate</dt>
                    <dd class="mt-1 text-sm text-neutral-900">${{ number_format($shippingZone->shipping_rates['per_kg_rate'] ?? 0, 2) }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-neutral-500 mb-2">Countries</dt>
                    <dd class="mt-1">
                        <div class="flex flex-wrap gap-2">
                            @foreach($shippingZone->countries as $countryCode)
                            <span class="px-3 py-1 bg-primary-100 text-primary-800 rounded-lg text-sm">
                                {{ config('countries.countries')[$countryCode] ?? $countryCode }}
                            </span>
                            @endforeach
                        </div>
                    </dd>
                </div>
            </dl>
        </div>

        @if($shippingZone->outboundShipments->count() > 0)
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-200">
                <h2 class="text-lg font-semibold text-neutral-900">Outbound Shipments ({{ $shippingZone->outboundShipments->count() }})</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead class="bg-neutral-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Tracking #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Destination</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-neutral-200">
                        @foreach($shippingZone->outboundShipments as $shipment)
                        <tr class="hover:bg-neutral-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('outbound-shipments.show', $shipment) }}" class="text-primary-600 hover:text-primary-900">
                                    {{ $shipment->tracking_number }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">{{ $shipment->customer->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ config('countries.countries')[$shipment->destination_country] ?? $shipment->destination_country }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-accent-100 text-accent-800">
                                    {{ ucfirst(str_replace('_', ' ', $shipment->status)) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection