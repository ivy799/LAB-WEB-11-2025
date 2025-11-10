@props(['route'])

@php
    $isActive = request()->routeIs($route);
    $classes = $isActive
                ? 'inline-block text-blue-600 border-b-2 border-blue-600 py-2 px-4 font-semibold'
                : 'inline-block text-gray-600 hover:text-gray-900 py-2 px-4';
@endphp

<a href="{{ route($route) }}" class="{{ $classes }}">
    {{ $slot }}
</a>