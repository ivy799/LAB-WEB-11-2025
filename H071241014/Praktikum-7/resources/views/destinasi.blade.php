@extends('layouts.master')

@section('title', 'Destinasi - Eksplor Palembang')

@section('content')
<div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-16">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl font-bold mb-4">Destinasi Wisata Palembang</h1>
        <p class="text-xl">Jelajahi tempat-tempat menakjubkan di Kota Pempek</p>
    </div>
</div>

<div class="container mx-auto px-6 py-16">
    <div class="grid md:grid-cols-3 gap-8">
        <x-card 
            title="Jembatan Ampera"
            description="Jembatan ikonik yang melintasi Sungai Musi, menjadi simbol Kota Palembang. Dibangun pada tahun 1962 dan merupakan landmark utama yang wajib dikunjungi. Pemandangan saat matahari terbenam dari jembatan ini sangat memukau."
            image="image/jembatan ampera.jpg"
        />
        
        <x-card 
            title="Pulau Kemaro"
            description="Pulau kecil di tengah Sungai Musi yang memiliki legenda romantis tentang Siti Fatimah dan Tan Bun Ann. Di pulau ini terdapat pagoda megah dan vihara yang menjadi tempat ziarah. Aksesnya menggunakan perahu motor dari dermaga."
            image="image/pulau kemaro.jpg"
        />
        
        <x-card 
            title="Masjid Agung Palembang"
            description="Masjid Sultan Mahmud Badaruddin I yang megah dengan arsitektur khas Palembang. Berdiri sejak tahun 1738 dan menjadi salah satu masjid tertua di Indonesia. Kubah dan ornamen masjid sangat indah dengan perpaduan budaya lokal."
            image="image/masjid agung palembang.jpg"
        />
        
        <x-card 
            title="Benteng Kuto Besak"
            description="Benteng peninggalan Kesultanan Palembang Darussalam yang dibangun pada tahun 1780. Benteng ini dulunya menjadi pusat pemerintahan kesultanan. Kini menjadi destinasi wisata sejarah yang menarik dengan arsitektur yang masih terjaga."
            image="image/Benteng Kuto Besak.jpg"
        />
        
        <x-card 
            title="Museum Sultan Mahmud Badaruddin II"
            description="Museum yang dulunya merupakan istana kesultanan. Menyimpan berbagai koleksi bersejarah termasuk keris, meriam, dan benda-benda peninggalan kesultanan. Bangunannya sendiri merupakan peninggalan bersejarah yang megah."
            image="image/Museum Sultan Mahmud Badaruddin II.jpg"
        />
        
        <x-card 
            title="Kampung Kapitan"
            description="Kawasan Pecinan yang memiliki nilai sejarah tinggi dengan bangunan-bangunan bergaya Tionghoa kuno. Terdapat klenteng Hok Tek Bio yang sudah berusia ratusan tahun. Area ini cocok untuk wisata sejarah dan fotografi."
            image="image/kampung kapitan.jpg"
        />
    </div>
</div>
@endsection