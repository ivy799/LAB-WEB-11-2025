@extends('layouts.master')

@section('title', 'Home - Eksplor Medan')

@section('content')

<section class="hero-pattern py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center text-white animate-fade-in">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">{{ $title }}</h1>
            <p class="text-xl md:text-2xl mb-4" style="color: #f3b0c3;">{{ $subtitle }}</p>
            <p class="text-lg mb-8 leading-relaxed" style="color: #f9d5e0;">{{ $description }}</p>
            <div class="flex flex-wrap justify-center gap-4">
                <x-button url="{{ url('/destinasi') }}" icon="fas fa-map-marked-alt" text="Jelajahi Destinasi" />
                <x-button url="{{ url('/kuliner') }}" icon="fas fa-utensils" text="Cicipi Kuliner" />
            </div>
        </div>
    </div>
</section>


<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Kenapa Medan?</h2>
            <p class="text-gray-600 text-lg">Discover what makes Medan special</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($highlights as $index => $highlight)
            <div class="text-center p-6 rounded-xl hover:shadow-lg transition duration-300 animate-fade-in" style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%); animation-delay: {{ $index * 0.1 }}s">
                <div class="text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4" style="background: linear-gradient(135deg, #800020 0%, #a0153e 100%);">
                    <i class="fas fa-check text-2xl"></i>
                </div>
                <p class="text-gray-700 font-medium">{{ $highlight }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="animate-fade-in">
                <h2 class="text-4xl font-bold text-gray-800 mb-6">Tentang Kota Medan</h2>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Medan adalah kota terbesar ketiga di Indonesia dan ibu kota provinsi Sumatera Utara. Dengan populasi lebih dari 2 juta jiwa, Medan menjadi pusat ekonomi, politik, dan budaya di wilayah Sumatera.
                </p>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Kota ini terkenal dengan keragaman etnis dan budaya, mulai dari Melayu, Batak, Tionghoa, India, hingga Jawa yang hidup berdampingan harmonis. Keragaman ini tercermin dalam arsitektur, kuliner, dan kehidupan sehari-hari masyarakat Medan.
                </p>
                <p class="text-gray-600 leading-relaxed mb-6">
                    Medan juga merupakan gerbang menuju destinasi wisata populer seperti Danau Toba, Bukit Lawang, dan berbagai objek wisata alam lainnya di Sumatera Utara.
                </p>
                <x-button url="{{ url('/destinasi') }}" icon="fas fa-arrow-right" text="Mulai Eksplorasi" />
            </div>
            
            <div class="grid grid-cols-2 gap-4 animate-fade-in">
                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                    <div class="text-4xl font-bold mb-2" style="color: #800020;">50+</div>
                    <p class="text-gray-600">Destinasi Wisata</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                    <div class="text-4xl font-bold mb-2" style="color: #800020;">100+</div>
                    <p class="text-gray-600">Kuliner Legendaris</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                    <div class="text-4xl font-bold mb-2" style="color: #800020;">2.1M+</div>
                    <p class="text-gray-600">Populasi</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                    <div class="text-4xl font-bold mb-2" style="color: #800020;">265 Km²</div>
                    <p class="text-gray-600">Luas Wilayah</p>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Mulai Penjelajahan Anda</h2>
            <p class="text-gray-600 text-lg">Pilih kategori yang ingin Anda eksplorasi</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          
            <div class="relative overflow-hidden rounded-2xl shadow-xl group cursor-pointer transform hover:scale-105 transition duration-300">
                <img src="https://images.unsplash.com/photo-1564769662533-4f00a87b4056?w=800&h=600&fit=crop" alt="Destinasi" class="w-full h-80 object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-map-marked-alt text-3xl mr-3"></i>
                        <h3 class="text-2xl font-bold">Destinasi Wisata</h3>
                    </div>
                    <p class="text-gray-200 mb-4">Jelajahi tempat-tempat bersejarah dan ikonik di Medan</p>
                    <a href="{{ url('/destinasi') }}" class="inline-flex items-center text-amber-400 font-semibold hover:text-amber-300">
                        Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            <div class="relative overflow-hidden rounded-2xl shadow-xl group cursor-pointer transform hover:scale-105 transition duration-300">
                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800&h=600&fit=crop" alt="Kuliner" class="w-full h-80 object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-utensils text-3xl mr-3"></i>
                        <h3 class="text-2xl font-bold">Kuliner Khas</h3>
                    </div>
                    <p class="text-gray-200 mb-4">Rasakan kelezatan makanan khas Medan yang legendaris</p>
                    <a href="{{ url('/kuliner') }}" class="inline-flex items-center text-amber-400 font-semibold hover:text-amber-300">
                        Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
          
            <div class="relative overflow-hidden rounded-2xl shadow-xl group cursor-pointer transform hover:scale-105 transition duration-300">
                <img src="https://images.unsplash.com/photo-1452421822248-d4c2b47f0c81?w=800&h=600&fit=crop" alt="Galeri" class="w-full h-80 object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-images text-3xl mr-3"></i>
                        <h3 class="text-2xl font-bold">Galeri Foto</h3>
                    </div>
                    <p class="text-gray-200 mb-4">Saksikan keindahan Medan melalui koleksi foto kami</p>
                    <a href="{{ url('/galeri') }}" class="inline-flex items-center text-amber-400 font-semibold hover:text-amber-300">
                        Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 gradient-bg">
    <div class="container mx-auto px-4 text-center">
        <div class="max-w-3xl mx-auto text-white">
            <h2 class="text-4xl font-bold mb-6">Siap Menjelajahi Medan?</h2>
            <p class="text-xl mb-8" style="color: #f3b0c3;">
                Temukan destinasi wisata terbaik, kuliner legendaris, dan pesona budaya Kota Medan
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ url('/kontak') }}" class="inline-block bg-white font-semibold px-8 py-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300" style="color: #800020;">
                    <i class="fas fa-envelope mr-2"></i>Hubungi Kami
                </a>
                <a href="{{ url('/galeri') }}" class="inline-block bg-amber-500 text-white font-semibold px-8 py-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                    <i class="fas fa-camera mr-2"></i>Lihat Galeri
                </a>
            </div>
        </div>
    </div>
</section>
@endsection