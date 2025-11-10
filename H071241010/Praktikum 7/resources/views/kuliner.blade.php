@extends('layouts.master')

@section('title', 'Kuliner Khas Bone')

@section('content')
    <h1 class="text-4xl font-bold text-gray-800 text-center mb-10">Kuliner Khas Bone</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        <x-content-card image="https://osccdn.medcom.id/images/content/2021/05/17/c02465f1dfb8fe2d6dc108fa002c7aa5.jpg" title="Nasu Palekko">
            Olahan daging bebek atau itik yang dicincang dan dimasak dengan bumbu rempah yang kaya dan cita rasa pedas yang khas. Sangat menggugah selera!
        </x-content-card>

        <x-content-card image="https://asset.kompas.com/crops/GSnSkWBe5h40j7LWWoUMlDfHYtA=/0x0:698x465/1200x800/data/photo/2021/06/13/60c5dd1340bb7.jpg" title="Barobbo">
            Bubur jagung pulut yang gurih, sering disajikan dengan sayuran, irisan ayam, atau ikan. Makanan ini sangat populer sebagai sarapan atau hidangan utama.
        </x-content-card>

        <x-content-card image="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR_UrLSoXjSlsggdD1iIbiXtEZ30iykQvk-vA&s" title="Bolu Cukke">
            Kue bolu tradisional berbentuk unik dengan rasa manis gula aren dan aroma kayu manis. Teksturnya yang padat membuatnya awet dan cocok sebagai oleh-oleh.
        </x-content-card>

    </div>
@endsection