@extends('layouts.master')

@section('title', 'Destinasi Wisata Bone')

@section('content')
    <div class="container mx-auto px-6 py-8">

        <h1 class="text-4xl font-bold text-gray-800 text-center mb-10">Destinasi Wisata Unggulan</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <x-content-card image="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjcGlvgdPOd2Z9NLgl409YTmpWkgAfvMNdQGm0mQBiS6Y8LW_Nn45piWep0TV8LJBxIZjaoM1Dg_KhUzyjcdEDYOvsMkxSRIUzQ30QtitAKfo2dwBzOTgmTHHoffNyfLZTWZTwVU99n36U/s740/IMG_ORG_1627282134287.jpeg" title="Tanjung Pallette">
                Sebuah kompleks wisata pantai dengan tebing-tebing karang yang eksotis. Menawarkan pemandangan matahari terbenam yang spektakuler dan berbagai fasilitas rekreasi air.
            </x-content-card>

            <x-content-card image="https://www.bagooli.com/wp-content/uploads/2018/01/gambar-2-tripasvisor.jpg" title="Gua Mampu">
                Gua alam terbesar di Sulawesi Selatan yang penuh dengan stalaktit dan stalagmit unik. Gua ini juga diselimuti dengan legenda lokal yang menarik.
            </x-content-card>

            <x-content-card image="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTlvCNyn8r8XH-xrK8TxYpUOjwIMpHrN6FxOw&s" title="Air Terjun Salo Merunge">
                Terletak di kawasan hutan yang asri, air terjun ini menawarkan kesegaran alam dan pemandangan yang menenangkan, cocok untuk melepas penat.
            </x-content-card>

        </div>

    </div>
@endsection