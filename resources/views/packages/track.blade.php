@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-neutral-900">Track Package</h1>
            <p class="text-sm text-neutral-500 mt-1">Enter tracking number to track your package status</p>
        </div>

        <!-- Search Form -->
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6 mb-6">
            <form action="{{ route('packages.track') }}" method="GET" class="flex gap-3">
                <div class="flex-1">
                    <input
                        type="text"
                        name="tracking_number"
                        value="{{ $trackingNumber ?? '' }}"
                        placeholder="Enter tracking number (e.g., INB-xxx or OUT-xxx)"
                        required
                        class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 text-lg"
                        autofocus>
                </div>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-primary-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Track
                </button>
            </form>
        </div>

        @if(isset($trackingNumber) && !$packages)
        <!-- Not Found Message -->
        <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg mb-6">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 class="text-lg font-semibold text-red-800 mb-1">Package Not Found</h3>
                    <p class="text-red-700">No package found with tracking number: <strong>{{ $trackingNumber }}</strong></p>
                    <p class="text-sm text-red-600 mt-2">Please check the tracking number and try again.</p>
                </div>
            </div>
        </div>
        @endif

        @if($packages && $packages->isNotEmpty())
        <!-- Shipment Information -->
        @if($outboundShipment)
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-xl font-semibold text-neutral-900">Outbound Shipment</h2>
                    <p class="text-sm text-neutral-500 mt-1">Tracking: <span class="font-mono text-primary-600">{{ $outboundShipment->tracking_number }}</span></p>
                </div>
                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                            {{ $outboundShipment->status === 'delivered' ? 'bg-secondary-100 text-secondary-800' : 
                               ($outboundShipment->status === 'returned' ? 'bg-red-100 text-red-800' : 
                                ($outboundShipment->status === 'shipped' || $outboundShipment->status === 'in_transit' ? 'bg-primary-100 text-primary-800' : 'bg-accent-100 text-accent-800')) }}">
                    {{ ucfirst(str_replace('_', ' ', $outboundShipment->status)) }}
                </span>
            </div>

            <!-- Status Timeline -->
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-neutral-700 mb-4">Status Timeline</h3>
                <div class="relative">
                    <!-- Timeline Line -->
                    <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-neutral-200"></div>

                    <div class="space-y-4">
                        @php
                        $statuses = [
                        'pending' => ['label' => 'Pending', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                        'packed' => ['label' => 'Packed', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                        'shipped' => ['label' => 'Shipped', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                        'in_transit' => ['label' => 'In Transit', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
                        'delivered' => ['label' => 'Delivered', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        'returned' => ['label' => 'Returned', 'icon' => 'M14 5l7 7m0 0l-7 7m7-7H3'],
                        ];
                        $currentStatusIndex = array_search($outboundShipment->status, array_keys($statuses));
                        @endphp

                        @foreach($statuses as $statusKey => $statusInfo)
                        @php
                        $statusIndex = array_search($statusKey, array_keys($statuses));
                        $isActive = $statusIndex <= $currentStatusIndex;
                            $isCurrent=$statusIndex===$currentStatusIndex;
                            @endphp
                            <div class="relative flex items-start">
                            <div class="relative z-10 flex items-center justify-center w-8 h-8 rounded-full 
                                            {{ $isActive ? ($isCurrent ? 'bg-primary-600 text-white' : 'bg-secondary-500 text-white') : 'bg-neutral-200 text-neutral-400' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusInfo['icon'] }}" />
                                </svg>
                            </div>
                            <div class="ml-4 flex-1 pb-4">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium {{ $isActive ? 'text-neutral-900' : 'text-neutral-400' }}">
                                        {{ $statusInfo['label'] }}
                                    </p>
                                    @if($isCurrent)
                                    <span class="text-xs text-primary-600 font-medium">Current</span>
                                    @endif
                                </div>
                                @if($isActive && $isCurrent)
                                <p class="text-xs text-neutral-500 mt-1">
                                    @if($outboundShipment->status === 'shipped' || $outboundShipment->status === 'in_transit')
                                    @if($outboundShipment->shippingZone && $outboundShipment->shippingZone->estimated_delivery)
                                    Estimated delivery: {{ now()->addDays($outboundShipment->shippingZone->estimated_delivery)->format('M d, Y') }}
                                    @endif
                                    @elseif($outboundShipment->status === 'delivered')
                                    Delivered on {{ $outboundShipment->updated_at->format('M d, Y') }}
                                    @else
                                    Updated on {{ $outboundShipment->updated_at->format('M d, Y') }}
                                    @endif
                                </p>
                                @endif
                            </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Shipment Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-neutral-200">
            <div>
                <dt class="text-sm font-medium text-neutral-500">Customer</dt>
                <dd class="mt-1 text-sm text-neutral-900 font-medium">{{ $outboundShipment->customer->name }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-neutral-500">Destination</dt>
                <dd class="mt-1 text-sm text-neutral-900 font-medium">
                    {{ config('countries.countries')[$outboundShipment->destination_country] ?? $outboundShipment->destination_country }}
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-neutral-500">Shipping Date</dt>
                <dd class="mt-1 text-sm text-neutral-900">{{ $outboundShipment->shipping_date->format('M d, Y') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-neutral-500">Carrier</dt>
                <dd class="mt-1 text-sm text-neutral-900">{{ $outboundShipment->carrier ?: 'N/A' }}</dd>
            </div>
            @if($outboundShipment->shippingZone)
            <div>
                <dt class="text-sm font-medium text-neutral-500">Shipping Zone</dt>
                <dd class="mt-1 text-sm text-neutral-900">{{ $outboundShipment->shippingZone->name }}</dd>
            </div>
            @endif
            @if($outboundShipment->shippingZone && $outboundShipment->shippingZone->estimated_delivery)
            <div>
                <dt class="text-sm font-medium text-neutral-500">Estimated Delivery</dt>
                <dd class="mt-1 text-sm text-neutral-900">
                    {{ now()->addDays($outboundShipment->shippingZone->estimated_delivery)->format('M d, Y') }}
                    <span class="text-xs text-neutral-500">({{ $outboundShipment->shippingZone->estimated_delivery }} days)</span>
                </dd>
            </div>
            @endif
        </div>
    </div>
    @endif

    @if($inboundShipment)
    <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold text-neutral-900">Inbound Shipment</h2>
                <p class="text-sm text-neutral-500 mt-1">Tracking: <span class="font-mono text-primary-600">{{ $inboundShipment->tracking_number }}</span></p>
            </div>
            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                            {{ $inboundShipment->status === 'stored' ? 'bg-secondary-100 text-secondary-800' : 
                               ($inboundShipment->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-primary-100 text-primary-800') }}">
                {{ ucfirst($inboundShipment->status) }}
            </span>
        </div>

        <!-- Inbound Status Timeline -->
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-neutral-700 mb-4">Status Timeline</h3>
            <div class="relative">
                <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-neutral-200"></div>

                <div class="space-y-4">
                    @php
                    $inboundStatuses = [
                    'pending' => ['label' => 'Pending', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    'received' => ['label' => 'Received', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    'inspected' => ['label' => 'Inspected', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                    'stored' => ['label' => 'Stored', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                    'rejected' => ['label' => 'Rejected', 'icon' => 'M6 18L18 6M6 6l12 12'],
                    ];
                    $inboundCurrentStatusIndex = array_search($inboundShipment->status, array_keys($inboundStatuses));
                    @endphp

                    @foreach($inboundStatuses as $statusKey => $statusInfo)
                    @php
                    $statusIndex = array_search($statusKey, array_keys($inboundStatuses));
                    $isActive = $statusIndex <= $inboundCurrentStatusIndex;
                        $isCurrent=$statusIndex===$inboundCurrentStatusIndex;
                        @endphp
                        <div class="relative flex items-start">
                        <div class="relative z-10 flex items-center justify-center w-8 h-8 rounded-full 
                                            {{ $isActive ? ($isCurrent ? 'bg-primary-600 text-white' : 'bg-secondary-500 text-white') : 'bg-neutral-200 text-neutral-400' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusInfo['icon'] }}" />
                            </svg>
                        </div>
                        <div class="ml-4 flex-1 pb-4">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium {{ $isActive ? 'text-neutral-900' : 'text-neutral-400' }}">
                                    {{ $statusInfo['label'] }}
                                </p>
                                @if($isCurrent)
                                <span class="text-xs text-primary-600 font-medium">Current</span>
                                @endif
                            </div>
                            @if($isActive && $isCurrent)
                            <p class="text-xs text-neutral-500 mt-1">
                                Updated on {{ $inboundShipment->updated_at->format('M d, Y') }}
                            </p>
                            @endif
                        </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-neutral-200">
        <div>
            <dt class="text-sm font-medium text-neutral-500">Customer</dt>
            <dd class="mt-1 text-sm text-neutral-900 font-medium">{{ $inboundShipment->customer->name }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-neutral-500">Received Date</dt>
            <dd class="mt-1 text-sm text-neutral-900">{{ $inboundShipment->received_date->format('M d, Y') }}</dd>
        </div>
    </div>
</div>
@endif

<!-- Packages List -->
<div class="bg-white shadow-md rounded-xl border border-neutral-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-neutral-200">
        <h2 class="text-xl font-semibold text-neutral-900">Packages ({{ $packages->count() }})</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-neutral-200">
            <thead class="bg-neutral-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Package ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Weight</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Location</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-neutral-200">
                @foreach($packages as $package)
                <tr class="hover:bg-neutral-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900">#{{ $package->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                        {{ $package->product ? $package->product->name : 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ $package->quantity }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                        {{ $package->weight ? number_format($package->weight, 2) . ' kg' : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $package->status === 'delivered' ? 'bg-secondary-100 text-secondary-800' : 
                                               ($package->status === 'shipped' || $package->status === 'packed' ? 'bg-accent-100 text-accent-800' : 
                                                ($package->status === 'stored' ? 'bg-primary-100 text-primary-800' : 'bg-neutral-100 text-neutral-800')) }}">
                            {{ ucfirst($package->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                        {{ $package->location ? $package->location->name : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('packages.show', $package) }}" class="text-primary-600 hover:text-primary-900">
                            View Details
                        </a>
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