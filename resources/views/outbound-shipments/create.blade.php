@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-neutral-900 mb-6">Create Outbound Shipment</h1>
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
            <form action="{{ route('outbound-shipments.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-6 mb-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="customer_id" class="block text-sm font-medium text-neutral-700">Customer *</label>
                            <select name="customer_id" id="customer_id" required
                                class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="shipping_date" class="block text-sm font-medium text-neutral-700">Shipping Date *</label>
                            <input type="date" name="shipping_date" id="shipping_date" value="{{ old('shipping_date', date('Y-m-d')) }}" required
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
                                <option value="{{ $code }}" {{ old('destination_country') == $code ? 'selected' : '' }}>
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
                                <option value="{{ $name }}" {{ old('carrier') == $name ? 'selected' : '' }}>
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
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="packed" {{ old('status') == 'packed' ? 'selected' : '' }}>Packed</option>
                                <option value="shipped" {{ old('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            </select>
                        </div>
                        <div>
                            <label for="customs_value" class="block text-sm font-medium text-neutral-700">Customs Value ($)</label>
                            <input type="number" step="0.01" name="customs_value" id="customs_value" value="{{ old('customs_value', 0) }}" min="0"
                                class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <p class="mt-1 text-xs text-neutral-500">Will auto-calculate from selected packages if left empty</p>
                        </div>
                        <div>
                            <label for="shipping_cost" class="block text-sm font-medium text-neutral-700">Shipping Cost ($)</label>
                            <input type="number" step="0.01" name="shipping_cost" id="shipping_cost" value="{{ old('shipping_cost', 0) }}" min="0"
                                class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <p class="mt-1 text-xs text-neutral-500">Will auto-calculate from shipping zone if left empty</p>
                            <div id="shipping-cost-preview" class="mt-2 text-sm text-primary-600 hidden"></div>
                        </div>
                    </div>
                    <div>
                        <label for="shipping_zone_id" class="block text-sm font-medium text-neutral-700">Shipping Zone</label>
                        <select name="shipping_zone_id" id="shipping_zone_id"
                            class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">Auto-select based on country</option>
                            @foreach($shippingZones as $zone)
                            <option value="{{ $zone->id }}"
                                data-countries="{{ json_encode($zone->countries) }}"
                                data-rates="{{ json_encode($zone->shipping_rates) }}"
                                {{ old('shipping_zone_id') == $zone->id ? 'selected' : '' }}>
                                {{ $zone->name }} ({{ $zone->estimated_delivery }} days, ${{ number_format($zone->shipping_rates['base_rate'] ?? 0, 2) }} base)
                            </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-neutral-500">Zone akan otomatis terpilih berdasarkan negara tujuan</p>
                    </div>
                </div>

                <!-- Available Packages -->
                <div class="border-t border-neutral-200 pt-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-neutral-900">Select Packages *</h2>
                        @if($packages->count() > 0)
                        <div class="flex items-center space-x-3">
                            <button type="button" onclick="selectAllPackages()" class="text-sm text-primary-600 hover:text-primary-700">Select All</button>
                            <button type="button" onclick="deselectAllPackages()" class="text-sm text-neutral-600 hover:text-neutral-700">Deselect All</button>
                        </div>
                        @endif
                    </div>

                    @if($packages->count() > 0)
                    <!-- Search Filter -->
                    <div class="mb-4">
                        <input type="text" id="package-search" placeholder="Search packages by product name, location..."
                            class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>

                    <!-- Packages List -->
                    <div id="packages-container" class="space-y-2 max-h-96 overflow-y-auto border border-neutral-200 rounded-lg p-4">
                        @foreach($packages as $package)
                        <label class="package-item flex items-center p-3 border border-neutral-200 rounded-lg hover:bg-neutral-50 cursor-pointer transition-colors"
                            data-package-id="{{ $package->id }}"
                            data-weight="{{ $package->weight ?? 0 }}"
                            data-value="{{ $package->value ?? 0 }}"
                            data-quantity="{{ $package->quantity }}"
                            data-product-name="{{ strtolower($package->product ? $package->product->name : 'package #' . $package->id) }}"
                            data-location="{{ strtolower($package->location ? $package->location->name : '') }}">
                            <input type="checkbox" name="package_ids[]" value="{{ $package->id }}"
                                class="package-checkbox rounded border-neutral-300 text-primary-600 focus:ring-primary-500"
                                onchange="updatePackageSummary()">
                            <div class="ml-3 flex-1">
                                <div class="text-sm font-medium text-neutral-900">
                                    {{ $package->product ? $package->product->name : 'Package #' . $package->id }}
                                </div>
                                <div class="text-xs text-neutral-500">
                                    Qty: <span class="font-medium">{{ $package->quantity }}</span> |
                                    Weight: <span class="font-medium">{{ $package->weight ? $package->weight . ' kg' : 'N/A' }}</span> |
                                    Value: <span class="font-medium">${{ number_format($package->value, 2) }}</span> |
                                    Location: <span class="font-medium">{{ $package->location ? $package->location->name : 'N/A' }}</span>
                                    @if($package->inboundShipment)
                                    | Inbound: <span class="font-medium text-primary-600">{{ $package->inboundShipment->tracking_number }}</span>
                                    @endif
                                </div>
                                <div class="mt-1">
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full 
                                                {{ $package->status === 'stored' ? 'bg-secondary-100 text-secondary-800' : 'bg-accent-100 text-accent-800' }}">
                                        {{ ucfirst($package->status) }}
                                    </span>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    <!-- Summary -->
                    <div id="package-summary" class="mt-4 p-4 bg-primary-50 border border-primary-200 rounded-lg hidden">
                        <h3 class="text-sm font-semibold text-primary-900 mb-2">Selected Packages Summary</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                            <div>
                                <span class="text-primary-600 font-medium">Total Packages:</span>
                                <span id="total-packages" class="ml-2 text-primary-900 font-semibold">0</span>
                            </div>
                            <div>
                                <span class="text-primary-600 font-medium">Total Quantity:</span>
                                <span id="total-quantity" class="ml-2 text-primary-900 font-semibold">0</span>
                            </div>
                            <div>
                                <span class="text-primary-600 font-medium">Total Weight:</span>
                                <span id="total-weight" class="ml-2 text-primary-900 font-semibold">0 kg</span>
                            </div>
                            <div>
                                <span class="text-primary-600 font-medium">Total Value:</span>
                                <span id="total-value" class="ml-2 text-primary-900 font-semibold">$0.00</span>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="p-4 bg-accent-50 border border-accent-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-accent-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-accent-900 mb-1">No available packages found</p>
                                <p class="text-sm text-accent-700 mb-3">Packages must be received through inbound shipment first. Packages with status "received" or "stored" and not yet assigned to outbound shipment will appear here.</p>
                                <div class="flex space-x-3">
                                    <a href="{{ route('inbound-shipments.create') }}" class="inline-flex items-center px-4 py-2 bg-accent-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-accent-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Create Inbound Shipment
                                    </a>
                                    <a href="{{ route('inbound-shipments.index') }}" class="inline-flex items-center px-4 py-2 border border-accent-300 rounded-lg text-accent-700 bg-white hover:bg-accent-50 text-sm">
                                        View Inbound Shipments
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('outbound-shipments.index') }}" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 bg-white hover:bg-neutral-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">Create Shipment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-select shipping zone based on country
        const destinationCountry = document.getElementById('destination_country');
        const shippingZone = document.getElementById('shipping_zone_id');

        destinationCountry.addEventListener('change', function() {
            const selectedCountry = this.value;

            if (!selectedCountry) {
                shippingZone.value = '';
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
                calculateShippingCost(); // Recalculate when zone auto-selected
            } else {
                shippingZone.value = '';
                document.getElementById('shipping-cost-preview').classList.add('hidden');
            }
        });

        // Package search filter
        const packageSearch = document.getElementById('package-search');
        if (packageSearch) {
            packageSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const packageItems = document.querySelectorAll('.package-item');

                packageItems.forEach(item => {
                    const productName = item.dataset.productName || '';
                    const location = item.dataset.location || '';

                    if (productName.includes(searchTerm) || location.includes(searchTerm) || searchTerm === '') {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

        // Form validation
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const checkedPackages = document.querySelectorAll('.package-checkbox:checked');
                if (checkedPackages.length === 0) {
                    e.preventDefault();
                    alert('Please select at least one package.');
                    return false;
                }
            });
        }

        // Initial summary update
        updatePackageSummary();

        // Auto-calculate shipping cost when packages or shipping zone changes
        function calculateShippingCost() {
            const shippingZone = document.getElementById('shipping_zone_id');
            const shippingCostInput = document.getElementById('shipping_cost');
            const preview = document.getElementById('shipping-cost-preview');
            const checkedPackages = document.querySelectorAll('.package-checkbox:checked');

            if (!shippingZone.value || checkedPackages.length === 0) {
                preview.classList.add('hidden');
                return;
            }

            // Get shipping zone rates from option data
            const selectedOption = shippingZone.options[shippingZone.selectedIndex];
            if (!selectedOption.dataset.rates) {
                preview.classList.add('hidden');
                return;
            }

            try {
                const rates = JSON.parse(selectedOption.dataset.rates);
                const baseRate = parseFloat(rates.base_rate) || 0;
                const perKgRate = parseFloat(rates.per_kg_rate) || 0;

                // Calculate total weight
                let totalWeight = 0;
                checkedPackages.forEach(checkbox => {
                    const packageItem = checkbox.closest('.package-item');
                    if (packageItem) {
                        totalWeight += parseFloat(packageItem.dataset.weight) || 0;
                    }
                });

                if (totalWeight > 0) {
                    const calculatedCost = baseRate + (totalWeight * perKgRate);
                    preview.textContent = `Estimated: $${calculatedCost.toFixed(2)} (Base: $${baseRate.toFixed(2)} + ${totalWeight.toFixed(2)}kg × $${perKgRate.toFixed(2)})`;
                    preview.classList.remove('hidden');

                    // Auto-fill if shipping cost is 0
                    if (parseFloat(shippingCostInput.value) === 0) {
                        shippingCostInput.value = calculatedCost.toFixed(2);
                    }
                } else {
                    preview.classList.add('hidden');
                }
            } catch (e) {
                console.error('Error calculating shipping cost:', e);
                preview.classList.add('hidden');
            }
        }

        // Listen to package selection changes
        document.querySelectorAll('.package-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updatePackageSummary();
                calculateShippingCost();
            });
        });

        // Listen to shipping zone changes
        shippingZone.addEventListener('change', calculateShippingCost);

        // Initial calculation
        calculateShippingCost();
    });

    function selectAllPackages() {
        const checkboxes = document.querySelectorAll('.package-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        updatePackageSummary();
    }

    function deselectAllPackages() {
        const checkboxes = document.querySelectorAll('.package-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updatePackageSummary();
    }

    function updatePackageSummary() {
        const checkedPackages = document.querySelectorAll('.package-checkbox:checked');
        const summaryDiv = document.getElementById('package-summary');

        if (checkedPackages.length === 0) {
            summaryDiv.classList.add('hidden');
            return;
        }

        summaryDiv.classList.remove('hidden');

        let totalPackages = 0;
        let totalQuantity = 0;
        let totalWeight = 0;
        let totalValue = 0;

        checkedPackages.forEach(checkbox => {
            const packageItem = checkbox.closest('.package-item');
            if (packageItem) {
                totalPackages++;
                totalQuantity += parseFloat(packageItem.dataset.quantity) || 0;
                totalWeight += parseFloat(packageItem.dataset.weight) || 0;
                totalValue += parseFloat(packageItem.dataset.value) || 0;
            }
        });

        document.getElementById('total-packages').textContent = totalPackages;
        document.getElementById('total-quantity').textContent = totalQuantity;
        document.getElementById('total-weight').textContent = totalWeight.toFixed(2) + ' kg';
        document.getElementById('total-value').textContent = '$' + totalValue.toFixed(2);
    }
</script>
@endsection