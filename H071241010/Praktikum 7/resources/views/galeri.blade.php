@extends('layouts.master')

@section('title', 'Galeri Foto Bone')

@section('content')
    <div class="container mx-auto px-6 py-8">

        <h1 class="text-4xl font-bold text-gray-800 text-center mb-10">Galeri Foto Bone</h1>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            
            @php
                $galleryUrls = [
                    'https://assets-a1.kompasiana.com/items/album/2020/12/21/unnamed-5fe03ebd8ede48374523fb93.jpg',
                    'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjcGlvgdPOd2Z9NLgl409YTmpWkgAfvMNdQGm0mQBiS6Y8LW_Nn45piWep0TV8LJBxIZjaoM1Dg_KhUzyjcdEDYOvsMkxSRIUzQ30QtitAKfo2dwBzOTgmTHHoffNyfLZTWZTwVU99n36U/s740/IMG_ORG_1627282134287.jpeg',
                    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQlL2xBrxX1ZD0Fw93Qv97BcG7QJ7nXp9TuNw&s',
                    'https://cdn.rri.co.id/berita/Bone/o/1723247385439-IMG-20240807-WA0066/g5t96fgxv78dylv.jpeg',
                    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTO3PWt0nlTGYTO_C_0LWp_drFI-W0UAvipdg&s',
                    'https://heikamu.com/wp-content/uploads/2021/11/foto-prewedding-adat-bugis.jpg',
                    'https://radarmukomuko.disway.id/upload/9bb2f4fb2cb2f474708fd2b3a8699cf8.jpg',
                    'https://pict.sindonews.net/dyn/850/pena/news/2022/02/09/713/681643/pemprov-sulel-bantu-rp800-juta-renovasi-masjid-al-markaz-al-maarif-bone-ogz.jpg'
                ];
            @endphp

            @foreach ($galleryUrls as $url)
            <div class="rounded-lg shadow-lg overflow-hidden">
                <img src="{{ $url }}" alt="Galeri Foto Bone" 
                     class="w-full h-64 object-cover transition-transform duration-300 hover:scale-110">
            </div>
            @endforeach

        </div>

    </div> @endsection