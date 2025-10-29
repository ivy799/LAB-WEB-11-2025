@extends('template.template')

@section('title', 'Kuliner Khas Bandung')

@section('content')
    <div class="text-center mb-12">
        <h2 class="text-4xl font-extrabold mb-4 text-teal-800">Kuliner Khas Bandung</h2>
        <p class="text-gray-700 max-w-2xl mx-auto">
            Bandung terkenal dengan jajanan khasnya yang lezat dan kreatif.  
            Berikut beberapa kuliner legendaris yang wajib kamu coba!
        </p>
    </div>

    <section class="grid md:grid-cols-3 gap-8">
        <div class="bg-white rounded-2xl shadow p-5 hover:shadow-lg transition">
            <img src="{{ asset('images/batagor.jpg') }}" alt="Batagor" class="rounded-lg mb-4 w-full h-100 object-cover">
            <h3 class="text-xl font-semibold text-teal-700 mb-2">Batagor</h3>
            <p class="text-gray-600 text-sm">
                Baso tahu goreng khas Bandung yang disajikan dengan saus kacang kental — gurih dan nikmat!
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow p-5 hover:shadow-lg transition">
            <img src="{{ asset('images/seblak.jpg') }}" alt="Seblak" class="rounded-lg mb-4 w-full h-100 object-cover">
            <h3 class="text-xl font-semibold text-teal-700 mb-2">Seblak</h3>
            <p class="text-gray-600 text-sm">
                Makanan pedas khas Bandung berbahan kerupuk basah, telur, dan berbagai topping sesuai selera.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow p-5 hover:shadow-lg transition">
            <img src="{{ asset('images/serabi.jpg') }}" alt="Serabi" class="rounded-lg mb-4 w-full h-100 object-cover">
            <h3 class="text-xl font-semibold text-teal-700 mb-2">Serabi</h3>
            <p class="text-gray-600 text-sm">
                Pancake tradisional dari tepung beras yang dipanggang di tungku tanah liat, cocok disantap hangat.
            </p>
        </div>
    </section>

    <div class="text-center mt-12">
        <a href="/" class="inline-block bg-teal-700 text-white px-6 py-3 rounded-xl font-semibold hover:bg-teal-800 transition">
            ← Kembali ke Beranda
        </a>
    </div>
@endsection
