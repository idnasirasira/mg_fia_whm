@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-neutral-900 mb-6">Edit Product</h1>

        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- SKU -->
                    <div class="sm:col-span-2">
                        <label for="sku" class="block text-sm font-medium text-neutral-700">SKU *</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" required
                               class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('sku') border-status-error @enderror">
                        @error('sku')
                            <p class="mt-1 text-sm text-status-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium text-neutral-700">Product Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                               class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-status-error @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-status-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="sm:col-span-2">
                        <label for="description" class="block text-sm font-medium text-neutral-700">Description</label>
                        <textarea name="description" id="description" rows="3"
                                  class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('description') border-status-error @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-status-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-neutral-700">Category</label>
                        <select name="category_id" id="category_id"
                                class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location_id" class="block text-sm font-medium text-neutral-700">Warehouse Location</label>
                        <select name="location_id" id="location_id"
                                class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">Select Location</option>
                            @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ old('location_id', $product->location_id) == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Weight -->
                    <div>
                        <label for="weight" class="block text-sm font-medium text-neutral-700">Weight (kg)</label>
                        <input type="number" step="0.01" name="weight" id="weight" value="{{ old('weight', $product->weight) }}"
                               class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('weight') border-status-error @enderror">
                        @error('weight')
                            <p class="mt-1 text-sm text-status-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dimensions -->
                    <div>
                        <label for="dimensions" class="block text-sm font-medium text-neutral-700">Dimensions (LxWxH cm)</label>
                        <input type="text" name="dimensions" id="dimensions" value="{{ old('dimensions', $product->dimensions) }}" placeholder="e.g., 10x20x30"
                               class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('dimensions') border-status-error @enderror">
                        @error('dimensions')
                            <p class="mt-1 text-sm text-status-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Value -->
                    <div>
                        <label for="value" class="block text-sm font-medium text-neutral-700">Value ($)</label>
                        <input type="number" step="0.01" name="value" id="value" value="{{ old('value', $product->value) }}"
                               class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('value') border-status-error @enderror">
                        @error('value')
                            <p class="mt-1 text-sm text-status-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock Quantity -->
                    <div>
                        <label for="stock_quantity" class="block text-sm font-medium text-neutral-700">Stock Quantity *</label>
                        <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required min="0"
                               class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('stock_quantity') border-status-error @enderror">
                        @error('stock_quantity')
                            <p class="mt-1 text-sm text-status-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('products.index') }}" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 bg-white hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

