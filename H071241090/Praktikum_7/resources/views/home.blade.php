@extends('template.template')

@section('title', 'Beranda')

@section('content')
    <div class="text-center mb-12">
        <h2 class="text-4xl font-extrabold mb-4 text-teal-800">Selamat Datang di Eksplor Bandung!</h2>
        <p class="text-lg text-gray-700 mb-8 max-w-2xl mx-auto">
            Temukan keindahan wisata alam, budaya, dan kuliner khas Bandung.  
            Dari pesona pegunungan yang sejuk hingga jajanan legendaris yang menggugah selera — semua ada di sini.
        </p>
        <img src="{{ asset('images/bandung1.jpg') }}" alt="Bandung" class="mx-auto rounded-2xl shadow-lg w-3/4 md:w-1/2">
    </div>

    <section class="grid md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <img src="{{ asset('images/lembang.jpg') }}" alt="Destinasi Bandung" class="rounded-lg mb-4 h-100">
            <h3 class="text-xl font-semibold mb-2 text-teal-700">Destinasi Wisata</h3>
            <p class="text-gray-600 text-sm">
                Nikmati udara sejuk Lembang, keindahan Kawah Putih, dan pesona alam Dago yang memukau.
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <img src="{{ asset('images/batagor.jpg') }}" alt="Kuliner Bandung" class="rounded-lg mb-4 ">
            <h3 class="text-xl font-semibold mb-2 text-teal-700">Kuliner Khas</h3>
            <p class="text-gray-600 text-sm">
                Cicipi surabi, batagor, dan seblak — cita rasa khas yang bikin rindu Bandung.
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <img src="{{ asset('images/galeri1.jpg') }}" alt="Galeri Bandung" class="rounded-lg mb-4">
            <h3 class="text-xl font-semibold mb-2 text-teal-700">Galeri Bandung</h3>
            <p class="text-gray-600 text-sm">
                Lihat berbagai foto keindahan alam, seni, dan budaya masyarakat Bandung dalam galeri kami.
            </p>
        </div>
    </section>

    <div class="text-center mt-12">
        <a href="/destinasi" class="inline-block bg-teal-700 text-white px-6 py-3 rounded-xl font-semibold hover:bg-teal-800 transition">
            Jelajahi Sekarang →
        </a>
    </div>
@endsection
