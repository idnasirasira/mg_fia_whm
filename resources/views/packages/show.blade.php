@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-neutral-900">Package Details</h1>
            <x-button-back href="{{ route('packages.index') }}" />
        </div>

        @if(session('success'))
        <div class="mb-4 bg-secondary-50 border border-secondary-200 text-secondary-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
            <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
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
                    <dd class="mt-1 text-sm text-neutral-900">
                        @if($package->product)
                        <a href="{{ route('products.show', $package->product) }}" class="text-primary-600 hover:text-primary-900 font-medium">
                            {{ $package->product->name }}
                        </a>
                        @if($package->product->sku)
                        <span class="text-neutral-500 text-xs">({{ $package->product->sku }})</span>
                        @endif
                        @else
                        <span class="text-neutral-400">No Product Assigned</span>
                        @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                        <a href="{{ route('products.create-from-package', $package) }}" class="ml-2 text-xs text-accent-600 hover:text-accent-700 underline">
                            Create Product from Package
                        </a>
                        @endif
                        @endif
                    </dd>
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
                    <dt class="text-sm font-medium text-neutral-500">Dimensions</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $package->dimensions ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Value</dt>
                    <dd class="mt-1 text-sm text-neutral-900">${{ number_format($package->value, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Location</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $package->location ? $package->location->name : '-' }}</dd>
                </div>
                @if($package->inboundShipment)
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Inbound Shipment</dt>
                    <dd class="mt-1 text-sm">
                        <a href="{{ route('inbound-shipments.show', $package->inboundShipment) }}" class="text-primary-600 hover:text-primary-900">
                            {{ $package->inboundShipment->tracking_number }}
                        </a>
                    </dd>
                </div>
                @endif
                @if($package->outboundShipment)
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Outbound Shipment</dt>
                    <dd class="mt-1 text-sm">
                        <a href="{{ route('outbound-shipments.show', $package->outboundShipment) }}" class="text-primary-600 hover:text-primary-900">
                            {{ $package->outboundShipment->tracking_number }}
                        </a>
                    </dd>
                </div>
                @endif
                @if($package->customs_info)
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-neutral-500">Customs Information</dt>
                    <dd class="mt-1">
                        <div class="bg-neutral-50 border border-neutral-200 rounded-lg p-4">
                            @if(!empty($package->customs_info['hs_code']))
                            <div class="mb-2">
                                <span class="text-xs font-medium text-neutral-500">HS Code:</span>
                                <span class="ml-2 text-sm text-neutral-900 font-mono">{{ $package->customs_info['hs_code'] }}</span>
                            </div>
                            @endif
                            @if(!empty($package->customs_info['description']))
                            <div>
                                <span class="text-xs font-medium text-neutral-500">Description:</span>
                                <p class="mt-1 text-sm text-neutral-900">{{ $package->customs_info['description'] }}</p>
                            </div>
                            @endif
                        </div>
                    </dd>
                </div>
                @endif
            </dl>
        </div>
    </div>
</div>
@endsection