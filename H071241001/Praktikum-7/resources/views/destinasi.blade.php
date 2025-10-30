@extends('layouts.master')

@section('title', 'Destinasi Wisata - Eksplor Medan')

@section('content')

<section class="hero-pattern py-20">
    <div class="container mx-auto px-4 text-center text-white">
        <div class="animate-fade-in">
            <i class="fas fa-map-marked-alt text-6xl mb-6"></i>
            <h1 class="text-5xl font-bold mb-4">{{ $title }}</h1>
            <p class="text-xl max-w-2xl mx-auto" style="color: #f3b0c3;">
                Temukan pesona destinasi wisata terbaik di Kota Medan, dari bangunan bersejarah hingga tempat rekreasi modern
            </p>
        </div>
    </div>
</section>


<section class="bg-gray-100 py-4">
    <div class="container mx-auto px-4">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ url('/') }}" class="hover:text-red-900">Home</a>
            <i class="fas fa-chevron-right mx-2 text-xs"></i>
            <span class="font-semibold" style="color: #800020;">Destinasi</span>
        </div>
    </div>
</section>


<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($destinations as $destination)
                <x-card 
                    :image="$destination['image']"
                    :title="$destination['name']"
                    :description="$destination['description']"
                    :location="$destination['location']"
                />
            @endforeach
        </div>
    </div>
</section>


<section class="py-16" style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%);">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-info-circle mr-3" style="color: #800020;"></i>
                    Tips Berwisata di Medan
                </h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="flex items-start">
                        <div class="rounded-full p-3 mr-4" style="background-color: #fce4ec;">
                            <i class="fas fa-clock text-xl" style="color: #800020;"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 mb-2">Waktu Terbaik</h3>
                            <p class="text-gray-600 text-sm">Kunjungi Medan di bulan Juni-Agustus untuk cuaca yang lebih cerah</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="rounded-full p-3 mr-4" style="background-color: #fce4ec;">
                            <i class="fas fa-car text-xl" style="color: #800020;"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 mb-2">Transportasi</h3>
                            <p class="text-gray-600 text-sm">Gunakan ojek online atau rental mobil untuk kemudahan berpindah tempat</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="rounded-full p-3 mr-4" style="background-color: #fce4ec;">
                            <i class="fas fa-ticket-alt text-xl" style="color: #800020;"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 mb-2">Tiket Masuk</h3>
                            <p class="text-gray-600 text-sm">Sebagian besar destinasi memiliki tiket masuk yang terjangkau</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="rounded-full p-3 mr-4" style="background-color: #fce4ec;">
                            <i class="fas fa-camera text-xl" style="color: #800020;"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 mb-2">Spot Foto</h3>
                            <p class="text-gray-600 text-sm">Jangan lupa kamera untuk mengabadikan momen indah Anda</p>
                        </div>
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
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Jelajahi Lebih Banyak</h2>
            <p class="text-lg mb-8 max-w-2xl mx-auto" style="color: #f3b0c3;">
                Masih penasaran dengan Medan? Cek kuliner khas dan galeri foto kami
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ url('/kuliner') }}" class="inline-block bg-white font-semibold px-8 py-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300" style="color: #800020;">
                    <i class="fas fa-utensils mr-2"></i>Kuliner Khas
                </a>
                <a href="{{ url('/galeri') }}" class="inline-block bg-amber-500 text-white font-semibold px-8 py-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                    <i class="fas fa-images mr-2"></i>Galeri Foto
                </a>
            </div>
        </div>
    </div>
</section>
@endsection