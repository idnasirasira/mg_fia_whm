@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-neutral-900 mb-6">Reports & Analytics</h1>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Inventory Stats -->
            <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-primary-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-500">Total Products</p>
                        <p class="text-2xl font-semibold text-neutral-900">{{ $inventoryStats['total_products'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-accent-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-500">Low Stock</p>
                        <p class="text-2xl font-semibold text-neutral-900">{{ $inventoryStats['low_stock'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-500">Out of Stock</p>
                        <p class="text-2xl font-semibold text-neutral-900">{{ $inventoryStats['out_of_stock'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-secondary-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-500">Stock Value</p>
                        <p class="text-2xl font-semibold text-neutral-900">${{ number_format($inventoryStats['total_stock_value'], 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inbound & Outbound Stats -->
        <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
            <!-- Inbound Stats -->
            <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
                <h2 class="text-lg font-semibold text-neutral-900 mb-4">Inbound Shipments</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-neutral-500">Today</p>
                        <p class="text-2xl font-semibold text-neutral-900">{{ $inboundStats['today'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-500">This Month</p>
                        <p class="text-2xl font-semibold text-neutral-900">{{ $inboundStats['this_month'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-500">Pending</p>
                        <p class="text-2xl font-semibold text-accent-600">{{ $inboundStats['pending'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-500">Stored</p>
                        <p class="text-2xl font-semibold text-secondary-600">{{ $inboundStats['stored'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Outbound Stats -->
            <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
                <h2 class="text-lg font-semibold text-neutral-900 mb-4">Outbound Shipments</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-neutral-500">Today</p>
                        <p class="text-2xl font-semibold text-neutral-900">{{ $outboundStats['today'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-500">This Month</p>
                        <p class="text-2xl font-semibold text-neutral-900">{{ $outboundStats['this_month'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-500">Pending</p>
                        <p class="text-2xl font-semibold text-accent-600">{{ $outboundStats['pending'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-500">Delivered</p>
                        <p class="text-2xl font-semibold text-secondary-600">{{ $outboundStats['delivered'] }}</p>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-neutral-200">
                    <p class="text-sm text-neutral-500">Total Revenue</p>
                    <p class="text-2xl font-semibold text-primary-600">${{ number_format($outboundStats['total_revenue'], 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Package Stats & Top Customers -->
        <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
            <!-- Package Stats -->
            <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
                <h2 class="text-lg font-semibold text-neutral-900 mb-4">Package Status</h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-neutral-500">Total Packages</span>
                        <span class="text-lg font-semibold text-neutral-900">{{ $packageStats['total'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-neutral-500">Stored</span>
                        <span class="text-lg font-semibold text-secondary-600">{{ $packageStats['stored'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-neutral-500">Shipped</span>
                        <span class="text-lg font-semibold text-accent-600">{{ $packageStats['shipped'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-neutral-500">Delivered</span>
                        <span class="text-lg font-semibold text-primary-600">{{ $packageStats['delivered'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Top Customers -->
            <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
                <h2 class="text-lg font-semibold text-neutral-900 mb-4">Top Customers</h2>
                <div class="space-y-3">
                    @forelse($topCustomers as $customer)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-neutral-900">{{ $customer->name }}</span>
                            <span class="text-sm font-semibold text-primary-600">{{ $customer->outbound_shipments_count }} shipments</span>
                        </div>
                    @empty
                        <p class="text-sm text-neutral-500">No data available</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Links & Export -->
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-neutral-900">Detailed Reports</h2>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 mb-6">
                <a href="{{ route('reports.inventory') }}" class="p-4 border border-neutral-200 rounded-lg hover:bg-neutral-50 transition-colors">
                    <div class="font-medium text-neutral-900">Inventory Report</div>
                    <div class="text-sm text-neutral-500 mt-1">View stock levels and product details</div>
                </a>
                <a href="{{ route('reports.shipping') }}" class="p-4 border border-neutral-200 rounded-lg hover:bg-neutral-50 transition-colors">
                    <div class="font-medium text-neutral-900">Shipping Report</div>
                    <div class="text-sm text-neutral-500 mt-1">View inbound and outbound shipments</div>
                </a>
            </div>
            
            <!-- Export Section -->
            <div class="border-t border-neutral-200 pt-6">
                <h3 class="text-md font-semibold text-neutral-900 mb-4">Export Data to Excel</h3>
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    <a href="{{ route('reports.export.products') }}" class="flex items-center space-x-2 px-4 py-2 border border-primary-200 rounded-lg hover:bg-primary-50 transition-colors text-primary-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-sm font-medium">Export Products</span>
                    </a>
                    <a href="{{ route('reports.export.customers') }}" class="flex items-center space-x-2 px-4 py-2 border border-primary-200 rounded-lg hover:bg-primary-50 transition-colors text-primary-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-sm font-medium">Export Customers</span>
                    </a>
                    <a href="{{ route('reports.export.inbound-shipments') }}" class="flex items-center space-x-2 px-4 py-2 border border-primary-200 rounded-lg hover:bg-primary-50 transition-colors text-primary-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-sm font-medium">Export Inbound</span>
                    </a>
                    <a href="{{ route('reports.export.outbound-shipments') }}" class="flex items-center space-x-2 px-4 py-2 border border-primary-200 rounded-lg hover:bg-primary-50 transition-colors text-primary-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-sm font-medium">Export Outbound</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

