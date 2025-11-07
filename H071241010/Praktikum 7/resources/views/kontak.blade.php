@extends('layouts.master')

@section('title', 'Kontak Kami')

@section('content')
    <h1 class="text-4xl font-bold text-gray-800 text-center mb-10">Hubungi Kami</h1>

    <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

            <div>
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Informasi Kontak</h2>
                <p class="text-gray-700 mb-3">
                    Jika Anda memiliki pertanyaan lebih lanjut mengenai pariwisata di Kabupaten Bone, jangan ragu untuk menghubungi kami.
                </p>
                <p class="text-gray-700 mb-2">
                    <strong>Email:</strong> info.pariwisata@bone.go.id
                </p>
                <p class="text-gray-700 mb-2">
                    <strong>Telepon:</strong> (0481) 123-456
                </p>
                <p class="text-gray-700">
                    <strong>Alamat:</strong> Jl. Pariwisata No. 1, Watampone, Kab. Bone, Sulawesi Selatan.
                </p>
            </div>

            <div>
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Kirim Pesan</h2>
                <form action="#" method="POST">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Anda</label>
                        <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block text-gray-700 font-semibold mb-2">Pesan</label>
                        <textarea id="message" name="message" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                        Kirim (Tidak Berfungsi)
                    </button>
                </form>
            </div>

        </div>
    </div>
@endsection