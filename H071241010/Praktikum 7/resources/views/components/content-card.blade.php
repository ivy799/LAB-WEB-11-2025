@props(['image', 'title'])

<div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:scale-105">
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-48 object-cover">
    <div class="p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $title }}</h3>
        <p class="text-gray-600">
            {{ $slot }}
        </p>
    </div>
</div>