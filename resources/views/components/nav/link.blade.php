@props(['active'])

@php
$classes = ($active ?? false)
            ? 'bg-green-600 text-white px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out'
            : 'text-green-100 hover:bg-green-400 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
