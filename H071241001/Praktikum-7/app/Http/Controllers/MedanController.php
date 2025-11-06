<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedanController extends Controller
{
    public function home()
    {
        $data = [
            'title' => 'Selamat Datang di Kota Medan',
            'subtitle' => 'Kota Metropolitan Terbesar Ketiga di Indonesia',
            'description' => 'Medan, ibu kota Sumatera Utara, adalah kota yang kaya akan sejarah, budaya, dan kuliner. Dikenal sebagai pintu gerbang Indonesia bagian barat, Medan menawarkan perpaduan unik antara tradisi dan modernitas dengan keramahan masyarakat multikultural.',
            'highlights' => [
                'Kuliner legendaris yang terkenal hingga mancanegara',
                'Arsitektur kolonial Belanda yang masih terjaga',
                'Istana Maimun sebagai ikon sejarah kesultanan',
                'Gerbang menuju destinasi wisata Danau Toba'
            ]
        ];
        
        return view('home', $data);
    }

    public function destinasi()
    {
        $data = [
            'title' => 'Destinasi Wisata Medan',
            'destinations' => [
                [
                    'name' => 'Istana Maimun',
                    'description' => 'Istana kebanggaan Kesultanan Deli yang dibangun tahun 1888 dengan arsitektur Melayu, Islam, Spanyol, India, dan Italia. Istana ini masih difungsikan dan terbuka untuk umum dengan interior mewah dan koleksi benda bersejarah.',
                    'image' => 'istana-maimun.jpg',
                    'location' => 'Jl. Brigadir Jenderal Katamso, Medan'
                ],
                [
                    'name' => 'Masjid Raya Al-Mashun',
                    'description' => 'Masjid megah bersejarah yang dibangun tahun 1906 dengan arsitektur Timur Tengah yang memukau. Memiliki 4 menara dan kubah besar, masjid ini menjadi landmark kota Medan dengan interior yang sangat indah dan artistik.',
                    'image' => 'masjid-raya.JPG',
                    'location' => 'Jl. Sisingamangaraja, Medan'
                ],
                [
                    'name' => 'Tjong A Fie Mansion',
                    'description' => 'Rumah megah peninggalan saudagar kaya Tjong A Fie yang telah direnovasi menjadi museum. Bangunan bergaya Tionghoa-Eropa ini menampilkan kemewahan masa lalu dengan furniture antik, lukisan, dan arsitektur yang memesona.',
                    'image' => 'tjong-a-fie.jpg',
                    'location' => 'Jl. Jend. Ahmad Yani, Medan'
                ],
                [
                    'name' => 'Rahmat International Wildlife Museum & Gallery',
                    'description' => 'Museum satwa terlengkap di Asia Tenggara dengan koleksi lebih dari 2000 spesimen dari berbagai belahan dunia. Museum empat lantai ini menampilkan replika habitat alami satwa yang sangat realistis dan edukatif.',
                    'image' => 'rahmat-gallery.jpg',
                    'location' => 'Jl. S. Parman, Medan'
                ]
            ]
        ];
        
        return view('destinasi', $data);
    }

    public function kuliner()
    {
        $data = [
            'title' => 'Kuliner Khas Medan',
            'foods' => [
                [
                    'name' => 'Soto Medan',
                    'description' => 'Soto khas Medan dengan kuah santan gurih berwarna putih, berisi daging sapi, perkedel kentang, dan taburan bawang goreng. Disajikan dengan sambal dan jeruk nipis, menciptakan cita rasa yang khas dan tak terlupakan.',
                    'image' => 'soto-medan.jpg',
                    'price' => 'Rp 25.000 - 35.000'
                ],
                [
                    'name' => 'Bika Ambon',
                    'description' => 'Kue tradisional legendaris Medan yang terkenal hingga mancanegara. Tekstur lembut berpori dengan rasa manis legit dari gula, telur, dan santan. Tersedia varian pandan, durian, keju, dan cokelat.',
                    'image' => 'bika-ambon.jpg',
                    'price' => 'Rp 35.000 - 50.000/kotak'
                ],
                [
                    'name' => 'Mie Gomak',
                    'description' => 'Mie khas Batak dengan kuah andaliman yang memberikan sensasi unik di lidah. Terbuat dari mie tebal yang dimasak dengan bumbu khas Batak, disajikan dengan irisan daging dan sayuran segar.',
                    'image' => 'mie-gomak.jpg',
                    'price' => 'Rp 20.000 - 30.000'
                ],
                [
                    'name' => 'Durian Ucok',
                    'description' => 'Durian medan terkenal dengan kualitas premium, daging tebal, dan rasa yang creamy. Durian Ucok adalah salah satu legenda kuliner Medan yang wajib dicoba oleh pecinta durian dengan berbagai varietas pilihan.',
                    'image' => 'durian-ucok.jpg',
                    'price' => 'Rp 50.000 - 150.000/kg'
                ]
            ]
        ];
        
        return view('kuliner', $data);
    }

    public function galeri()
    {
        $data = [
            'title' => 'Galeri Foto Medan',
            'galleries' => [
                [
                    'category' => 'Landmark',
                    'images' => [
                        ['src' => 'landmark-1.jpg', 'caption' => 'Tugu Selamat Datang di Medan'],
                        ['src' => 'landmark-2.jpeg', 'caption' => 'Menara Tirtanadi - Ikon Kota Medan'],
                        ['src' => 'landmark-3.jpg', 'caption' => 'Merdeka Walk - Pusat Hiburan']
                    ]
                ],
                [
                    'category' => 'Budaya',
                    'images' => [
                        ['src' => 'budaya-1.jpg', 'caption' => 'Tari Tor Tor Batak'],
                        ['src' => 'budaya-2.jpg', 'caption' => 'Festival Barongsai'],
                        ['src' => 'budaya-3.jpg', 'caption' => 'Upacara Adat Batak']
                    ]
                ],
                [
                    'category' => 'Kuliner',
                    'images' => [
                        ['src' => 'kuliner-1.jpg', 'caption' => 'Sate Padang Pondok Makan Garuda'],
                        ['src' => 'kuliner-2.jpg', 'caption' => 'Kopi Sanger - Kopi Khas Aceh'],
                        ['src' => 'kuliner-3.webp', 'caption' => 'Martabak Asan - Martabak Legendaris']
                    ]
                ],
                [
                    'category' => 'Arsitektur',
                    'images' => [
                        ['src' => 'arsitektur-1.jpg', 'caption' => 'Interior Istana Maimun'],
                        ['src' => 'arsitektur-2.jpg', 'caption' => 'Stasiun Medan - Bangunan Kolonial'],
                        ['src' => 'arsitektur-3.jpeg', 'caption' => 'Vihara Gunung Timur']
                    ]
                ]
            ]
        ];
        
        return view('galeri', $data);
    }

    public function kontak()
    {
        $data = [
            'title' => 'Hubungi Kami',
            'contact_info' => [
                'address' => 'Jl. Balai Kota No.1, Medan, Sumatera Utara 20112',
                'phone' => '+62 61 4515441',
                'email' => 'info@pemkomedan.go.id',
                'social' => [   
                    'instagram' => '@medantourism',
                    'facebook' => 'Medan Tourism Official',
                    'twitter' => '@MedanTourism'
                ]
            ]
        ];
        
        return view('kontak', $data);
    }
}