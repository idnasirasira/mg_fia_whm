@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-neutral-900">Outbound Shipments</h1>
            <a href="{{ route('outbound-shipments.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create Shipment
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Destination</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Shipping Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-neutral-200">
                        @forelse($shipments as $shipment)
                        <tr class="hover:bg-neutral-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-primary-600">{{ $shipment->tracking_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">{{ $shipment->customer->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ config('countries.countries')[$shipment->destination_country] ?? $shipment->destination_country }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ $shipment->shipping_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <form action="{{ route('outbound-shipments.update-status', $shipment) }}" method="POST" class="status-form" data-shipment-id="{{ $shipment->id }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status"
                                        class="status-select text-xs font-semibold rounded-full px-3 py-1 border-0 focus:ring-2 focus:ring-primary-500 transition-colors
                                                    {{ $shipment->status === 'delivered' ? 'bg-secondary-100 text-secondary-800 hover:bg-secondary-200' : 
                                                       ($shipment->status === 'returned' ? 'bg-red-100 text-red-800 hover:bg-red-200' : 
                                                       ($shipment->status === 'shipped' || $shipment->status === 'in_transit' ? 'bg-blue-100 text-blue-800 hover:bg-blue-200' : 
                                                       'bg-accent-100 text-accent-800 hover:bg-accent-200')) }}">
                                        <option value="pending" {{ $shipment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="packed" {{ $shipment->status === 'packed' ? 'selected' : '' }}>Packed</option>
                                        <option value="shipped" {{ $shipment->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="in_transit" {{ $shipment->status === 'in_transit' ? 'selected' : '' }}>In Transit</option>
                                        <option value="delivered" {{ $shipment->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="returned" {{ $shipment->status === 'returned' ? 'selected' : '' }}>Returned</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center space-x-3">
                                    <a href="{{ route('outbound-shipments.show', $shipment) }}" class="text-primary-600 hover:text-primary-900">View</a>
                                    <a href="{{ route('outbound-shipments.edit', $shipment) }}" class="text-accent-600 hover:text-accent-900">Edit</a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-neutral-500">
                                No outbound shipments found. <a href="{{ route('outbound-shipments.create') }}" class="text-primary-600 hover:text-primary-900">Create one</a>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelects = document.querySelectorAll('.status-select');

        statusSelects.forEach(select => {
            const originalValue = select.value;
            const form = select.closest('form');

            select.addEventListener('change', function() {
                const newStatus = this.value;

                // Show loading state
                this.disabled = true;
                this.classList.add('opacity-50', 'cursor-not-allowed');

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ||
                    form.querySelector('input[name="_token"]')?.value;

                // Submit form via AJAX
                fetch(form.action, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({
                            status: newStatus,
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.message || 'Failed to update status');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Update select styling based on new status
                            select.className = select.className.replace(/bg-\w+-\d+ text-\w+-\d+ hover:bg-\w+-\d+/, '');

                            if (newStatus === 'delivered') {
                                select.classList.add('bg-secondary-100', 'text-secondary-800', 'hover:bg-secondary-200');
                            } else if (newStatus === 'returned') {
                                select.classList.add('bg-red-100', 'text-red-800', 'hover:bg-red-200');
                            } else if (newStatus === 'shipped' || newStatus === 'in_transit') {
                                select.classList.add('bg-blue-100', 'text-blue-800', 'hover:bg-blue-200');
                            } else {
                                select.classList.add('bg-accent-100', 'text-accent-800', 'hover:bg-accent-200');
                            }

                            // Show success message
                            showNotification('Status updated successfully!', 'success');
                        } else {
                            throw new Error(data.message || 'Failed to update status');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Revert to original value
                        select.value = originalValue;
                        showNotification('Failed to update status. Please try again.', 'error');
                    })
                    .finally(() => {
                        // Remove loading state
                        select.disabled = false;
                        select.classList.remove('opacity-50', 'cursor-not-allowed');
                    });
            });
        });

        function showNotification(message, type) {
            // Remove existing notifications
            const existing = document.querySelector('.status-notification');
            if (existing) {
                existing.remove();
            }

            // Create notification
            const notification = document.createElement('div');
            notification.className = `status-notification fixed top-20 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transition-all duration-300 ${
            type === 'success' ? 'bg-secondary-50 border border-secondary-200 text-secondary-800' : 'bg-red-50 border border-red-200 text-red-800'
        }`;
            notification.textContent = message;

            document.body.appendChild(notification);

            // Auto remove after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    });
</script>
@endsection