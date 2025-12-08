@extends('layouts.master')

@section('title', 'Home - Wisata Soppeng')

@section('content')
    <div class="text-center" style="margin-bottom: 40px;">
        <h2 style="color: var(--primary-color);">Selamat Datang di Kota Kalong!</h2>

        <p style="font-size: 1.15em; max-width: 800px; margin: 20px auto; color: #555;">
            <strong>Kabupaten Soppeng</strong>, atau yang dikenal dengan julukan <em>Bumi Latemmamala</em>, adalah permata tersembunyi di Sulawesi Selatan. Terkenal dengan keunikan kelelawar yang hidup berdampingan di pusat kota dan pemandian alam air panas yang menenangkan.
        </p>
    </div>

    <hr style="border: 0; border-top: 1px solid #ccc; margin: 30px 0;">

    <h3 class="text-center" style="color: #333;">Mengapa Berkunjung ke Soppeng?</h3>
    <div style="display: flex; justify-content: space-around; text-align: center; gap: 20px; margin-top: 30px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 250px;">
            <h4 style="color: var(--primary-color);">🌿 Wisata Alam Relaksasi</h4>
            <p>Nikmati sensasi berendam di <strong>Permandian Alam Lejja</strong> dengan air panas alami belerang yang dikelilingi hutan asri nan sejuk.</p>
        </div>
        <div style="flex: 1; min-width: 250px;">
            <h4 style="color: var(--accent-color);">🏛️ Sejarah & Budaya</h4>
            <p>Telusuri jejak masa lampau di <strong>Villa Yuliana</strong>, bangunan peninggalan Belanda yang ikonik, serta rumah bagi ribuan kelelawar di jantung kota.</p>
        </div>
        <div style="flex: 1; min-width: 250px;">
            <h4 style="color: #e76f51;">🍛 Kuliner Otentik</h4>
            <p>Manjakan lidah Anda dengan pedas gurihnya <strong>Nasu Palekko</strong> dan manisnya kue tradisional <strong>Bolu Cukke</strong> yang legendaris.</p>
        </div>
    </div>

    <div class="text-center" style="margin-top: 50px;">
        <a href="{{ url('/destinasi') }}" style="background-color: var(--primary-color); color: white; padding: 12px 25px; text-decoration: none; border-radius: 25px; font-weight: bold; transition: background 0.3s;">Mulai Eksplorasi</a>
    </div>
@endsection
