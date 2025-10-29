@extends('layouts.master')
@section('title', 'Kuliner - Eksplor Bulukumba')

@section('content')
<div class="bg-gradient-to-b from-orange-50 via-white to-yellow-50 min-h-screen py-16">
    <div class="text-center mb-16">
        <h2 class="text-5xl font-extrabold text-orange-600 mb-3 tracking-tight drop-shadow-sm font-[PlayfairDisplay]">
            Kuliner Khas Bulukumba
        </h2>
        <p class="text-gray-700 text-lg max-w-2xl mx-auto leading-relaxed font-[Poppins]">
            Nikmati cita rasa khas Bulukumba — dari olahan laut segar hingga kue tradisional yang penuh makna budaya dan kehangatan.
        </p>
        <div class="w-24 h-1 bg-gradient-to-r from-orange-400 to-yellow-400 mx-auto mt-6 rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-6xl mx-auto px-4">

        @php
            $menus = [
                [
                    'img' => 'parape.jpg',
                    'title' => 'Ikan Parape',
                    'desc' => 'Hidangan ikan bakar khas Sulawesi Selatan dengan sambal parape — campuran bawang, tomat, dan cabai goreng. Rasanya pedas, segar, dan gurih, nikmat disantap dengan nasi hangat.',
                    'icon' => '🔥',
                    'badge' => 'Pake nasiki!',
                    'color' => 'from-orange-50 to-orange-100 border-orange-200'
                ],
                [
                    'img' => 'barobbo.jpg',
                    'title' => 'Barobbo',
                    'desc' => 'Masakan tradisional berbahan dasar jagung muda yang dimasak seperti bubur dengan ikan atau udang. Teksturnya lembut dan gurih, pas dinikmati sore hari.',
                    'icon' => '🌽',
                    'badge' => 'Pake cukka enak!',
                    'color' => 'from-amber-50 to-yellow-100 border-yellow-200'
                ],
                [
                    'img' => 'uhu-uhu.jpg',
                    'title' => 'Uhu-Uhu',
                    'desc' => 'Kuliner pesisir Bulukumba dari ikan segar dimasak dengan bumbu kuning dan santan. Rasa gurih dan sedikit asam menggambarkan cita rasa khas laut Sulawesi Selatan.',
                    'icon' => '🕺',
                    'badge' => '',
                    'color' => 'from-blue-50 to-cyan-100 border-cyan-200'
                ],
                [
                    'img' => 'songkolo.jpg',
                    'title' => 'Songkolo',
                    'desc' => 'Nasi ketan hitam atau putih yang dikukus dan disajikan dengan parutan kelapa serta ikan asin. Biasanya disantap saat pagi hari atau pada acara keluarga.',
                    'icon' => '🍙',
                    'badge' => '',
                    'color' => 'from-purple-50 to-pink-100 border-purple-200'
                ],
                [
                    'img' => 'paranggi.jpg',
                    'title' => 'Paranggi',
                    'desc' => 'Kue tradisional Bulukumba dari tepung terigu, gula merah, dan santan yang digoreng hingga kecokelatan. Rasanya manis legit, cocok untuk teman minum kopi.',
                    'icon' => '🤸',
                    'badge' => 'Cocok buat oleh-oleh!',
                    'color' => 'from-pink-50 to-rose-100 border-pink-200'
                ],
                [
                    'img' => 'barongko.jpg',
                    'title' => 'Barongko',
                    'desc' => 'Kue lembut berbahan pisang yang dihaluskan, dicampur santan dan telur, dibungkus daun pisang lalu dikukus. Hidangan adat Bugis-Makassar simbol kehangatan keluarga.',
                    'icon' => '🍌',
                    'badge' => '',
                    'color' => 'from-green-50 to-emerald-100 border-green-200'
                ]
            ];
        @endphp

        @foreach ($menus as $menu)
        <div class="relative bg-gradient-to-br {{ $menu['color'] }} rounded-3xl p-6 shadow-[0_10px_25px_rgba(0,0,0,0.08)] border-2 backdrop-blur-sm hover:scale-[1.02] hover:shadow-[0_15px_30px_rgba(0,0,0,0.12)] transition duration-300 ease-out">
            @if ($menu['badge'])
            <div class="absolute -top-3 -right-3 z-10">
                <div class="bg-gradient-to-br from-orange-500 to-red-500 text-white px-4 py-2 rounded-full font-bold text-sm shadow-lg rotate-12 border-2 border-white">
                    {{ $menu['badge'] }}
                </div>
            </div>
            @endif
            <div class="absolute top-5 left-5 opacity-30 text-4xl select-none">🌸</div>
            <div class="bg-white rounded-2xl overflow-hidden shadow-md mb-4">
                <img src="{{ asset('images/' . $menu['img']) }}" alt="{{ $menu['title'] }}" class="w-full h-56 object-cover">
            </div>
            <div class="flex items-center gap-3 mb-3">
                <div class="text-white text-xl bg-gradient-to-tr from-orange-500 to-red-500 w-10 h-10 rounded-full flex items-center justify-center shadow-md">
                    {{ $menu['icon'] }}
                </div>
                <h3 class="text-2xl font-bold text-gray-800 font-[Poppins]">{{ $menu['title'] }}</h3>
            </div>

            <p class="text-gray-700 text-sm leading-relaxed font-[Inter]">
                {{ $menu['desc'] }}
            </p>
        </div>
        @endforeach

    </div>

    <!-- Footer -->
    <div class="mt-16 text-center">
        <div class="inline-block bg-white/60 backdrop-blur-md rounded-full px-8 py-3 border border-orange-200 shadow-md">
            <p class="text-gray-700 font-semibold tracking-wide">
                Setiap hidangan menceritakan warisan budaya dan cita rasa Bulukumba
            </p>
        </div>
    </div>

</div>
@endsection
