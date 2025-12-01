@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-neutral-900">Product Details</h1>
            <div class="flex space-x-3">
                <x-button-edit href="{{ route('products.edit', $product) }}" />
                <x-button-back href="{{ route('products.index') }}" label="Back to List" />
            </div>
        </div>

        <div class="bg-white shadow-md rounded-xl border border-neutral-200 overflow-hidden">
            <div class="p-6">
                <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-neutral-500">SKU</dt>
                        <dd class="mt-1 text-sm text-neutral-900">{{ $product->sku }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-500">Name</dt>
                        <dd class="mt-1 text-sm text-neutral-900">{{ $product->name }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-neutral-500">Description</dt>
                        <dd class="mt-1 text-sm text-neutral-900">{{ $product->description ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-500">Category</dt>
                        <dd class="mt-1 text-sm text-neutral-900">{{ $product->category ? $product->category->name : '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-500">Location</dt>
                        <dd class="mt-1 text-sm text-neutral-900">{{ $product->location ? $product->location->name : '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-500">Weight</dt>
                        <dd class="mt-1 text-sm text-neutral-900">{{ $product->weight ? $product->weight . ' kg' : '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-500">Dimensions</dt>
                        <dd class="mt-1 text-sm text-neutral-900">{{ $product->dimensions ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-500">Value</dt>
                        <dd class="mt-1 text-sm text-neutral-900">${{ number_format($product->value, 2) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-500">Stock Quantity</dt>
                        <dd class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->stock_quantity > 0 ? 'bg-secondary-100 text-secondary-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection