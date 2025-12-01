@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-neutral-900">Shipping Report</h1>
            <a href="{{ route('reports.index') }}" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 bg-white hover:bg-neutral-50">Back to Reports</a>
        </div>

        <!-- Date Filter -->
        <div class="mb-6 bg-white shadow-md rounded-xl border border-neutral-200 p-6">
            <form method="GET" action="{{ route('reports.shipping') }}" class="flex flex-wrap gap-4 items-end">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-neutral-700 mb-1">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                           class="px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-neutral-700 mb-1">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                           class="px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                    Filter
                </button>
            </form>
        </div>

        <!-- Inbound Shipments -->
        <div class="mb-6 bg-white shadow-md rounded-xl border border-neutral-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-200">
                <h2 class="text-lg font-semibold text-neutral-900">Inbound Shipments ({{ $inboundShipments->count() }})</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead class="bg-neutral-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Tracking #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Received Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-neutral-200">
                        @forelse($inboundShipments as $shipment)
                            <tr class="hover:bg-neutral-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('inbound-shipments.show', $shipment) }}" class="text-primary-600 hover:text-primary-900">
                                        {{ $shipment->tracking_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">{{ $shipment->customer->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ $shipment->received_date->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-accent-100 text-accent-800">
                                        {{ ucfirst($shipment->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-neutral-500">No inbound shipments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Outbound Shipments -->
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-200">
                <h2 class="text-lg font-semibold text-neutral-900">Outbound Shipments ({{ $outboundShipments->count() }})</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead class="bg-neutral-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Tracking #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Shipping Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Destination</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Cost</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-neutral-200">
                        @forelse($outboundShipments as $shipment)
                            <tr class="hover:bg-neutral-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('outbound-shipments.show', $shipment) }}" class="text-primary-600 hover:text-primary-900">
                                        {{ $shipment->tracking_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">{{ $shipment->customer->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ $shipment->shipping_date->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                    {{ config('countries.countries')[$shipment->destination_country] ?? $shipment->destination_country }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-accent-100 text-accent-800">
                                        {{ ucfirst(str_replace('_', ' ', $shipment->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">${{ number_format($shipment->shipping_cost, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-neutral-500">No outbound shipments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

