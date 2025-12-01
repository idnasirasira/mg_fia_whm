@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-neutral-900">Activity Logs</h1>
            <p class="mt-1 text-sm text-neutral-500">View and filter system activity logs</p>
        </div>

        <!-- Filters -->
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6 mb-6">
            <form method="GET" action="{{ route('activity-logs.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search description..." 
                               class="w-full px-3 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>

                    <!-- User Filter -->
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1">User</label>
                        <select name="user_id" class="w-full px-3 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Action Filter -->
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1">Action</label>
                        <select name="action" class="w-full px-3 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">All Actions</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ ucfirst($action) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Model Type Filter -->
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1">Model Type</label>
                        <select name="model_type" class="w-full px-3 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">All Types</option>
                            @foreach($modelTypes as $type)
                                <option value="{{ $type }}" {{ request('model_type') == $type ? 'selected' : '' }}>
                                    {{ $modelTypeLabels[$type] ?? class_basename($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Date From -->
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1">Date From</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" 
                               class="w-full px-3 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1">Date To</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" 
                               class="w-full px-3 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>

                <div class="flex space-x-3">
                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 font-medium">
                        Apply Filters
                    </button>
                    <a href="{{ route('activity-logs.index') }}" class="px-4 py-2 bg-neutral-200 text-neutral-700 rounded-lg hover:bg-neutral-300 font-medium">
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>

        <!-- Activity Logs Table -->
        <div class="bg-white shadow-md rounded-xl border border-neutral-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead class="bg-neutral-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Timestamp</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Action</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Model</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-neutral-200">
                        @forelse($activityLogs as $log)
                            <tr class="hover:bg-neutral-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                    <div>{{ $log->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs">{{ $log->created_at->format('H:i:s') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($log->user)
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center mr-2">
                                                <span class="text-primary-600 font-semibold text-xs">{{ strtoupper(substr($log->user->name, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-neutral-900">{{ $log->user->name }}</div>
                                                <div class="text-xs text-neutral-500">{{ ucfirst($log->user->role) }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-sm text-neutral-400">System</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $log->action === 'created' ? 'bg-secondary-100 text-secondary-800' : 
                                           ($log->action === 'updated' ? 'bg-primary-100 text-primary-800' : 
                                            ($log->action === 'deleted' ? 'bg-red-100 text-red-800' : 'bg-accent-100 text-accent-800')) }}">
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                    {{ $modelTypeLabels[$log->model_type] ?? class_basename($log->model_type) }}
                                    @if($log->model_id)
                                        <span class="text-xs text-neutral-400">#{{ $log->model_id }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-neutral-600">
                                    {{ $log->description ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('activity-logs.show', $log) }}" class="text-primary-600 hover:text-primary-900">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-neutral-500">
                                    <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="mt-2">No activity logs found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($activityLogs->hasPages())
                <div class="px-6 py-4 border-t border-neutral-200">
                    {{ $activityLogs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

