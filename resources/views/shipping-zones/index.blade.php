@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-neutral-900">Shipping Zones</h1>
            <a href="{{ route('shipping-zones.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Shipping Zone
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Countries</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Base Rate</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Per Kg Rate</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Est. Delivery</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Shipments</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-neutral-200">
                        @forelse($shippingZones as $zone)
                            <tr class="hover:bg-neutral-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900">{{ $zone->name }}</td>
                                <td class="px-6 py-4 text-sm text-neutral-500">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($zone->countries as $countryCode)
                                            <span class="px-2 py-1 bg-primary-100 text-primary-800 rounded text-xs">
                                                {{ config('countries.countries')[$countryCode] ?? $countryCode }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">${{ number_format($zone->shipping_rates['base_rate'] ?? 0, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">${{ number_format($zone->shipping_rates['per_kg_rate'] ?? 0, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                    {{ $zone->estimated_delivery ? $zone->estimated_delivery . ' days' : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ $zone->outbound_shipments_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('shipping-zones.show', $zone) }}" class="text-primary-600 hover:text-primary-900">View</a>
                                        <a href="{{ route('shipping-zones.edit', $zone) }}" class="text-accent-600 hover:text-accent-900">Edit</a>
                                        <form action="{{ route('shipping-zones.destroy', $zone) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-neutral-500">
                                    No shipping zones found. <a href="{{ route('shipping-zones.create') }}" class="text-primary-600 hover:text-primary-900">Create one</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($shippingZones->hasPages())
                <div class="px-6 py-4 border-t border-neutral-200">
                    {{ $shippingZones->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

