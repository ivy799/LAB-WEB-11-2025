@extends('template.template')

@section('title', 'Destinasi Wisata Bandung')

@section('content')
    <div class="text-center mb-12">
        <h2 class="text-4xl font-extrabold mb-4 text-teal-800">Destinasi Wisata Bandung</h2>
        <p class="text-gray-700 max-w-2xl mx-auto">
            Bandung dikenal dengan suasana sejuk dan pemandangan alamnya yang indah.  
            Berikut beberapa destinasi wisata yang wajib kamu kunjungi!
        </p>
    </div>

    <section class="grid md:grid-cols-3 gap-8">
        <div class="bg-white rounded-2xl shadow p-5 hover:shadow-lg transition">
            <img src="{{ asset('images/lembang.jpg') }}" alt="Lembang" class="rounded-lg mb-4">
            <h3 class="text-xl font-semibold text-teal-700 mb-2">Lembang</h3>
            <p class="text-gray-600 text-sm">
                Kawasan pegunungan yang sejuk dengan banyak objek wisata seperti Farmhouse, Floating Market, dan The Lodge Maribaya.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow p-5 hover:shadow-lg transition">
            <img src="{{ asset('images/kawahputih.jpg') }}" alt="Kawah Putih" class="rounded-lg mb-4">
            <h3 class="text-xl font-semibold text-teal-700 mb-2">Kawah Putih</h3>
            <p class="text-gray-600 text-sm">
                Danau vulkanik berwarna putih kehijauan di Ciwidey dengan suasana dingin dan mistis yang memesona.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow p-5 hover:shadow-lg transition">
            <img src="{{ asset('images/dago.jpg') }}" alt="Dago" class="rounded-lg mb-4">
            <h3 class="text-xl font-semibold text-teal-700 mb-2">Dago</h3>
            <p class="text-gray-600 text-sm">
                Kawasan wisata kota yang modern, dengan kafe, taman, dan tempat melihat pemandangan kota Bandung dari ketinggian.
            </p>
        </div>
    </section>

    <div class="text-center mt-12">
        <a href="/" class="inline-block bg-teal-700 text-white px-6 py-3 rounded-xl font-semibold hover:bg-teal-800 transition">
            ← Kembali ke Beranda
        </a>
    </div>
@endsection
