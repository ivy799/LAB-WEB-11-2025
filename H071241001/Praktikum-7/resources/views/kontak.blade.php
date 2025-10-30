@extends('layouts.master')

@section('title', 'Hubungi Kami - Eksplor Medan')

@section('content')
<!-- Hero Section -->
<section class="hero-pattern py-20">
    <div class="container mx-auto px-4 text-center text-white">
        <div class="animate-fade-in">
            <i class="fas fa-envelope text-6xl mb-6"></i>
            <h1 class="text-5xl font-bold mb-4">{{ $title }}</h1>
            <p class="text-xl max-w-2xl mx-auto" style="color: #f3b0c3;">
                Ada pertanyaan atau butuh informasi lebih lanjut? Jangan ragu untuk menghubungi kami
            </p>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<section class="bg-gray-100 py-4">
    <div class="container mx-auto px-4">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ url('/') }}" class="hover:text-red-900">Home</a>
            <i class="fas fa-chevron-right mx-2 text-xs"></i>
            <span class="font-semibold" style="color: #800020;">Kontak</span>
        </div>
    </div>
</section>

<!-- Contact Info & Form -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12">
            <!-- Contact Information -->
            <div class="animate-fade-in">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Informasi Kontak</h2>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Kami siap membantu Anda merencanakan perjalanan wisata ke Medan. Hubungi kami melalui berbagai channel yang tersedia.
                </p>
                
                <!-- Contact Cards -->
                <div class="space-y-4">
                    <div class="bg-white rounded-xl shadow-lg p-6 flex items-start hover:shadow-xl transition duration-300">
                        <div class="rounded-full p-4 mr-4" style="background-color: #fce4ec;">
                            <i class="fas fa-map-marker-alt text-2xl" style="color: #800020;"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 mb-2">Alamat</h3>
                            <p class="text-gray-600">{{ $contact_info['address'] }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-lg p-6 flex items-start hover:shadow-xl transition duration-300">
                        <div class="rounded-full p-4 mr-4" style="background-color: #fce4ec;">
                            <i class="fas fa-phone text-2xl" style="color: #800020;"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 mb-2">Telepon</h3>
                            <p class="text-gray-600">{{ $contact_info['phone'] }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-lg p-6 flex items-start hover:shadow-xl transition duration-300">
                        <div class="rounded-full p-4 mr-4" style="background-color: #fce4ec;">
                            <i class="fas fa-envelope text-2xl" style="color: #800020;"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 mb-2">Email</h3>
                            <p class="text-gray-600">{{ $contact_info['email'] }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-lg p-6 flex items-start hover:shadow-xl transition duration-300">
                        <div class="rounded-full p-4 mr-4" style="background-color: #fce4ec;">
                            <i class="fas fa-clock text-2xl" style="color: #800020;"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 mb-2">Jam Operasional</h3>
                            <p class="text-gray-600">Senin - Jumat: 08:00 - 17:00 WIB</p>
                            <p class="text-gray-600">Sabtu: 08:00 - 14:00 WIB</p>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div class="mt-8">
                    <h3 class="font-bold text-gray-800 mb-4">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-white w-12 h-12 rounded-full flex items-center justify-center hover:shadow-lg transform hover:-translate-y-1 transition duration-300" style="background: linear-gradient(135deg, #800020 0%, #a0153e 100%);">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="bg-blue-400 text-white w-12 h-12 rounded-full flex items-center justify-center hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="bg-red-600 text-white w-12 h-12 rounded-full flex items-center justify-center hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                    <div class="mt-4 space-y-1">
                        <p class="text-gray-600 text-sm"><i class="fab fa-instagram mr-2" style="color: #800020;"></i>{{ $contact_info['social']['instagram'] }}</p>
                        <p class="text-gray-600 text-sm"><i class="fab fa-facebook mr-2 text-blue-600"></i>{{ $contact_info['social']['facebook'] }}</p>
                        <p class="text-gray-600 text-sm"><i class="fab fa-twitter mr-2 text-blue-400"></i>{{ $contact_info['social']['twitter'] }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="animate-fade-in">
                <div class="rounded-2xl shadow-xl p-8" style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%);">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Kirim Pesan</h2>
                    <form class="space-y-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                            <input type="text" placeholder="Masukkan nama lengkap Anda" class="w-full px-4 py-3 rounded-lg border border-gray-300 transition duration-300 outline-none" style="focus:border-color: #800020;">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Email</label>
                            <input type="email" placeholder="contoh@email.com" class="w-full px-4 py-3 rounded-lg border border-gray-300 transition duration-300 outline-none">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
                            <input type="tel" placeholder="+62 812 3456 7890" class="w-full px-4 py-3 rounded-lg border border-gray-300 transition duration-300 outline-none">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Subjek</label>
                            <select class="w-full px-4 py-3 rounded-lg border border-gray-300 transition duration-300 outline-none">
                                <option value="">Pilih Subjek</option>
                                <option value="informasi">Informasi Wisata</option>
                                <option value="paket">Paket Wisata</option>
                                <option value="kuliner">Rekomendasi Kuliner</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Pesan</label>
                            <textarea rows="5" placeholder="Tulis pesan Anda di sini..." class="w-full px-4 py-3 rounded-lg border border-gray-300 transition duration-300 outline-none resize-none"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full text-white font-semibold py-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300" style="background: linear-gradient(135deg, #800020 0%, #a0153e 100%);">
                            <i class="fas fa-paper-plane mr-2"></i>Kirim Pesan
                        </button>
                    </form>
                    
                    <p class="text-gray-600 text-sm mt-4 text-center">
                        <i class="fas fa-lock mr-1"></i>Data Anda aman dan terlindungi
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Lokasi Kami</h2>
            <p class="text-gray-600 text-lg">Temukan kami di pusat Kota Medan</p>
        </div>
        
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="aspect-w-16 aspect-h-9">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.0574415268697!2d98.67279931475725!3d3.5878573973096807!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30312fda7cbf97d3%3A0x2dd0f29152c80c51!2sMedan%20City%20Hall!5e0!3m2!1sen!2sid!4v1635000000000!5m2!1sen!2sid" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy"
                    class="w-full">
                </iframe>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-gray-600 text-lg">Temukan jawaban untuk pertanyaan umum Anda</p>
            </div>
            
            <div class="space-y-4">
                <div class="rounded-xl p-6 hover:shadow-lg transition duration-300" style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%);">
                    <h3 class="font-bold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-question-circle mr-3" style="color: #800020;"></i>
                        Apa waktu terbaik untuk mengunjungi Medan?
                    </h3>
                    <p class="text-gray-600 ml-9">Waktu terbaik adalah Juni-Agustus saat cuaca lebih cerah dan tidak banyak hujan.</p>
                </div>
                
                <div class="rounded-xl p-6 hover:shadow-lg transition duration-300" style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%);">
                    <h3 class="font-bold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-question-circle mr-3" style="color: #800020;"></i>
                        Bagaimana cara transportasi di Medan?
                    </h3>
                    <p class="text-gray-600 ml-9">Anda bisa menggunakan ojek online (Gojek/Grab), taksi, atau rental mobil untuk mobilitas yang lebih mudah.</p>
                </div>
                
                <div class="rounded-xl p-6 hover:shadow-lg transition duration-300" style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%);">
                    <h3 class="font-bold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-question-circle mr-3" style="color: #800020;"></i>
                        Apakah ada paket wisata yang tersedia?
                    </h3>
                    <p class="text-gray-600 ml-9">Ya, kami menyediakan berbagai paket wisata. Silakan hubungi kami untuk informasi lebih detail.</p>
                </div>
                
                <div class="rounded-xl p-6 hover:shadow-lg transition duration-300" style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%);">
                    <h3 class="font-bold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-question-circle mr-3" style="color: #800020;"></i>
                        Dimana tempat kuliner terbaik di Medan?
                    </h3>
                    <p class="text-gray-600 ml-9">Cek halaman Kuliner kami untuk rekomendasi lengkap tempat makan terbaik di Medan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="rounded-2xl shadow-2xl p-8 md:p-12 text-center text-white" style="background: linear-gradient(135deg, #800020 0%, #a0153e 100%);">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Mulai Petualangan Anda</h2>
            <p class="text-lg mb-8 max-w-2xl mx-auto" style="color: #f3b0c3;">
                Jangan tunda lagi! Jelajahi keindahan Medan dan ciptakan kenangan tak terlupakan
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ url('/destinasi') }}" class="inline-block bg-white font-semibold px-8 py-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300" style="color: #800020;">
                    <i class="fas fa-map-marked-alt mr-2"></i>Lihat Destinasi
                </a>
                <a href="{{ url('/kuliner') }}" class="inline-block bg-amber-500 text-white font-semibold px-8 py-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                    <i class="fas fa-utensils mr-2"></i>Cicipi Kuliner
                </a>
            </div>
        </div>
    </div>
</section>
@endsection