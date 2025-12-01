<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Warehouse Management System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-neutral-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white border-b border-neutral-200 shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo & Main Menu -->
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 text-xl font-bold text-primary-600 hover:text-primary-700 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <span>Fia Express WMS</span>
                        </a>
                        @auth
                        <!-- Desktop Navigation -->
                        <div class="hidden lg:flex items-center ml-8 space-x-1">
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span>Dashboard</span>
                            </a>

                            <!-- Inventory Dropdown -->
                            <div class="relative group">
                                <button class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('categories.*', 'products.*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    <span>Inventory</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div class="absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-neutral-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <div class="py-2">
                                        <a href="{{ route('categories.index') }}" class="flex items-center space-x-3 px-4 py-2 text-sm text-neutral-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            <span>Categories</span>
                                        </a>
                                        <a href="{{ route('products.index') }}" class="flex items-center space-x-3 px-4 py-2 text-sm text-neutral-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                            <span>Products</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Dropdown -->
                            <div class="relative group">
                                <button class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('inbound-shipments.*', 'outbound-shipments.*', 'packages.*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                    <span>Shipping</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div class="absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-neutral-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <div class="py-2">
                                        <a href="{{ route('inbound-shipments.index') }}" class="flex items-center space-x-3 px-4 py-2 text-sm text-neutral-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Inbound Shipments</span>
                                        </a>
                                        <a href="{{ route('outbound-shipments.index') }}" class="flex items-center space-x-3 px-4 py-2 text-sm text-neutral-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Outbound Shipments</span>
                                        </a>
                                        <a href="{{ route('packages.index') }}" class="flex items-center space-x-3 px-4 py-2 text-sm text-neutral-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                            <span>Packages</span>
                                        </a>
                                        <a href="{{ route('packages.track') }}" class="flex items-center space-x-3 px-4 py-2 text-sm text-neutral-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                            <span>Track Package</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="relative group">
                                <button class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('customers.*', 'warehouses.*', 'shipping-zones.*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>Settings</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div class="absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-neutral-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <div class="py-2">
                                        <a href="{{ route('customers.index') }}" class="flex items-center space-x-3 px-4 py-2 text-sm text-neutral-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span>Customers</span>
                                        </a>
                                        <a href="{{ route('warehouses.index') }}" class="flex items-center space-x-3 px-4 py-2 text-sm text-neutral-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <span>Warehouses</span>
                                        </a>
                                        <a href="{{ route('shipping-zones.index') }}" class="flex items-center space-x-3 px-4 py-2 text-sm text-neutral-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Shipping Zones</span>
                                        </a>
                                        @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                                        <div class="border-t border-neutral-200 my-1"></div>
                                        <a href="{{ route('users.index') }}" class="flex items-center space-x-3 px-4 py-2 text-sm text-neutral-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            <span>Users</span>
                                        </a>
                                        <a href="{{ route('activity-logs.index') }}" class="flex items-center space-x-3 px-4 py-2 text-sm text-neutral-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span>Activity Logs</span>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('reports.index') }}" class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('reports.*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <span>Reports</span>
                            </a>
                        </div>
                        @endauth
                    </div>

                    <!-- Right Side: User Menu & Mobile Toggle -->
                    <div class="flex items-center space-x-4">
                        @auth
                        <!-- User Profile Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-neutral-50 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center">
                                    <span class="text-primary-600 font-semibold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                </div>
                                <div class="hidden md:block text-left">
                                    <div class="text-sm font-medium text-neutral-900">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-neutral-500">{{ ucfirst(auth()->user()->role) }}</div>
                                </div>
                                <svg class="w-4 h-4 text-neutral-500 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-neutral-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-2">
                                    <div class="px-4 py-3 border-b border-neutral-200">
                                        <p class="text-sm font-medium text-neutral-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-neutral-500">{{ auth()->user()->email }}</p>
                                        <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium rounded-full bg-primary-100 text-primary-800">
                                            {{ ucfirst(auth()->user()->role) }}
                                        </span>
                                    </div>
                                    @if(auth()->user()->isAdmin())
                                    <a href="{{ route('register') }}" class="flex items-center space-x-3 px-4 py-2 text-sm text-neutral-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        <span>Add User</span>
                                    </a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Menu Button -->
                        <button id="mobile-menu-button" class="lg:hidden p-2 rounded-lg text-neutral-600 hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors">
                            Login
                        </a>
                        @endauth
                    </div>
                </div>

                <!-- Mobile Menu -->
                @auth
                <div id="mobile-menu" class="hidden lg:hidden border-t border-neutral-200 py-4">
                    <div class="space-y-1">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('categories.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('categories.*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <span>Categories</span>
                        </a>
                        <a href="{{ route('products.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('products.*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <span>Products</span>
                        </a>
                        <a href="{{ route('inbound-shipments.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('inbound-shipments.*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Inbound Shipments</span>
                        </a>
                        <a href="{{ route('outbound-shipments.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('outbound-shipments.*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Outbound Shipments</span>
                        </a>
                        <a href="{{ route('customers.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('customers.*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>Customers</span>
                        </a>
                        <a href="{{ route('warehouses.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('warehouses.*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>Warehouses</span>
                        </a>
                        <a href="{{ route('shipping-zones.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('shipping-zones.*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Shipping Zones</span>
                        </a>
                        <a href="{{ route('reports.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('reports.*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span>Reports</span>
                        </a>
                        @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                        <a href="{{ route('users.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('users.*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span>Users</span>
                        </a>
                        @endif
                    </div>
                </div>
                @endauth
            </div>
        </nav>

        <script>
            // Mobile menu toggle
            document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                const menu = document.getElementById('mobile-menu');
                const button = document.getElementById('mobile-menu-button');
                if (menu && button && !menu.contains(event.target) && !button.contains(event.target)) {
                    menu.classList.add('hidden');
                }
            });
        </script>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>
</body>

</html>