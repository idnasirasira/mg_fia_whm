@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-neutral-900">Inventory Report</h1>
            <a href="{{ route('reports.index') }}" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 bg-white hover:bg-neutral-50">Back to Reports</a>
        </div>

        <!-- Low Stock Alert -->
        @if($lowStock->count() > 0)
        <div class="mb-6 bg-accent-50 border border-accent-200 rounded-lg p-4">
            <h2 class="text-lg font-semibold text-accent-900 mb-3">Low Stock Alert ({{ $lowStock->count() }})</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-accent-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-accent-700 uppercase">SKU</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-accent-700 uppercase">Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-accent-700 uppercase">Stock</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-accent-700 uppercase">Category</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-accent-200">
                        @foreach($lowStock as $product)
                            <tr>
                                <td class="px-4 py-2 text-sm text-accent-900">{{ $product->sku }}</td>
                                <td class="px-4 py-2 text-sm text-accent-900">{{ $product->name }}</td>
                                <td class="px-4 py-2 text-sm font-semibold text-accent-600">{{ $product->stock_quantity }}</td>
                                <td class="px-4 py-2 text-sm text-accent-700">{{ $product->category ? $product->category->name : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Out of Stock -->
        @if($outOfStock->count() > 0)
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <h2 class="text-lg font-semibold text-red-900 mb-3">Out of Stock ({{ $outOfStock->count() }})</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-red-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-red-700 uppercase">SKU</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-red-700 uppercase">Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-red-700 uppercase">Category</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-red-200">
                        @foreach($outOfStock as $product)
                            <tr>
                                <td class="px-4 py-2 text-sm text-red-900">{{ $product->sku }}</td>
                                <td class="px-4 py-2 text-sm text-red-900">{{ $product->name }}</td>
                                <td class="px-4 py-2 text-sm text-red-700">{{ $product->category ? $product->category->name : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- All Products -->
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-200">
                <h2 class="text-lg font-semibold text-neutral-900">All Products ({{ $products->count() }})</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead class="bg-neutral-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">SKU</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Value</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Location</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-neutral-200">
                        @foreach($products as $product)
                            <tr class="hover:bg-neutral-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900">{{ $product->sku }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">{{ $product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ $product->category ? $product->category->name : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $product->stock_quantity > 10 ? 'bg-secondary-100 text-secondary-800' : 
                                           ($product->stock_quantity > 0 ? 'bg-accent-100 text-accent-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">${{ number_format($product->value, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ $product->location ? $product->location->name : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

