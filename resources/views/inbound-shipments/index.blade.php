@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-neutral-900">Inbound Shipments</h1>
            <a href="{{ route('inbound-shipments.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Receive Shipment
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-secondary-50 border border-secondary-200 text-secondary-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-xl border border-neutral-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead class="bg-neutral-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Tracking #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Received Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-neutral-200">
                        @forelse($shipments as $shipment)
                            <tr class="hover:bg-neutral-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-primary-600">{{ $shipment->tracking_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">{{ $shipment->customer->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ $shipment->received_date->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ $shipment->total_items }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $shipment->status === 'stored' ? 'bg-secondary-100 text-secondary-800' : 
                                           ($shipment->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-accent-100 text-accent-800') }}">
                                        {{ ucfirst($shipment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('inbound-shipments.show', $shipment) }}" class="text-primary-600 hover:text-primary-900">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-neutral-500">
                                    No inbound shipments found. <a href="{{ route('inbound-shipments.create') }}" class="text-primary-600 hover:text-primary-900">Create one</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($shipments->hasPages())
                <div class="px-6 py-4 border-t border-neutral-200">
                    {{ $shipments->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

