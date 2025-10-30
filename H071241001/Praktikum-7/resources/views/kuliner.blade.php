@extends('layouts.master')

@section('title', 'Kuliner Khas - Eksplor Medan')

@section('content')

<section class="hero-pattern py-20">
    <div class="container mx-auto px-4 text-center text-white">
        <div class="animate-fade-in">
            <i class="fas fa-utensils text-6xl mb-6"></i>
            <h1 class="text-5xl font-bold mb-4">{{ $title }}</h1>
            <p class="text-xl max-w-2xl mx-auto" style="color: #f3b0c3;">
                Nikmati kelezatan kuliner legendaris Medan yang terkenal hingga mancanegara
            </p>
        </div>
    </div>
</section>

<section class="bg-gray-100 py-4">
    <div class="container mx-auto px-4">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ url('/') }}" class="hover:text-red-900">Home</a>
            <i class="fas fa-chevron-right mx-2 text-xs"></i>
            <span class="font-semibold" style="color: #800020;">Kuliner</span>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-6">Surga Kuliner Nusantara</h2>
            <p class="text-gray-600 text-lg leading-relaxed">
                Medan dikenal sebagai surganya kuliner di Indonesia. Perpaduan budaya Melayu, Batak, Tionghoa, dan India menciptakan cita rasa yang unik dan tak terlupakan. Dari makanan tradisional hingga modern, Medan menawarkan pengalaman kuliner yang luar biasa.
            </p>
        </div>
    </div>
</section>


<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($foods as $food)
                <x-card 
                    :image="$food['image']"
                    :title="$food['name']"
                    :description="$food['description']"
                    :price="$food['price']"
                />
            @endforeach
        </div>
    </div>
</section>


<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Kategori Kuliner Populer</h2>
            <p class="text-gray-600 text-lg">Berbagai jenis makanan khas yang wajib dicoba</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="rounded-xl p-6 hover:shadow-lg transition duration-300" style="background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);">
                <div class="flex items-center mb-4">
                    <div class="bg-orange-500 text-white rounded-full w-12 h-12 flex items-center justify-center mr-4">
                        <i class="fas fa-drumstick-bite text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Makanan Berat</h3>
                </div>
                <p class="text-gray-600 text-sm">Soto Medan, Mie Gomak, Nasi Padang, Nasi Goreng Kampung</p>
            </div>
            
            <div class="rounded-xl p-6 hover:shadow-lg transition duration-300" style="background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);">
                <div class="flex items-center mb-4">
                    <div class="bg-yellow-500 text-white rounded-full w-12 h-12 flex items-center justify-center mr-4">
                        <i class="fas fa-cookie-bite text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Camilan & Kue</h3>
                </div>
                <p class="text-gray-600 text-sm">Bika Ambon, Pancake Durian, Bolu Meranti, Lemang</p>
            </div>
            
            <div class="rounded-xl p-6 hover:shadow-lg transition duration-300" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);">
                <div class="flex items-center mb-4">
                    <div class="bg-green-500 text-white rounded-full w-12 h-12 flex items-center justify-center mr-4">
                        <i class="fas fa-mug-hot text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Minuman</h3>
                </div>
                <p class="text-gray-600 text-sm">Kopi Sanger, Teh Tarik, Es Durian, Jus Markisa</p>
            </div>
        </div>
    </div>
</section>


<section class="py-16" style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%);">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 flex items-center">
                    <i class="fas fa-map-marker-alt mr-3" style="color: #800020;"></i>
                    Pusat Kuliner Medan
                </h2>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="pl-6" style="border-left: 4px solid #800020;">
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Jalan Semarang</h3>
                        <p class="text-gray-600 mb-3">Pusat kuliner Tionghoa dengan berbagai restoran dan kedai legendaris</p>
                        <div class="flex items-center text-sm" style="color: #800020;">
                            <i class="fas fa-star mr-1"></i>
                            <span>Rating: 4.8/5</span>
                        </div>
                    </div>
                    
                    <div class="pl-6" style="border-left: 4px solid #800020;">
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Jalan Selat Panjang</h3>
                        <p class="text-gray-600 mb-3">Wisata kuliner malam dengan berbagai menu seafood dan nasi goreng</p>
                        <div class="flex items-center text-sm" style="color: #800020;">
                            <i class="fas fa-star mr-1"></i>
                            <span>Rating: 4.7/5</span>
                        </div>
                    </div>
                    
                    <div class="pl-6" style="border-left: 4px solid #800020;">
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Jalan Mojopahit</h3>
                        <p class="text-gray-600 mb-3">Surga kuliner malam dengan beragam pilihan makanan tradisional</p>
                        <div class="flex items-center text-sm" style="color: #800020;">
                            <i class="fas fa-star mr-1"></i>
                            <span>Rating: 4.6/5</span>
                        </div>
                    </div>
                    
                    <div class="pl-6" style="border-left: 4px solid #800020;">
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Pasar Petisah</h3>
                        <p class="text-gray-600 mb-3">Pasar tradisional dengan aneka jajanan dan makanan khas Medan</p>
                        <div class="flex items-center text-sm" style="color: #800020;">
                            <i class="fas fa-star mr-1"></i>
                            <span>Rating: 4.5/5</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl shadow-2xl p-8 md:p-12 text-center text-white">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Lapar? Saatnya Menjelajah!</h2>
            <p class="text-lg text-orange-100 mb-8 max-w-2xl mx-auto">
                Jangan lewatkan kesempatan mencicipi kuliner legendaris Medan yang terkenal se-Indonesia
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ url('/destinasi') }}" class="inline-block bg-white text-orange-600 font-semibold px-8 py-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                    <i class="fas fa-map-marked-alt mr-2"></i>Lihat Destinasi
                </a>
                <a href="{{ url('/kontak') }}" class="inline-block bg-yellow-400 text-gray-800 font-semibold px-8 py-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                    <i class="fas fa-envelope mr-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>
@endsection