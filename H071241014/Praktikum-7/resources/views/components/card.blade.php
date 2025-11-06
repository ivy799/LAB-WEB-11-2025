<div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
    @if(isset($image))
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-48 object-cover">
    @endif
    <div class="p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $title }}</h3>
        <p class="text-gray-600">{{ $description }}</p>
    </div>
</div>