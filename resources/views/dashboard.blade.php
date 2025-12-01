@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-neutral-900 mb-2">Dashboard</h1>
            <p class="text-neutral-600">Welcome back, {{ auth()->user()->name }}. Here's what's happening today.</p>
        </div>

        <!-- Key Metrics Cards -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <!-- Total Products -->
            <div class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-primary-100 text-sm font-medium uppercase tracking-wider mb-1">Total Products</p>
                            <p class="text-white text-3xl font-bold">{{ number_format($stats['total_products']) }}</p>
                            <p class="text-primary-100 text-xs mt-2">Active inventory items</p>
                        </div>
                        <div class="bg-white/20 rounded-lg p-4 backdrop-blur-sm">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Packages -->
            <div class="bg-gradient-to-br from-secondary-500 to-secondary-600 rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-secondary-100 text-sm font-medium uppercase tracking-wider mb-1">Total Packages</p>
                            <p class="text-white text-3xl font-bold">{{ number_format($stats['total_packages']) }}</p>
                            <p class="text-secondary-100 text-xs mt-2">All packages in system</p>
                        </div>
                        <div class="bg-white/20 rounded-lg p-4 backdrop-blur-sm">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Inbound -->
            <div class="bg-gradient-to-br from-accent-500 to-accent-600 rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-accent-100 text-sm font-medium uppercase tracking-wider mb-1">Pending Inbound</p>
                            <p class="text-white text-3xl font-bold">{{ $statusStats['pending_inbound'] }}</p>
                            <p class="text-accent-100 text-xs mt-2">Awaiting processing</p>
                        </div>
                        <div class="bg-white/20 rounded-lg p-4 backdrop-blur-sm">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Outbound -->
            <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-amber-100 text-sm font-medium uppercase tracking-wider mb-1">Pending Outbound</p>
                            <p class="text-white text-3xl font-bold">{{ $statusStats['pending_outbound'] }}</p>
                            <p class="text-amber-100 text-xs mt-2">Ready to ship</p>
                        </div>
                        <div class="bg-white/20 rounded-lg p-4 backdrop-blur-sm">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Stats Row -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-8">
            <!-- Shipment Status Overview -->
            <div class="bg-white rounded-xl shadow-md border border-neutral-200 p-6">
                <h3 class="text-lg font-semibold text-neutral-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Shipment Status
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-neutral-600">Inbound - Stored</span>
                        <span class="text-sm font-semibold text-neutral-900">{{ $statusStats['stored_inbound'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-neutral-600">Outbound - Shipped</span>
                        <span class="text-sm font-semibold text-neutral-900">{{ $statusStats['shipped_outbound'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-neutral-600">Outbound - Delivered</span>
                        <span class="text-sm font-semibold text-secondary-600">{{ $statusStats['delivered_outbound'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Package Status Overview -->
            <div class="bg-white rounded-xl shadow-md border border-neutral-200 p-6">
                <h3 class="text-lg font-semibold text-neutral-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Package Status
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-neutral-600">Stored</span>
                        <span class="text-sm font-semibold text-neutral-900">{{ $packageStats['stored'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-neutral-600">Packed</span>
                        <span class="text-sm font-semibold text-accent-600">{{ $packageStats['packed'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-neutral-600">Shipped</span>
                        <span class="text-sm font-semibold text-primary-600">{{ $packageStats['shipped'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-neutral-600">Delivered</span>
                        <span class="text-sm font-semibold text-secondary-600">{{ $packageStats['delivered'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Revenue Overview -->
            <div class="bg-white rounded-xl shadow-md border border-neutral-200 p-6">
                <h3 class="text-lg font-semibold text-neutral-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Financial Overview
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-neutral-600">Total Customs Value</span>
                        <span class="text-sm font-semibold text-neutral-900">${{ number_format($revenueStats['total_customs_value'], 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-neutral-600">Total Shipping Revenue</span>
                        <span class="text-sm font-semibold text-primary-600">${{ number_format($revenueStats['total_shipping_cost'], 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-neutral-200">
                        <span class="text-sm font-medium text-neutral-700">Inventory Value</span>
                        <span class="text-sm font-bold text-secondary-600">${{ number_format($revenueStats['total_inventory_value'], 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Recent Inbound Shipments -->
            <div class="bg-white rounded-xl shadow-md border border-neutral-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-neutral-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Recent Inbound Shipments
                    </h3>
                    <a href="{{ route('inbound-shipments.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">View All</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentInbound as $shipment)
                        <div class="flex items-center justify-between p-3 bg-neutral-50 rounded-lg hover:bg-neutral-100 transition-colors">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-neutral-900">{{ $shipment->tracking_number }}</p>
                                <p class="text-xs text-neutral-500">{{ $shipment->customer->name }} • {{ $shipment->received_date->format('M d, Y') }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $shipment->status === 'stored' ? 'bg-secondary-100 text-secondary-800' : 
                                   ($shipment->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-primary-100 text-primary-800') }}">
                                {{ ucfirst($shipment->status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-neutral-500 text-center py-4">No recent inbound shipments</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Outbound Shipments -->
            <div class="bg-white rounded-xl shadow-md border border-neutral-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-neutral-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Recent Outbound Shipments
                    </h3>
                    <a href="{{ route('outbound-shipments.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">View All</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentOutbound as $shipment)
                        <div class="flex items-center justify-between p-3 bg-neutral-50 rounded-lg hover:bg-neutral-100 transition-colors">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-neutral-900">{{ $shipment->tracking_number }}</p>
                                <p class="text-xs text-neutral-500">{{ $shipment->customer->name }} • {{ $shipment->shipping_date->format('M d, Y') }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $shipment->status === 'delivered' ? 'bg-secondary-100 text-secondary-800' : 
                                   ($shipment->status === 'returned' ? 'bg-red-100 text-red-800' : 
                                    ($shipment->status === 'shipped' || $shipment->status === 'in_transit' ? 'bg-primary-100 text-primary-800' : 'bg-accent-100 text-accent-800')) }}">
                                {{ ucfirst(str_replace('_', ' ', $shipment->status)) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-neutral-500 text-center py-4">No recent outbound shipments</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        @if(auth()->user()->isAdmin() || auth()->user()->isManager())
        <div class="bg-white rounded-xl shadow-md border border-neutral-200 p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-neutral-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Recent Activities
                </h3>
                <a href="{{ route('activity-logs.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">View All</a>
            </div>
            <div class="space-y-3">
                @forelse($recentActivities as $activity)
                    <div class="flex items-start p-3 bg-neutral-50 rounded-lg hover:bg-neutral-100 transition-colors">
                        <div class="flex-shrink-0 mt-0.5">
                            @if($activity->action === 'created')
                                <div class="w-8 h-8 rounded-full bg-secondary-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                            @elseif($activity->action === 'updated')
                                <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                            @else
                                <div class="w-8 h-8 rounded-full bg-neutral-200 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <p class="text-sm text-neutral-900">
                                <span class="font-medium">{{ $activity->user->name }}</span>
                                <span class="text-neutral-600">{{ $activity->action }}</span>
                                <span class="font-medium">{{ class_basename($activity->model_type) }}</span>
                            </p>
                            @if($activity->description)
                                <p class="text-xs text-neutral-500 mt-1">{{ $activity->description }}</p>
                            @endif
                            <p class="text-xs text-neutral-400 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-neutral-500 text-center py-4">No recent activities</p>
                @endforelse
            </div>
        </div>
        @endif

        <!-- Bottom Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Low Stock Alert -->
            @if($lowStockProducts->count() > 0)
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl shadow-md border border-red-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-red-900 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Low Stock Alert
                    </h3>
                    <a href="{{ route('products.index') }}" class="text-sm text-red-700 hover:text-red-800 font-medium">View All</a>
                </div>
                <div class="space-y-2">
                    @foreach($lowStockProducts as $product)
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-red-200">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-neutral-900">{{ $product->name }}</p>
                                <p class="text-xs text-neutral-500">{{ $product->sku ?? 'N/A' }}</p>
                            </div>
                            <span class="px-3 py-1 text-sm font-bold text-red-700 bg-red-100 rounded-full">
                                {{ $product->stock_quantity }} left
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md border border-neutral-200 p-6">
                <h3 class="text-lg font-semibold text-neutral-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Quick Actions
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('inbound-shipments.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-primary-200 rounded-lg hover:bg-primary-50 hover:border-primary-300 transition-all group">
                        <div class="bg-primary-100 rounded-lg p-3 mb-2 group-hover:bg-primary-200 transition-colors">
                            <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-neutral-900">New Inbound</p>
                    </a>
                    <a href="{{ route('outbound-shipments.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-secondary-200 rounded-lg hover:bg-secondary-50 hover:border-secondary-300 transition-all group">
                        <div class="bg-secondary-100 rounded-lg p-3 mb-2 group-hover:bg-secondary-200 transition-colors">
                            <svg class="h-6 w-6 text-secondary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-neutral-900">New Outbound</p>
                    </a>
                    <a href="{{ route('products.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-accent-200 rounded-lg hover:bg-accent-50 hover:border-accent-300 transition-all group">
                        <div class="bg-accent-100 rounded-lg p-3 mb-2 group-hover:bg-accent-200 transition-colors">
                            <svg class="h-6 w-6 text-accent-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-neutral-900">Add Product</p>
                    </a>
                    <a href="{{ route('reports.index') }}" class="flex flex-col items-center justify-center p-4 border-2 border-neutral-200 rounded-lg hover:bg-neutral-50 hover:border-neutral-300 transition-all group">
                        <div class="bg-neutral-100 rounded-lg p-3 mb-2 group-hover:bg-neutral-200 transition-colors">
                            <svg class="h-6 w-6 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-neutral-900">Reports</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
