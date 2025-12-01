@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-neutral-900">Category Details</h1>
            <div class="flex space-x-3">
                <x-button-edit href="{{ route('categories.edit', $category) }}" />
                <x-button-back href="{{ route('categories.index') }}" />
            </div>
        </div>

        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6 mb-6">
            <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Name</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $category->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Parent Category</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $category->parent ? $category->parent->name : 'Root Category' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-neutral-500">Description</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $category->description ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Total Products</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $category->products->count() }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Child Categories</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $category->children->count() }}</dd>
                </div>
            </dl>
        </div>

        @if($category->children->count() > 0)
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-neutral-200">
                <h2 class="text-lg font-semibold text-neutral-900">Child Categories ({{ $category->children->count() }})</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($category->children as $child)
                    <a href="{{ route('categories.show', $child) }}" class="p-4 border border-neutral-200 rounded-lg hover:bg-neutral-50 transition-colors">
                        <div class="font-medium text-neutral-900">{{ $child->name }}</div>
                        <div class="text-sm text-neutral-500 mt-1">{{ $child->products->count() }} products</div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if($category->products->count() > 0)
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-200">
                <h2 class="text-lg font-semibold text-neutral-900">Products ({{ $category->products->count() }})</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead class="bg-neutral-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">SKU</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-neutral-200">
                        @foreach($category->products as $product)
                        <tr class="hover:bg-neutral-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900">{{ $product->sku }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->stock_quantity > 0 ? 'bg-secondary-100 text-secondary-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->stock_quantity }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('products.show', $product) }}" class="text-primary-600 hover:text-primary-900">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection