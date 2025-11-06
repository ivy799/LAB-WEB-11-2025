@extends('layouts.master')

@section('title', 'Kontak - Eksplor Palembang')

@section('content')
<div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white py-16">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl font-bold mb-4">Hubungi Kami</h1>
        <p class="text-xl">Punya pertanyaan? Jangan ragu untuk menghubungi kami!</p>
    </div>
</div>

<div class="container mx-auto px-6 py-16">
    <div class="grid md:grid-cols-2 gap-12">
        <!-- Form Kontak -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Kirim Pesan</h2>
            <form>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" placeholder="Masukkan nama Anda">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="email">Email</label>
                    <input type="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" placeholder="email@example.com">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="telepon">Nomor Telepon</label>
                    <input type="tel" id="telepon" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" placeholder="08xx-xxxx-xxxx">
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2" for="pesan">Pesan</label>
                    <textarea id="pesan" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" placeholder="Tulis pesan Anda di sini..."></textarea>
                </div>
                
                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-lg transition duration-300">
                    Kirim Pesan
                </button>
            </form>
        </div>
        
        <!-- Informasi Kontak -->
        <div>
            <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Kontak</h2>
                
                <div class="mb-6">
                    <div class="flex items-start mb-4">
                        <div class="text-purple-600 text-2xl mr-4">📍</div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Alamat</h3>
                            <p class="text-gray-600">Jl. Jenderal Sudirman No. 123<br>Palembang, Sumatera Selatan 30126</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start mb-4">
                        <div class="text-purple-600 text-2xl mr-4">📞</div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Telepon</h3>
                            <p class="text-gray-600">+62 711 123456<br>+62 812 3456 7890</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start mb-4">
                        <div class="text-purple-600 text-2xl mr-4">✉️</div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Email</h3>
                            <p class="text-gray-600">info@eksplorpalembang.com<br>support@eksplorpalembang.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="text-purple-600 text-2xl mr-4">⏰</div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Jam Operasional</h3>
                            <p class="text-gray-600">Senin - Jumat: 08.00 - 17.00 WIB<br>Sabtu - Minggu: 09.00 - 15.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Media Sosial</h3>
                <div class="flex space-x-4">
                    <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Facebook</a>
                    <a href="#" class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition">Instagram</a>
                    <a href="#" class="bg-blue-400 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition">Twitter</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection