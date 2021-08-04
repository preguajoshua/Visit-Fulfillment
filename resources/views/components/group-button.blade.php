@props(['prop', 'value', 'current', 'position' => 'middle'])

@php
    if ($position === 'start') {
        $rounded = 'rounded-l-md';
    } elseif ($position === 'end') {
        $rounded = 'rounded-r-md';
    } else {
        $rounded = '';
    }

    $bgColor = ($current == $value)
        ? 'bg-gray-100'
        : 'bg-white';
@endphp

<button
    wire:click="$set('{{ $prop }}', '{{ $value }}')"
    class="inline-flex items-center px-4 py-2 {{ $rounded }} border border-gray-300 {{ $bgColor }} text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none"
>
    {{ $slot }}
</button>
