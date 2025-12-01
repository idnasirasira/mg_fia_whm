@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-neutral-900 mb-6">Receive Inbound Shipment</h1>
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
            <form action="{{ route('inbound-shipments.store') }}" method="POST" id="inboundForm">
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
                            <label for="received_date" class="block text-sm font-medium text-neutral-700">Received Date *</label>
                            <input type="date" name="received_date" id="received_date" value="{{ old('received_date', date('Y-m-d')) }}" required
                                class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="status" class="block text-sm font-medium text-neutral-700">Status *</label>
                            <select name="status" id="status" required
                                class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="received" {{ old('status') == 'received' ? 'selected' : '' }}>Received</option>
                                <option value="inspected" {{ old('status') == 'inspected' ? 'selected' : '' }}>Inspected</option>
                                <option value="stored" {{ old('status') == 'stored' ? 'selected' : '' }}>Stored</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-medium text-neutral-700">Notes</label>
                        <textarea name="notes" id="notes" rows="3"
                            class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <!-- Packages Section -->
                <div class="border-t border-neutral-200 pt-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-neutral-900">Packages</h2>
                        <button type="button" onclick="addPackage()" class="px-3 py-1 bg-secondary-600 text-white text-sm rounded-lg hover:bg-secondary-700">
                            + Add Package
                        </button>
                    </div>

                    <div id="packages-container">
                        <!-- Package fields will be added here dynamically -->
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('inbound-shipments.index') }}" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 bg-white hover:bg-neutral-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">Create Shipment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let packageCount = 0;

    function addPackage() {
        packageCount++;
        const container = document.getElementById('packages-container');
        const packageDiv = document.createElement('div');
        packageDiv.className = 'border border-neutral-200 rounded-lg p-4 mb-4';
        packageDiv.id = `package-${packageCount}`;

        packageDiv.innerHTML = `
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-sm font-medium text-neutral-700">Package ${packageCount}</h3>
            <button type="button" onclick="removePackage(${packageCount})" class="text-red-600 hover:text-red-900 text-sm">Remove</button>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-neutral-700">Product (Optional)</label>
                <select name="packages[${packageCount}][product_id]" id="product-select-${packageCount}"
                        class="mt-1 block w-full px-3 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                        onchange="fillProductData(${packageCount}, this.value)">
                    <option value="">-- Select Product (Optional) --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" 
                                data-weight="{{ $product->weight ?? '' }}"
                                data-dimensions="{{ $product->dimensions ?? '' }}"
                                data-value="{{ $product->value ?? 0 }}">
                            {{ $product->name }} @if($product->sku)({{ $product->sku }})@endif
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-neutral-500">Select product to auto-fill weight, dimensions, and value</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700">Quantity *</label>
                <input type="number" name="packages[${packageCount}][quantity]" id="quantity-${packageCount}" required min="1" value="1"
                       class="mt-1 block w-full px-3 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700">Weight (kg)</label>
                <input type="number" step="0.01" name="packages[${packageCount}][weight]" id="weight-${packageCount}" min="0"
                       class="mt-1 block w-full px-3 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700">Dimensions</label>
                <input type="text" name="packages[${packageCount}][dimensions]" id="dimensions-${packageCount}" placeholder="LxWxH"
                       class="mt-1 block w-full px-3 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700">Value ($)</label>
                <input type="number" step="0.01" name="packages[${packageCount}][value]" id="value-${packageCount}" min="0" value="0"
                       class="mt-1 block w-full px-3 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700">Location</label>
                <select name="packages[${packageCount}][location_id]"
                        class="mt-1 block w-full px-3 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="">Select Location</option>
                    @foreach($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700">HS Code</label>
                <input type="text" name="packages[${packageCount}][hs_code]" placeholder="e.g., 8471.30"
                       class="mt-1 block w-full px-3 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-neutral-700">Customs Description</label>
                <textarea name="packages[${packageCount}][customs_description]" rows="2" placeholder="Product description for customs"
                          class="mt-1 block w-full px-3 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"></textarea>
            </div>
        </div>
    `;

        container.appendChild(packageDiv);
    }

    function removePackage(id) {
        const packageDiv = document.getElementById(`package-${id}`);
        if (packageDiv) {
            packageDiv.remove();
        }
    }

    // Auto-fill product data when product is selected
    function fillProductData(packageIndex, productId) {
        if (!productId) {
            return;
        }

        const select = document.getElementById(`product-select-${packageIndex}`);
        const selectedOption = select.options[select.selectedIndex];

        if (selectedOption) {
            const weight = selectedOption.getAttribute('data-weight');
            const dimensions = selectedOption.getAttribute('data-dimensions');
            const value = selectedOption.getAttribute('data-value');

            // Auto-fill fields if they are empty
            const weightInput = document.getElementById(`weight-${packageIndex}`);
            const dimensionsInput = document.getElementById(`dimensions-${packageIndex}`);
            const valueInput = document.getElementById(`value-${packageIndex}`);

            if (weight && !weightInput.value) {
                weightInput.value = weight;
            }
            if (dimensions && !dimensionsInput.value) {
                dimensionsInput.value = dimensions;
            }
            if (value && !valueInput.value) {
                valueInput.value = value;
            }

            // Visual feedback
            [weightInput, dimensionsInput, valueInput].forEach(input => {
                if (input.value) {
                    input.style.backgroundColor = '#d1fae5';
                    setTimeout(() => {
                        input.style.backgroundColor = '';
                    }, 1000);
                }
            });
        }
    }

    // Add first package on page load
    document.addEventListener('DOMContentLoaded', function() {
        addPackage();
    });
</script>
@endsection