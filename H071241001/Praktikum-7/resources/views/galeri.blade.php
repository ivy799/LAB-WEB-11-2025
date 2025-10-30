@extends('layouts.master')

@section('title', 'Galeri Foto - Eksplor Medan')

@section('content')
<!-- Hero Section -->
<section class="hero-pattern py-20">
    <div class="container mx-auto px-4 text-center text-white">
        <div class="animate-fade-in">
            <i class="fas fa-images text-6xl mb-6"></i>
            <h1 class="text-5xl font-bold mb-4">{{ $title }}</h1>
            <p class="text-xl max-w-2xl mx-auto" style="color: #f3b0c3;">
                Saksikan keindahan Kota Medan melalui koleksi foto pilihan kami
            </p>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<section class="bg-gray-100 py-4">
    <div class="container mx-auto px-4">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ url('/') }}" class="hover:text-red-900">Home</a>
            <i class="fas fa-chevron-right mx-2 text-xs"></i>
            <span class="font-semibold" style="color: #800020;">Galeri</span>
        </div>
    </div>
</section>

<!-- Gallery Intro -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-6">Jelajahi Medan Dalam Gambar</h2>
            <p class="text-gray-600 text-lg leading-relaxed">
                Dari landmark ikonik hingga momen budaya yang memukau, galeri kami menampilkan berbagai sisi Kota Medan yang mempesona. Setiap foto menceritakan kisah unik tentang kekayaan budaya dan keindahan kota ini.
            </p>
        </div>
    </div>
</section>

<!-- Gallery Grid by Category -->
@foreach($galleries as $index => $gallery)
<section class="py-12 {{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $gallery['category'] }}</h2>
            <div class="w-20 h-1" style="background: linear-gradient(90deg, #800020 0%, #a0153e 100%);"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($gallery['images'] as $image)
            <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer">
                <div class="aspect-w-4 aspect-h-3 relative h-72">
                    <img src="{{ asset('images/' . $image['src']) }}" alt="{{ $image['caption'] }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500" onerror="this.src='https://via.placeholder.com/800x600/800020/ffffff?text={{ urlencode($image['caption']) }}'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-full group-hover:translate-y-0 transition duration-300">
                        <p class="font-semibold text-lg">{{ $image['caption'] }}</p>
                    </div>
                </div>
                <div class="absolute top-4 right-4 bg-white rounded-full w-10 h-10 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300" style="color: #800020;">
                    <i class="fas fa-search-plus"></i>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endforeach

<!-- Photo Stats -->
<section class="py-16" style="background: linear-gradient(135deg, #800020 0%, #a0153e 100%);">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white">
            <div class="animate-fade-in">
                <div class="text-5xl font-bold mb-2">500+</div>
                <p style="color: #f3b0c3;">Total Foto</p>
            </div>
            <div class="animate-fade-in" style="animation-delay: 0.1s">
                <div class="text-5xl font-bold mb-2">20+</div>
                <p style="color: #f3b0c3;">Kategori</p>
            </div>
            <div class="animate-fade-in" style="animation-delay: 0.2s">
                <div class="text-5xl font-bold mb-2">10K+</div>
                <p style="color: #f3b0c3;">Pengunjung</p>
            </div>
            <div class="animate-fade-in" style="animation-delay: 0.3s">
                <div class="text-5xl font-bold mb-2">50+</div>
                <p style="color: #f3b0c3;">Fotografer</p>
            </div>
        </div>
    </div>
</section>

<!-- Tips Photography -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <div class="rounded-2xl shadow-xl p-8 md:p-12" style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%);">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 flex items-center">
                    <i class="fas fa-camera mr-3" style="color: #800020;"></i>
                    Tips Fotografi di Medan
                </h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl p-6 shadow-md">
                        <div class="flex items-start">
                            <div class="rounded-full p-3 mr-4" style="background-color: #fce4ec;">
                                <i class="fas fa-sun text-xl" style="color: #800020;"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 mb-2">Golden Hour</h3>
                                <p class="text-gray-600 text-sm">Foto terbaik saat pagi (06:00-08:00) atau sore (16:00-18:00) untuk pencahayaan natural yang sempurna</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl p-6 shadow-md">
                        <div class="flex items-start">
                            <div class="rounded-full p-3 mr-4" style="background-color: #fce4ec;">
                                <i class="fas fa-building text-xl" style="color: #800020;"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 mb-2">Spot Arsitektur</h3>
                                <p class="text-gray-600 text-sm">Istana Maimun dan Masjid Raya memiliki detail arsitektur yang fotogenik dari berbagai sudut</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl p-6 shadow-md">
                        <div class="flex items-start">
                            <div class="rounded-full p-3 mr-4" style="background-color: #fce4ec;">
                                <i class="fas fa-users text-xl" style="color: #800020;"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 mb-2">Human Interest</h3>
                                <p class="text-gray-600 text-sm">Tangkap momen kehidupan lokal di pasar tradisional atau pusat kota untuk foto yang bercerita</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl p-6 shadow-md">
                        <div class="flex items-start">
                            <div class="rounded-full p-3 mr-4" style="background-color: #fce4ec;">
                                <i class="fas fa-palette text-xl" style="color: #800020;"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 mb-2">Warna Khas</h3>
                                <p class="text-gray-600 text-sm">Manfaatkan warna-warni bangunan kolonial dan dekorasi budaya untuk foto yang vibrant</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Instagram Feed Simulation -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Bagikan Momen Anda</h2>
            <p class="text-gray-600 text-lg mb-6">Tag kami di Instagram <span class="font-semibold" style="color: #800020;">@eksplormedan</span></p>
            <div class="flex justify-center space-x-4">
                <a href="#" class="inline-flex items-center text-white px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300" style="background: linear-gradient(135deg, #800020 0%, #a0153e 100%);">
                    <i class="fab fa-instagram mr-2 text-xl"></i>
                    Follow Instagram
                </a>
                <a href="#" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                    <i class="fab fa-facebook-f mr-2"></i>
                    Like Facebook
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="relative group overflow-hidden rounded-lg shadow-md cursor-pointer">
                <img src="https://images.unsplash.com/photo-1564769662533-4f00a87b4056?w=400&h=400&fit=crop" alt="Instagram Post" class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                    <div class="text-white text-center">
                        <i class="fas fa-heart text-3xl mb-2"></i>
                        <p class="font-semibold">1.2K Likes</p>
                    </div>
                </div>
            </div>
            
            <div class="relative group overflow-hidden rounded-lg shadow-md cursor-pointer">
                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400&h=400&fit=crop" alt="Instagram Post" class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                    <div class="text-white text-center">
                        <i class="fas fa-heart text-3xl mb-2"></i>
                        <p class="font-semibold">890 Likes</p>
                    </div>
                </div>
            </div>
            
            <div class="relative group overflow-hidden rounded-lg shadow-md cursor-pointer">
                <img src="https://images.unsplash.com/photo-1452421822248-d4c2b47f0c81?w=400&h=400&fit=crop" alt="Instagram Post" class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                    <div class="text-white text-center">
                        <i class="fas fa-heart text-3xl mb-2"></i>
                        <p class="font-semibold">2.1K Likes</p>
                    </div>
                </div>
            </div>
            
            <div class="relative group overflow-hidden rounded-lg shadow-md cursor-pointer">
                <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=400&h=400&fit=crop" alt="Instagram Post" class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                    <div class="text-white text-center">
                        <i class="fas fa-heart text-3xl mb-2"></i>
                        <p class="font-semibold">1.5K Likes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="rounded-2xl shadow-2xl p-8 md:p-12 text-center text-white" style="background: linear-gradient(135deg, #800020 0%, #a0153e 100%);">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Terinspirasi untuk Berkunjung?</h2>
            <p class="text-lg mb-8 max-w-2xl mx-auto" style="color: #f3b0c3;">
                Jangan hanya melihat foto, rasakan langsung keindahan Medan dengan mengunjungi destinasi wisata kami
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ url('/destinasi') }}" class="inline-block bg-white font-semibold px-8 py-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300" style="color: #800020;">
                    <i class="fas fa-map-marked-alt mr-2"></i>Lihat Destinasi
                </a>
                <a href="{{ url('/kontak') }}" class="inline-block bg-amber-500 text-white font-semibold px-8 py-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                    <i class="fas fa-envelope mr-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>
@endsection