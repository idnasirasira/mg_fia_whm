@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-6">
            <a href="{{ route('activity-logs.index') }}" class="inline-flex items-center text-sm text-neutral-600 hover:text-neutral-900 mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Activity Logs
            </a>
            <h1 class="text-3xl font-bold text-neutral-900">Activity Log Details</h1>
        </div>

        <div class="bg-white shadow-md rounded-xl border border-neutral-200 overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 bg-neutral-50 border-b border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-neutral-900">Activity #{{ $activityLog->id }}</h2>
                        <p class="text-sm text-neutral-500 mt-1">
                            {{ $activityLog->created_at->format('F d, Y \a\t H:i:s') }}
                        </p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        {{ $activityLog->action === 'created' ? 'bg-secondary-100 text-secondary-800' : 
                           ($activityLog->action === 'updated' ? 'bg-primary-100 text-primary-800' : 
                            ($activityLog->action === 'deleted' ? 'bg-red-100 text-red-800' : 'bg-accent-100 text-accent-800')) }}">
                        {{ ucfirst($activityLog->action) }}
                    </span>
                </div>
            </div>

            <div class="px-6 py-6 space-y-6">
                <!-- User Information -->
                <div>
                    <h3 class="text-sm font-medium text-neutral-700 mb-3">User Information</h3>
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">User</dt>
                            <dd class="mt-1 text-sm text-neutral-900">
                                @if($activityLog->user)
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center mr-3">
                                            <span class="text-primary-600 font-semibold text-sm">{{ strtoupper(substr($activityLog->user->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <div class="font-medium">{{ $activityLog->user->name }}</div>
                                            <div class="text-xs text-neutral-500">{{ $activityLog->user->email }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-neutral-400">System</span>
                                @endif
                            </dd>
                        </div>
                        @if($activityLog->user)
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">Role</dt>
                            <dd class="mt-1 text-sm text-neutral-900">{{ ucfirst($activityLog->user->role) }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>

                <!-- Action Details -->
                <div>
                    <h3 class="text-sm font-medium text-neutral-700 mb-3">Action Details</h3>
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">Action</dt>
                            <dd class="mt-1 text-sm text-neutral-900">{{ ucfirst($activityLog->action) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">Model Type</dt>
                            <dd class="mt-1 text-sm text-neutral-900">
                                {{ class_basename($activityLog->model_type) }}
                                @if($relatedModel && $modelUrl)
                                    <a href="{{ $modelUrl }}" 
                                       class="ml-2 text-primary-600 hover:text-primary-900 text-xs">
                                        View Model →
                                    </a>
                                @elseif($activityLog->model_id)
                                    <span class="ml-2 text-xs text-neutral-400">(Model may be deleted)</span>
                                @endif
                            </dd>
                        </div>
                        @if($activityLog->model_id)
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">Model ID</dt>
                            <dd class="mt-1 text-sm text-neutral-900">#{{ $activityLog->model_id }}</dd>
                        </div>
                        @endif
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">Timestamp</dt>
                            <dd class="mt-1 text-sm text-neutral-900">
                                {{ $activityLog->created_at->format('F d, Y H:i:s') }}
                                <span class="text-xs text-neutral-400">({{ $activityLog->created_at->diffForHumans() }})</span>
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Description -->
                @if($activityLog->description)
                <div>
                    <h3 class="text-sm font-medium text-neutral-700 mb-3">Description</h3>
                    <p class="text-sm text-neutral-900 bg-neutral-50 p-4 rounded-lg border border-neutral-200">
                        {{ $activityLog->description }}
                    </p>
                </div>
                @endif

                <!-- Changes -->
                @if($activityLog->changes && !empty($activityLog->changes))
                <div>
                    <h3 class="text-sm font-medium text-neutral-700 mb-3">Changes</h3>
                    <div class="bg-neutral-50 p-4 rounded-lg border border-neutral-200">
                        <div class="space-y-3">
                            @if(is_array($activityLog->changes))
                                @foreach($activityLog->changes as $field => $change)
                                    <div class="border-b border-neutral-200 pb-3 last:border-b-0 last:pb-0">
                                        <div class="font-medium text-sm text-neutral-700 mb-1">{{ ucfirst(str_replace('_', ' ', $field)) }}</div>
                                        @if(is_array($change) && isset($change['old']) && isset($change['new']))
                                            <div class="grid grid-cols-2 gap-3 text-sm">
                                                <div>
                                                    <div class="text-xs text-neutral-500 mb-1">Old Value</div>
                                                    <div class="bg-red-50 text-red-800 p-2 rounded border border-red-200">
                                                        {{ is_array($change['old']) ? json_encode($change['old'], JSON_PRETTY_PRINT) : ($change['old'] ?? 'N/A') }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="text-xs text-neutral-500 mb-1">New Value</div>
                                                    <div class="bg-secondary-50 text-secondary-800 p-2 rounded border border-secondary-200">
                                                        {{ is_array($change['new']) ? json_encode($change['new'], JSON_PRETTY_PRINT) : ($change['new'] ?? 'N/A') }}
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-sm text-neutral-600">
                                                {{ is_array($change) ? json_encode($change, JSON_PRETTY_PRINT) : $change }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <pre class="text-xs text-neutral-600 whitespace-pre-wrap">{{ json_encode($activityLog->changes, JSON_PRETTY_PRINT) }}</pre>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Technical Information -->
                <div>
                    <h3 class="text-sm font-medium text-neutral-700 mb-3">Technical Information</h3>
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        @if($activityLog->ip_address)
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">IP Address</dt>
                            <dd class="mt-1 text-sm text-neutral-900 font-mono">{{ $activityLog->ip_address }}</dd>
                        </div>
                        @endif
                        @if($activityLog->user_agent)
                        <div>
                            <dt class="text-sm font-medium text-neutral-500">User Agent</dt>
                            <dd class="mt-1 text-sm text-neutral-900 font-mono text-xs break-all">{{ $activityLog->user_agent }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>

                <!-- Related Model Information -->
                @if($relatedModel)
                <div>
                    <h3 class="text-sm font-medium text-neutral-700 mb-3">Related Model</h3>
                    <div class="bg-primary-50 p-4 rounded-lg border border-primary-200">
                        <p class="text-sm text-primary-800">
                            The related {{ class_basename($activityLog->model_type) }} record still exists in the system.
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

