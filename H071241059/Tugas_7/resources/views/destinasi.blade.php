@extends('layouts.master')

@section('title', 'Destinasi Wisata Soppeng')

@section('content')
    <div class="text-center">
        <h2>Destinasi Unggulan</h2>
        <p style="margin-bottom: 40px;">Temukan ketenangan alam dan keunikan sejarah di Bumi Latemmamala.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">

        {{-- Destinasi 1 --}}
        <x-card-destinasi
            judul="Permandian Alam Lejja"
            deskripsi="Kawasan wisata air panas alami dengan kandungan belerang yang tinggi, dipercaya berkhasiat untuk kesehatan. Dikelilingi hutan lindung yang sejuk dan asri."
            gambar="lejja-pool.webp"
        />

        {{-- Destinasi 2 --}}
        <x-card-destinasi
            judul="Villa Yuliana"
            deskripsi="Bangunan bersejarah peninggalan kolonial Belanda yang dibangun tahun 1905. Kini difungsikan sebagai Museum Latemmamala yang menyimpan benda pusaka."
            gambar="villa-yuliana.jpeg"
        />

        {{-- Destinasi 3 --}}
        <x-card-destinasi
            judul="Taman Kalong"
            deskripsi="Ikon unik Kota Watansoppeng di mana ribuan kelelawar bergantungan di pohon asam di tengah kota pada siang hari. Pemandangan yang tak ada duanya."
            gambar="taman-kalong.webp"
        />

    </div>
@endsection
