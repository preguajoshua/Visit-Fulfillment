@props(['type', 'size' => '', 'mute' => '', 'color' => '', 'title' => ''])

@php
    $colors = [
        'good' => 'text-green-600',
        'neutral' => 'text-yellow-400',
        'poor' => 'text-red-600',
    ];

    $height = ($size) ? "h-{$size}" : 'h-7';
    $width = ($size) ? "w-{$size}" : 'w-7';

    if ($mute) {
        $textColor = "{$mute} hover:{$colors[$type]} focus:{$colors[$type]} focus:outline-none";
    } else {
        $textColor = $color ?: $colors[$type];
    }
@endphp

@switch ($type)
    @case('good')
        <svg class="{{ $height }} {{ $width }} {{ $textColor }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <title>{{ $title ?: 'Good'}}</title>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        @break

    @case('neutral')
        <svg class="{{ $height }} {{ $width }} {{ $textColor }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <title>{{ $title ?: 'Neutral'}}</title>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 0 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        @break

    @case('poor')
        <svg class="{{ $height }} {{ $width }} {{ $textColor }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <title>{{ $title ?: 'Poor'}}</title>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        @break
@endswitch
