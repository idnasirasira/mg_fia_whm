@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-neutral-900 mb-6">Edit Outbound Shipment</h1>
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
            <form action="{{ route('outbound-shipments.update', $outboundShipment) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="customer_id" class="block text-sm font-medium text-neutral-700">Customer *</label>
                            <select name="customer_id" id="customer_id" required
                                    class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id', $outboundShipment->customer_id) == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="shipping_date" class="block text-sm font-medium text-neutral-700">Shipping Date *</label>
                            <input type="date" name="shipping_date" id="shipping_date" value="{{ old('shipping_date', $outboundShipment->shipping_date->format('Y-m-d')) }}" required
                                   class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="destination_country" class="block text-sm font-medium text-neutral-700">Destination Country *</label>
                            <select name="destination_country" id="destination_country" required
                                    class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="">Select Country</option>
                                @foreach(config('countries.countries') as $code => $name)
                                    <option value="{{ $code }}" {{ old('destination_country', $outboundShipment->destination_country) == $code ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="carrier" class="block text-sm font-medium text-neutral-700">Courier *</label>
                            <select name="carrier" id="carrier" required
                                    class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="">Select Courier</option>
                                @foreach(config('couriers.couriers') as $code => $name)
                                    <option value="{{ $name }}" {{ old('carrier', $outboundShipment->carrier) == $name ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                        <div>
                            <label for="status" class="block text-sm font-medium text-neutral-700">Status *</label>
                            <select name="status" id="status" required
                                    class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="pending" {{ old('status', $outboundShipment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="packed" {{ old('status', $outboundShipment->status) == 'packed' ? 'selected' : '' }}>Packed</option>
                                <option value="shipped" {{ old('status', $outboundShipment->status) == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="in_transit" {{ old('status', $outboundShipment->status) == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                                <option value="delivered" {{ old('status', $outboundShipment->status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="returned" {{ old('status', $outboundShipment->status) == 'returned' ? 'selected' : '' }}>Returned</option>
                            </select>
                        </div>
                        <div>
                            <label for="customs_value" class="block text-sm font-medium text-neutral-700">Customs Value ($)</label>
                            <input type="number" step="0.01" name="customs_value" id="customs_value" value="{{ old('customs_value', $outboundShipment->customs_value) }}" min="0"
                                   class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label for="shipping_cost" class="block text-sm font-medium text-neutral-700">Shipping Cost ($)</label>
                            <input type="number" step="0.01" name="shipping_cost" id="shipping_cost" value="{{ old('shipping_cost', $outboundShipment->shipping_cost) }}" min="0"
                                   class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>
                    <div>
                        <label for="shipping_zone_id" class="block text-sm font-medium text-neutral-700">Shipping Zone</label>
                        <select name="shipping_zone_id" id="shipping_zone_id"
                                class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">Select Shipping Zone</option>
                            @foreach($shippingZones as $zone)
                                <option value="{{ $zone->id }}" 
                                        data-countries="{{ json_encode($zone->countries) }}"
                                        {{ old('shipping_zone_id', $outboundShipment->shipping_zone_id) == $zone->id ? 'selected' : '' }}>
                                    {{ $zone->name }} ({{ $zone->estimated_delivery }} days, ${{ number_format($zone->shipping_rates['base_rate'] ?? 0, 2) }} base)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('outbound-shipments.index') }}" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 bg-white hover:bg-neutral-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">Update Shipment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const destinationCountry = document.getElementById('destination_country');
    const shippingZone = document.getElementById('shipping_zone_id');
    
    destinationCountry.addEventListener('change', function() {
        const selectedCountry = this.value;
        
        if (!selectedCountry) {
            return;
        }
        
        // Find matching shipping zone
        const options = shippingZone.querySelectorAll('option');
        let matchedZone = null;
        
        options.forEach(option => {
            if (option.value && option.dataset.countries) {
                try {
                    const countries = JSON.parse(option.dataset.countries);
                    if (countries.includes(selectedCountry)) {
                        matchedZone = option.value;
                    }
                } catch (e) {
                    console.error('Error parsing countries:', e);
                }
            }
        });
        
        if (matchedZone) {
            shippingZone.value = matchedZone;
        }
    });
});
</script>
@endsection

