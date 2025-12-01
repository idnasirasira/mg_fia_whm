@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-neutral-900">User Details</h1>
            <div class="flex space-x-3">
                @if(auth()->user()->isAdmin())
                <x-button-edit href="{{ route('users.edit', $user) }}" />
                @endif
                <x-button-back href="{{ route('users.index') }}" />
            </div>
        </div>

        <div class="bg-white shadow-md rounded-xl border border-neutral-200 p-6">
            <div class="flex items-center mb-6">
                <div class="w-20 h-20 rounded-full bg-primary-100 flex items-center justify-center mr-6">
                    <span class="text-primary-600 font-semibold text-2xl">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-neutral-900">{{ $user->name }}</h2>
                    <p class="text-neutral-500">{{ $user->email }}</p>
                    <span class="inline-block mt-2 px-3 py-1 text-sm font-semibold rounded-full 
                        {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                           ($user->role === 'manager' ? 'bg-blue-100 text-blue-800' : 'bg-neutral-100 text-neutral-800') }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>

            <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Email</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Role</dt>
                    <dd class="mt-1 text-sm text-neutral-900">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                               ($user->role === 'manager' ? 'bg-blue-100 text-blue-800' : 'bg-neutral-100 text-neutral-800') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Warehouse</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $user->warehouse ? $user->warehouse->name : 'No warehouse assigned' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-neutral-500">Created At</dt>
                    <dd class="mt-1 text-sm text-neutral-900">{{ $user->created_at->format('F d, Y \a\t h:i A') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection