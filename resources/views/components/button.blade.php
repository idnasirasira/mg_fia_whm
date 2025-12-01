@props([
'type' => 'button', // button, link, submit
'variant' => 'primary', // primary, accent, secondary, outline, danger
'href' => null,
'icon' => null,
'iconPosition' => 'left', // left, right
])

@php
$baseClasses = 'inline-flex items-center px-4 py-2 border rounded-lg font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150';

$variantClasses = [
'primary' => 'bg-primary-600 border-transparent text-white hover:bg-primary-700 focus:ring-primary-500',
'accent' => 'bg-accent-600 border-transparent text-white hover:bg-accent-700 focus:ring-accent-500',
'secondary' => 'bg-secondary-600 border-transparent text-white hover:bg-secondary-700 focus:ring-secondary-500',
'outline' => 'border-neutral-300 text-neutral-700 bg-white hover:bg-neutral-50 focus:ring-neutral-500',
'danger' => 'bg-red-600 border-transparent text-white hover:bg-red-700 focus:ring-red-500',
];

$classes = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['primary']);
@endphp

@if($type === 'link' && $href)
<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon && $iconPosition === 'left')
    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        {!! $icon !!}
    </svg>
    @endif
    {{ $slot }}
    @if($icon && $iconPosition === 'right')
    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        {!! $icon !!}
    </svg>
    @endif
</a>
@elseif($type === 'submit')
<button type="submit" {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon && $iconPosition === 'left')
    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        {!! $icon !!}
    </svg>
    @endif
    {{ $slot }}
    @if($icon && $iconPosition === 'right')
    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        {!! $icon !!}
    </svg>
    @endif
</button>
@else
<button type="button" {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon && $iconPosition === 'left')
    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        {!! $icon !!}
    </svg>
    @endif
    {{ $slot }}
    @if($icon && $iconPosition === 'right')
    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        {!! $icon !!}
    </svg>
    @endif
</button>
@endif