<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HalamanController extends Controller
{
    public function home()
    {
        $judul = "Eksplor Pariwisata Selayar";
        $tagline = "Menjelajahi Keindahan Alam dan Budaya Kepulauan Selayar.";
        return view('home', compact('judul', 'tagline'));
    }

    public function destinasi()
    {
        // Contoh data sederhana
        $destinasi = [
            ['nama' => 'Bukit Nane', 'gambar' => 'bukit_nane.jpg', 'deskripsi' => 'Puncak bukit memberikan pemandangan laut, bukit-bukit, dan pulau-pulau di sekitarnya, sangat indah saat sunrise atau sunset, serta bisa dijadikan spot camping 1.'],
            ['nama' => 'Pulau Tinabo', 'gambar' => 'tinabo.jpg', 'deskripsi' => 'pulau kecil tak berpenghuni di Kepulauan Takabonerate, juga di Selayar, yang seluruhnya dikelilingi pantai berpasir putih dengan air yang sangat jernih. .'],
            ['nama' => 'Pantai Pinang', 'gambar' => 'pantai_pinang.jpg', 'deskripsi' => 'pantai di pesisir timur Pulau Selayar yang terkenal dengan pasir putihnya, air jernih, dan keindahan bawah lautnya yang ideal untuk diving dan snorkeling.'],
            ['nama' => 'Makam Karang', 'gambar' => 'makam_karang.jpg', 'deskripsi' => 'Tumpukan karang mati yang berkumpul hingga terlihat seperti pulau.']
        ];
        return view('destinasi', compact('destinasi'));
    }

    public function kuliner()
    {
     $kuliner = [
        ['nama' => 'Haje', 'gambar' => 'haje.jpg', 'deskripsi' => 'Haje Banneh, sejenis wajik yang terbuat dari jewawut (*banneh*) dicampur gula merah dan seringkali ditambahkan biji kenari. Rasanya manis, gurih, dan bertekstur kenyal.'],
        ['nama' => 'Kue Sengkang', 'gambar' => 'Kue_Sengkang.jpg', 'deskripsi' => 'Kue tradisional berbentuk unik seperti candi Borobudur, terbuat dari tepung beras dan tepung terigu dengan isian atau taburan kacang kenari. Memiliki rasa manis dan gurih.'],
        ['nama' => 'Roti Eja', 'gambar' => 'roji_eja.jpg', 'deskripsi' => 'Jajanan tradisional yang dikenal juga sebagai Roti Merah. Berwarna merah kecoklatan, bertekstur kenyal, terbuat dari tepung beras dan gula merah, sering diberi *topping* kenari.'],
        ['nama' => 'Te Re', 'gambar' => 'te_re.jpg', 'deskripsi' => 'Kue Te_re atau Kue Jaring. Bertekstur seperti jaring-jaring karena dimasak menggunakan cetakan khusus (ka_daro), memiliki rasa manis dari gula merah cair, dan berwarna kecoklatan.'],
        ['nama' => 'Pemandangan Wiskul', 'gambar' => 'wiskul2.jpg', 'deskripsi' => 'Potret suasana atau pemandangan di sekitar lokasi wisata kuliner Selayar.'],
        ['nama' => 'Wisata Kuliner', 'gambar' => 'wiskul.jpg', 'deskripsi' => 'Potret umum suasana atau hidangan yang disajikan di tempat wisata kuliner Selayar.']
    ];
        return view('kuliner', compact('kuliner'));
    }

    public function galeri()
    {
        $foto = ['bukit_nane.jpg', 'haje.jpg', 'header-selayar.jpg', 'jinato.jpg', 'Kue_Sengkang.jpg','makam_karang.jpg', 'pantai_pinang.jpg', 'roji_eja.jpg', 'te_re.jpg', 'tinabo.jpg','wiskul.jpg', 'wiskul2.jpg'];
        return view('galeri', compact('foto'));
    }

    public function kontak()
    {
        return view('kontak');
    }

    public function kirimPesan(Request $request)
    {
        $nama = $request->input('nama');
        $pesan = $request->input('pesan');

        // Simulasi kirim (tanpa database)
        return back()->with('success', "Terima kasih, $nama! Pesan Anda sudah diterima: \"$pesan\"");
    }
}
