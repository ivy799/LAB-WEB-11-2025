@extends('layouts.master')

@section('title', 'Galeri Foto - Eksplor Medan')

@section('content')

<section class="hero-pattern py-20">
    <div class="container mx-auto px-4 text-center text-white">
        <div class="animate-fade-in">
            <i class="fas fa-images text-6xl mb-6"></i>
            <h1 class="text-5xl font-bold mb-4">{{ $title }}</h1>
            <p class="text-xl text-purple-200 max-w-2xl mx-auto">
                Saksikan keindahan Kota Medan melalui koleksi foto pilihan kami
            </p>
        </div>
    </div>
</section>


<section class="bg-gray-100 py-4">
    <div class="container mx-auto px-4">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ url('/') }}" class="hover:text-purple-600">Home</a>
            <i class="fas fa-chevron-right mx-2 text-xs"></i>
            <span class="text-purple-600 font-semibold">Galeri</span>
        </div>
    </div>
</section>


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


@foreach($galleries as $index => $gallery)
<section class="py-12 {{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $gallery['category'] }}</h2>
            <div class="w-20 h-1 bg-gradient-to-r from-purple-600 to-indigo-600"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($gallery['images'] as $image)
            <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer">
                <div class="aspect-w-4 aspect-h-3 relative h-72">
                    <img src="{{ asset('images/' . $image['src']) }}" alt="{{ $image['caption'] }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-full group-hover:translate-y-0 transition duration-300">
                        <p class="font-semibold text-lg">{{ $image['caption'] }}</p>
                    </div>
                </div>
                <div class="absolute top-4 right-4 bg-white text-purple-600 rounded-full w-10 h-10 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                    <i class="fas fa-search-plus"></i>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endforeach
>
<section class="py-16 bg-gradient-to-r from-purple-600 to-indigo-600">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white">
            <div class="animate-fade-in">
                <div class="text-5xl font-bold mb-2">500+</div>
                <p class="text-purple-200">Total Foto</p>
            </div>
            <div class="animate-fade-in" style="animation-delay: 0.1s">
                <div class="text-5xl font-bold mb-2">20+</div>
                <p class="text-