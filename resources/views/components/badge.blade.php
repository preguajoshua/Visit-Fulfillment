@props(['text' => 'text-gray-800', 'bg' => 'bg-gray-100'])

<span class="px-2 inline-flex items-center text-xs leading-6 font-semibold rounded-full {{ $bg }} {{ $text }}">
    {{ $slot }}
</span>
