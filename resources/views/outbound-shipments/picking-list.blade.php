@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-neutral-900">Picking List</h1>
                <p class="text-sm text-neutral-500 mt-1">Tracking: {{ $outboundShipment->tracking_number }}</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="window.print()" class="px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print
                </button>
                <a href="{{ route('outbound-shipments.show', $outboundShipment) }}" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 bg-white hover:bg-neutral-50">Back</a>
            </div>
        </div>

        <!-- Shipment Info -->
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6 mb-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <p class="text-sm font-medium text-neutral-500">Customer</p>
                    <p class="mt-1 text-lg font-semibold text-neutral-900">{{ $outboundShipment->customer->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-neutral-500">Destination</p>
                    <p class="mt-1 text-lg font-semibold text-neutral-900">
                        {{ config('countries.countries')[$outboundShipment->destination_country] ?? $outboundShipment->destination_country }}
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-neutral-500">Shipping Date</p>
                    <p class="mt-1 text-lg font-semibold text-neutral-900">{{ $outboundShipment->shipping_date->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Packages by Location -->
        <div class="space-y-6">
            @foreach($packagesByLocation as $locationName => $packages)
                <div class="bg-white shadow-md rounded-xl border border-neutral-200 overflow-hidden">
                    <div class="px-6 py-4 bg-primary-50 border-b border-primary-200">
                        <h2 class="text-lg font-semibold text-primary-900">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Location: {{ $locationName }}
                        </h2>
                        <p class="text-sm text-primary-700 mt-1">{{ $packages->count() }} package(s) to pick</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-neutral-200">
                            <thead class="bg-neutral-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Package #</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Weight</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Value</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">HS Code</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-neutral-500 uppercase tracking-wider">Picked</th>
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ $package->weight ? $package->weight . ' kg' : '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">${{ number_format($package->value, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-neutral-500">
                                            {{ $package->customs_info['hs_code'] ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <input type="checkbox" class="rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Summary -->
        <div class="mt-6 bg-white shadow-md rounded-xl border border-neutral-200 p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Summary</h3>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                <div>
                    <p class="text-sm text-neutral-500">Total Packages</p>
                    <p class="text-2xl font-semibold text-neutral-900">{{ $outboundShipment->packages->count() }}</p>
                </div>
                <div>
                    <p class="text-sm text-neutral-500">Total Quantity</p>
                    <p class="text-2xl font-semibold text-neutral-900">{{ $outboundShipment->packages->sum('quantity') }}</p>
                </div>
                <div>
                    <p class="text-sm text-neutral-500">Total Weight</p>
                    <p class="text-2xl font-semibold text-neutral-900">{{ number_format($outboundShipment->packages->sum('weight'), 2) }} kg</p>
                </div>
                <div>
                    <p class="text-sm text-neutral-500">Total Value</p>
                    <p class="text-2xl font-semibold text-neutral-900">${{ number_format($outboundShipment->packages->sum('value'), 2) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    nav, .no-print {
        display: none !important;
    }
    body {
        background: white;
    }
    .bg-white {
        background: white !important;
    }
}
</style>
@endsection

