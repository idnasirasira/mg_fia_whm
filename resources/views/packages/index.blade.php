@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-neutral-900">Packages</h1>
            <div class="flex space-x-3">
                <a href="{{ route('packages.track', '') }}" class="px-4 py-2 bg-secondary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary-700">
                    Track Package
                </a>
            </div>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Inbound</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Outbound</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-neutral-200">
                        @forelse($packages as $package)
                            <tr class="hover:bg-neutral-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900">#{{ $package->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                    {{ $package->product ? $package->product->name : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ $package->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($package->inboundShipment)
                                        <a href="{{ route('inbound-shipments.show', $package->inboundShipment) }}" class="text-primary-600 hover:text-primary-900">
                                            {{ $package->inboundShipment->tracking_number }}
                                        </a>
                                    @else
                                        <span class="text-neutral-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($package->outboundShipment)
                                        <a href="{{ route('outbound-shipments.show', $package->outboundShipment) }}" class="text-primary-600 hover:text-primary-900">
                                            {{ $package->outboundShipment->tracking_number }}
                                        </a>
                                    @else
                                        <span class="text-neutral-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $package->status === 'delivered' ? 'bg-secondary-100 text-secondary-800' : 
                                           ($package->status === 'shipped' ? 'bg-accent-100 text-accent-800' : 'bg-primary-100 text-primary-800') }}">
                                        {{ ucfirst($package->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('packages.show', $package) }}" class="text-primary-600 hover:text-primary-900">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-neutral-500">
                                    No packages found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($packages->hasPages())
                <div class="px-6 py-4 border-t border-neutral-200">
                    {{ $packages->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

