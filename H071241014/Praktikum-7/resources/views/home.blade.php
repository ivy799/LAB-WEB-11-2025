@extends('layouts.master')

@section('title', 'Home - Eksplor Palembang')

@section('content')
<div class="hero-bg text-white py-20">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-5xl font-bold mb-4">Selamat Datang di Palembang</h1>
        <p class="text-xl mb-8">Kota Pempek dan Jembatan Ampera yang Megah</p>
        <x-button url="/destinasi" text="Jelajahi Destinasi" />
    </div>
</div>

<div class="container mx-auto px-6 py-16">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Tentang Palembang</h2>
        <div class="bg-white rounded-lg shadow-lg p-8">
            <p class="text-gray-700 leading-relaxed mb-4">
                Palembang adalah ibu kota Provinsi Sumatera Selatan yang terletak di tepi Sungai Musi. Sebagai salah satu kota tertua di Indonesia, Palembang memiliki sejarah yang kaya sebagai pusat Kerajaan Sriwijaya yang berjaya pada abad ke-7 hingga ke-13 Masehi.
            </p>
            <p class="text-gray-700 leading-relaxed mb-4">
                Kota ini terkenal dengan ikon utamanya, Jembatan Ampera, yang menjadi simbol kebanggaan masyarakat Palembang. Selain itu, Palembang juga dikenal sebagai kota kuliner dengan pempek sebagai makanan khas yang terkenal hingga mancanegara.
            </p>
            <p class="text-gray-700 leading-relaxed">
                Dengan perpaduan antara warisan sejarah, budaya Melayu yang kental, dan perkembangan modern, Palembang menawarkan pengalaman wisata yang unik dan tak terlupakan bagi setiap pengunjung.
            </p>
        </div>
    </div>

    
    </div>
</div>
@endsection