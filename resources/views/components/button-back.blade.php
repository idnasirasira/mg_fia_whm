@props(['href', 'label' => 'Back'])

<x-button
    type="link"
    variant="outline"
    :href="$href"
    icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />'>
    {{ $label }}
</x-button>