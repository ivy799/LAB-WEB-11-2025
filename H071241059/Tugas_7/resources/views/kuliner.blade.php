@extends('layouts.master')

@section('title', 'Kuliner Khas Soppeng')

@section('content')
    <div class="text-center">
        <h2>Cita Rasa Soppeng</h2>
        <p style="margin-bottom: 40px;">Nikmati hidangan khas yang menggugah selera.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">

        {{-- Kuliner 1 --}}
        <x-card-destinasi
            judul="Nasu Palekko"
            deskripsi="Olahan daging bebek (itik) cincang yang dimasak dengan bumbu rempah super pedas khas Bugis. Kuliner wajib bagi pecinta masakan pedas."
            gambar="nasu-palekko.jpeg"
        />

        {{-- Kuliner 2 --}}
        <x-card-destinasi
            judul="Bolu Cukke"
            deskripsi="Kue bolu kecil berwarna kecokelatan yang terbuat dari gula merah. Memiliki tekstur lembut dengan rasa manis yang khas, cocok untuk oleh-oleh."
            gambar="bolu-cukke.webp"
        />

        {{-- Kuliner 3 --}}
        <x-card-destinasi
            judul="Tape Pulu Bolong"
            deskripsi="Tape ketan hitam yang difermentasi secara tradisional. Sering disajikan dalam acara adat atau sebagai hidangan penutup yang manis dan segar."
            gambar="tape-ketan.webp"
        />

    </div>
@endsection
