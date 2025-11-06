@extends('template.template')

@section('title', 'Kontak')

@section('content')
    <div class="text-center mb-12">
        <h2 class="text-4xl font-extrabold mb-4 text-teal-800">Hubungi Kami</h2>
        <p class="text-gray-700 max-w-2xl mx-auto">
            Ada pertanyaan, saran, atau ingin berbagi pengalaman tentang Bandung?  
            Silakan kirim pesanmu melalui form di bawah ini.
        </p>
    </div>

    <form action="#" method="POST" class="max-w-lg mx-auto bg-white shadow rounded-2xl p-8">
        @csrf
        <div class="mb-4">
            <label for="nama" class="block text-left font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" class="w-full border border-gray-300 rounded-lg p-3 mt-2 focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="Masukkan namamu">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-left font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded-lg p-3 mt-2 focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="Masukkan emailmu">
        </div>

        <div class="mb-6">
            <label for="pesan" class="block text-left font-medium text-gray-700">Pesan</label>
            <textarea id="pesan" name="pesan" rows="4" class="w-full border border-gray-300 rounded-lg p-3 mt-2 focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="Tulis pesanmu di sini..."></textarea>
        </div>

        <button type="submit" class="w-full bg-teal-700 text-white py-3 rounded-lg font-semibold hover:bg-teal-800 transition">
            Kirim Pesan
        </button>
    </form>

    <div class="text-center mt-12">
        <a href="/" class="inline-block bg-gray-200 text-teal-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-300 transition">
            ← Kembali ke Beranda
        </a>
    </div>
@endsection
