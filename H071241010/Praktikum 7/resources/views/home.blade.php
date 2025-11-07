@extends('layouts.master')

@section('title', 'Selamat Datang di Bone')

@section('content')
    <div class="relative bg-cover bg-center rounded-lg shadow-xl overflow-hidden" style="height: 60vh; background-image: url('https://static.wixstatic.com/media/8775b0_1efad5df10de4336ab23653a729394c3~mv2.jpg/v1/fill/w_888,h_500,al_c,q_85,enc_avif,quality_auto/8775b0_1efad5df10de4336ab23653a729394c3~mv2.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="text-center text-white p-6">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">Selamat Datang di Bone</h1>
                <p class="text-lg md:text-2xl mb-6">Tanah Sejarah dan Keindahan Alam di Sulawesi Selatan</p>
                <a href="{{ route('destinasi') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg transition duration-300">
                    Mulai Eksplorasi
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-lg shadow-lg mt-12">
        <h2 class="text-3xl font-semibold text-gray-800 text-center mb-6">Tentang Kabupaten Bone</h2>
        <p class="text-gray-700 text-lg leading-relaxed text-center max-w-3xl mx-auto">
            Kabupaten Bone, yang berjuluk "Bumi Arung Palakka", adalah sebuah wilayah yang kaya akan sejarah dan budaya di Sulawesi Selatan. Sebagai bekas kerajaan besar, Bone mewariskan banyak situs bersejarah, tradisi yang memukau, serta keindahan alam yang menakjubkan mulai dari pesisir pantai hingga perbukitan yang asri.
        </p>
    </div>
@endsection