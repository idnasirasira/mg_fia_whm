@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-neutral-900 mb-6">Track Package</h1>

        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6 mb-6">
            <form action="{{ route('packages.track', '') }}" method="GET" class="flex gap-3">
                <input type="text" name="tracking_number" value="{{ $trackingNumber ?? '' }}" placeholder="Enter tracking number (INB-xxx or OUT-xxx)" required
                       class="flex-1 px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                <button type="submit" class="px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                    Track
                </button>
            </form>
        </div>

        @if(isset($package) && $package)
            <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
                <h2 class="text-xl font-semibold text-neutral-900 mb-4">Package Information</h2>
                
                <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2 mb-6">
                    <div>
                        <dt class="text-sm font-medium text-neutral-500">Package ID</dt>
                        <dd class="mt-1 text-sm text-neutral-900">#{{ $package->id }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-500">Status</dt>
                        <dd class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $package->status === 'delivered' ? 'bg-secondary-100 text-secondary-800' : 
                                   ($package->status === 'shipped' ? 'bg-accent-100 text-accent-800' : 'bg-primary-100 text-primary-800') }}">
                                {{ ucfirst($package->status) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-500">Product</dt>
                        <dd class="mt-1 text-sm text-neutral-900">{{ $package->product ? $package->product->name : 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-500">Quantity</dt>
                        <dd class="mt-1 text-sm text-neutral-900">{{ $package->quantity }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-500">Weight</dt>
                        <dd class="mt-1 text-sm text-neutral-900">{{ $package->weight ? $package->weight . ' kg' : '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-500">Value</dt>
                        <dd class="mt-1 text-sm text-neutral-900">${{ number_format($package->value, 2) }}</dd>
                    </div>
                </dl>

                @if($package->inboundShipment)
                <div class="border-t border-neutral-200 pt-6">
                    <h3 class="text-lg font-semibold text-neutral-900 mb-3">Inbound Shipment</h3>
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">Tracking Number</dt>
                            <dd class="mt-1 text-sm text-primary-600">{{ $package->inboundShipment->tracking_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">Customer</dt>
                            <dd class="mt-1 text-sm text-neutral-900">{{ $package->inboundShipment->customer->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">Received Date</dt>
                            <dd class="mt-1 text-sm text-neutral-900">{{ $package->inboundShipment->received_date->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">Status</dt>
                            <dd class="mt-1 text-sm text-neutral-900">{{ ucfirst($package->inboundShipment->status) }}</dd>
                        </div>
                    </dl>
                </div>
                @endif

                @if($package->outboundShipment)
                <div class="border-t border-neutral-200 pt-6 mt-6">
                    <h3 class="text-lg font-semibold text-neutral-900 mb-3">Outbound Shipment</h3>
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">Tracking Number</dt>
                            <dd class="mt-1 text-sm text-primary-600">{{ $package->outboundShipment->tracking_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">Customer</dt>
                            <dd class="mt-1 text-sm text-neutral-900">{{ $package->outboundShipment->customer->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">Destination</dt>
                            <dd class="mt-1 text-sm text-neutral-900">{{ config('countries.countries')[$package->outboundShipment->destination_country] ?? $package->outboundShipment->destination_country }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">Shipping Date</dt>
                            <dd class="mt-1 text-sm text-neutral-900">{{ $package->outboundShipment->shipping_date->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">Status</dt>
                            <dd class="mt-1 text-sm text-neutral-900">{{ ucfirst(str_replace('_', ' ', $package->outboundShipment->status)) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">Carrier</dt>
                            <dd class="mt-1 text-sm text-neutral-900">{{ $package->outboundShipment->carrier ?: '-' }}</dd>
                        </div>
                    </dl>
                </div>
                @endif
            </div>
        @elseif(isset($trackingNumber))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                Package not found with tracking number: {{ $trackingNumber }}
            </div>
        @endif
    </div>
</div>
@endsection

