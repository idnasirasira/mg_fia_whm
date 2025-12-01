@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-neutral-900 mb-6">Edit Inbound Shipment</h1>
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
            <form action="{{ route('inbound-shipments.update', $inboundShipment) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="customer_id" class="block text-sm font-medium text-neutral-700">Customer *</label>
                            <select name="customer_id" id="customer_id" required
                                    class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id', $inboundShipment->customer_id) == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="received_date" class="block text-sm font-medium text-neutral-700">Received Date *</label>
                            <input type="date" name="received_date" id="received_date" value="{{ old('received_date', $inboundShipment->received_date->format('Y-m-d')) }}" required
                                   class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-neutral-700">Status *</label>
                        <select name="status" id="status" required
                                class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="pending" {{ old('status', $inboundShipment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="received" {{ old('status', $inboundShipment->status) == 'received' ? 'selected' : '' }}>Received</option>
                            <option value="inspected" {{ old('status', $inboundShipment->status) == 'inspected' ? 'selected' : '' }}>Inspected</option>
                            <option value="stored" {{ old('status', $inboundShipment->status) == 'stored' ? 'selected' : '' }}>Stored</option>
                            <option value="rejected" {{ old('status', $inboundShipment->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-medium text-neutral-700">Notes</label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('notes', $inboundShipment->notes) }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('inbound-shipments.index') }}" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 bg-white hover:bg-neutral-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">Update Shipment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

