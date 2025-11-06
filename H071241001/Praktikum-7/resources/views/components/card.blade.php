<div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover animate-fade-in">
    <div class="relative overflow-hidden h-64">
        @if(filter_var($image, FILTER_VALIDATE_URL))
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover transform hover:scale-110 transition duration-500" onerror="this.src='https://via.placeholder.com/800x600/800020/ffffff?text={{ urlencode($title) }}'">
        @else
            <img src="{{ asset('images/' . $image) }}" alt="{{ $title }}" class="w-full h-full object-cover transform hover:scale-110 transition duration-500" onerror="this.src='https://via.placeholder.com/800x600/800020/ffffff?text={{ urlencode($title) }}'">
        @endif
        <div class="absolute top-4 right-4 text-white px-3 py-1 rounded-full text-sm font-semibold" style="background-color: #800020;">
            <i class="fas fa-star mr-1"></i> Featured
        </div>
    </div>
    <div class="p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ $title }}</h3>
        <p class="text-gray-600 leading-relaxed mb-4">{{ $description }}</p>
        @if(isset($location))
            <div class="flex items-center text-sm mb-2" style="color: #800020;">
                <i class="fas fa-map-marker-alt mr-2"></i>
                <span>{{ $location }}</span>
            </div>
        @endif
        @if(isset($price))
            <div class="flex items-center text-sm text-green-600 font-semibold">
                <i class="fas fa-tag mr-2"></i>
                <span>{{ $price }}</span>
            </div>
        @endif
    </div>
</div>