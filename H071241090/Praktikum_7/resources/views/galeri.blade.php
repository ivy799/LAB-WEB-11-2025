@extends('template.template')

@section('title', 'Galeri Bandung')

@section('content')
    <div class="text-center mb-12">
        <h2 class="text-4xl font-extrabold mb-4 text-teal-800">Galeri Bandung</h2>
        <p class="text-gray-700 max-w-2xl mx-auto">
            Kumpulan foto yang menangkap keindahan alam, budaya, dan suasana khas Kota Bandung.
        </p>
    </div>

    <section class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
        <x-gambar-section src="images/galeri1.jpg" caption="Galeri 1" />
        <x-gambar-section src="images/galeri2.jpg" caption="Galeri 2" />
        <x-gambar-section src="images/galeri3.jpg" caption="Galeri 3" />
        <x-gambar-section src="images/galeri4.jpg" caption="Galeri 4" />
        <x-gambar-section src="images/galeri5.jpg" caption="Galeri 5" />
        <x-gambar-section src="images/galeri6.jpg" caption="Galeri 6" />
    </section>

    <div class="text-center mt-12">
        <a href="/" class="inline-block bg-teal-700 text-white px-6 py-3 rounded-xl font-semibold hover:bg-teal-800 transition">
            ← Kembali ke Beranda
        </a>
    </div>
@endsection
