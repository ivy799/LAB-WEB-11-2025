@extends('layouts.master')

@section('title', 'Galeri Soppeng')

@section('content')
    <div class="text-center">
        <h2>Galeri Lensa Soppeng</h2>
        <p style="margin-bottom: 30px;">Potret keindahan alam dan suasana Kota Kalong.</p>
    </div>

    <style>
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }
        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .gallery-item img:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 12px rgba(0,0,0,0.2);
        }
        .caption {
            text-align: center;
            margin-top: 8px;
            font-size: 0.95em;
            color: #555;
            font-style: italic;
        }
    </style>

    <div class="gallery-grid">
        <div class="gallery-item">
            <img src="{{ asset('images/lejja-pool.webp') }}" alt="Kolam Air Panas Lejja">
            <p class="caption">Kolam Air Panas Lejja</p>
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/villa-yuliana.jpeg') }}" alt="Museum Villa Yuliana">
            <p class="caption">Kemegahan Villa Yuliana</p>
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/kelelawar.jpeg') }}" alt="Kelelawar Kota">
            <p class="caption">Kelelawar di Pusat Kota</p>
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/waduk-ompo.webp') }}" alt="Waduk Ompo">
            <p class="caption">Wisata Alam Waduk Ompo</p>
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/masjid-agung.webp') }}" alt="Masjid Agung Darussalam">
            <p class="caption">Masjid Agung Darussalam Soppeng</p>
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/landscape-soppeng.webp') }}" alt="Pemandangan Alam">
            <p class="caption">Lansekap Alam Bumi Latemmamala</p>
        </div>
    </div>
@endsection
