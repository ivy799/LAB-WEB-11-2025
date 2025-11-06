@extends('layouts.master')

@section('title', 'Galeri - Eksplor Palembang')

@section('content')
<div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white py-16">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl font-bold mb-4">Galeri Palembang</h1>
        <p class="text-xl">Kumpulan foto keindahan dan pesona Kota Palembang</p>
    </div>
</div>

<div class="container mx-auto px-6 py-16">
    <div class="grid md:grid-cols-4 gap-6">
        <div class="overflow-hidden rounded-lg shadow-lg card-hover">
            <img src="image/jembatan ampera.jpg" alt="Jembatan Ampera" class="w-full h-64 object-cover">
            <div class="p-4 bg-white">
                <p class="font-semibold text-gray-800">Jembatan Ampera</p>
            </div>
        </div>
        
        <div class="overflow-hidden rounded-lg shadow-lg card-hover">
            <img src="image/pulau kemaro.jpg" alt="pulau" class="w-full h-64 object-cover">
            <div class="p-4 bg-white">
                <p class="font-semibold text-gray-800">Pulau Kemaro</p>
            </div>
        </div>
        
        <div class="overflow-hidden rounded-lg shadow-lg card-hover">
            <img src="image/masjid agung palembang.jpg" alt="Masjid" class="w-full h-64 object-cover">
            <div class="p-4 bg-white">
                <p class="font-semibold text-gray-800">Masjid Agung Palembang</p>
            </div>
        </div>
        
        <div class="overflow-hidden rounded-lg shadow-lg card-hover">
            <img src="image/Museum Sultan Mahmud Badaruddin II.jpg" alt="museum" class="w-full h-64 object-cover">
            <div class="p-4 bg-white">
                <p class="font-semibold text-gray-800">Museum Sultan Mahmud Badaruddin II</p>
            </div>
        </div>
        
        <div class="overflow-hidden rounded-lg shadow-lg card-hover">
            <img src="image/Benteng Kuto Besak.jpg" alt="Benteng" class="w-full h-64 object-cover">
            <div class="p-4 bg-white">
                <p class="font-semibold text-gray-800">Benteng Kuto Besak</p>
            </div>
        </div>
        
        <div class="overflow-hidden rounded-lg shadow-lg card-hover">
            <img src="image/kampung kapitan.jpg" alt="kampung" class="w-full h-64 object-cover">
            <div class="p-4 bg-white">
                <p class="font-semibold text-gray-800">Kampung Kapitan</p>
            </div>
        </div>
        
        <div class="overflow-hidden rounded-lg shadow-lg card-hover">
            <img src="image/tekwan.jpg" alt="Tekwan" class="w-full h-64 object-cover">
            <div class="p-4 bg-white">
                <p class="font-semibold text-gray-800">Tekwan</p>
            </div>
        </div>
        
        <div class="overflow-hidden rounded-lg shadow-lg card-hover">
            <img src="image/pempek.jpg" alt="pempek" class="w-full h-64 object-cover">
            <div class="p-4 bg-white">
                <p class="font-semibold text-gray-800">Pempek Kapal Selam</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg shadow-lg card-hover">
            <img src="image/tempoyak.jpg" alt="tempoyak" class="w-full h-64 object-cover">
            <div class="p-4 bg-white">
                <p class="font-semibold text-gray-800">Tempoyak</p>
            </div>
        </div>
        
        <div class="overflow-hidden rounded-lg shadow-lg card-hover">
            <img src="image/mie celor.jpg" alt="Mie" class="w-full h-64 object-cover">
            <div class="p-4 bg-white">
                <p class="font-semibold text-gray-800">Mie Celor</p>
            </div>
        </div>
        
        <div class="overflow-hidden rounded-lg shadow-lg card-hover">
            <img src="image/lenggang.jpg" alt="lenggang" class="w-full h-64 object-cover">
            <div class="p-4 bg-white">
                <p class="font-semibold text-gray-800">Lenggang</p>
            </div>
        </div>
        
        <div class="overflow-hidden rounded-lg shadow-lg card-hover">
            <img src="image/celimpungan.jpg" alt="celimpungan" class="w-full h-64 object-cover">
            <div class="p-4 bg-white">
                <p class="font-semibold text-gray-800">Celimpungan</p>
            </div>
        </div>




    </div>
</div>
@endsection