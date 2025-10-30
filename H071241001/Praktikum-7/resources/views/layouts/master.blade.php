<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Eksplor Medan - Pariwisata Nusantara')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #800020 0%, #a0153e 100%);
        }
        
        .hover-scale {
            transition: transform 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.05);
        }
        
        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 50%;
            background-color: #f59e0b;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            box-shadow: 0 20px 40px rgba(128, 0, 32, 0.2);
            transform: translateY(-5px);
        }
        
        .animate-fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .hero-pattern {
            background-color: #800020;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .text-maroon {
            color: #800020;
        }
        
        .bg-maroon {
            background-color: #800020;
        }
        
        .border-maroon {
            border-color: #800020;
        }
        
        .hover-maroon:hover {
            background-color: #a0153e;
        }
    </style>
</head>
<body class="bg-gray-50">
    
    <header class="hero-pattern shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <nav class="flex items-center justify-between py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="bg-white rounded-full p-2">
                        <i class="fas fa-mountain text-maroon text-2xl"></i>
                    </div>
                    <div class="text-white">
                        <h1 class="text-2xl font-bold">Eksplor Medan</h1>
                        <p class="text-xs" style="color: #f3b0c3;">Pesona Sumatera Utara</p>
                    </div>
                </div>
                
                
                <div class="hidden md:flex space-x-8">
                    <a href="{{ url('/') }}" class="nav-link text-white hover:text-amber-300 font-medium {{ Request::is('/') ? 'active' : '' }}">
                        <i class="fas fa-home mr-1"></i> Home
                    </a>
                    <a href="{{ url('/destinasi') }}" class="nav-link text-white hover:text-amber-300 font-medium {{ Request::is('destinasi') ? 'active' : '' }}">
                        <i class="fas fa-map-marked-alt mr-1"></i> Destinasi
                    </a>
                    <a href="{{ url('/kuliner') }}" class="nav-link text-white hover:text-amber-300 font-medium {{ Request::is('kuliner') ? 'active' : '' }}">
                        <i class="fas fa-utensils mr-1"></i> Kuliner
                    </a>
                    <a href="{{ url('/galeri') }}" class="nav-link text-white hover:text-amber-300 font-medium {{ Request::is('galeri') ? 'active' : '' }}">
                        <i class="fas fa-images mr-1"></i> Galeri
                    </a>
                    <a href="{{ url('/kontak') }}" class="nav-link text-white hover:text-amber-300 font-medium {{ Request::is('kontak') ? 'active' : '' }}">
                        <i class="fas fa-envelope mr-1"></i> Kontak
                    </a>
                </div>
                
                
                <button id="mobile-menu-btn" class="md:hidden text-white">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </nav>
            
          
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-3">
                    <a href="{{ url('/') }}" class="text-white hover:text-amber-300 font-medium py-2">
                        <i class="fas fa-home mr-2"></i> Home
                    </a>
                    <a href="{{ url('/destinasi') }}" class="text-white hover:text-amber-300 font-medium py-2">
                        <i class="fas fa-map-marked-alt mr-2"></i> Destinasi
                    </a>
                    <a href="{{ url('/kuliner') }}" class="text-white hover:text-amber-300 font-medium py-2">
                        <i class="fas fa-utensils mr-2"></i> Kuliner
                    </a>
                    <a href="{{ url('/galeri') }}" class="text-white hover:text-amber-300 font-medium py-2">
                        <i class="fas fa-images mr-2"></i> Galeri
                    </a>
                    <a href="{{ url('/kontak') }}" class="text-white hover:text-amber-300 font-medium py-2">
                        <i class="fas fa-envelope mr-2"></i> Kontak
                    </a>
                </div>
            </div>
        </div>
    </header>

  
    <main class="min-h-screen">
        @yield('content')
    </main>


    <footer class="gradient-bg text-white mt-16">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
           
                <div>
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <i class="fas fa-mountain mr-2"></i> Eksplor Medan
                    </h3>
                    <p class="text-sm" style="color: #f3b0c3;">
                        Portal informasi wisata dan kuliner khas Kota Medan, Sumatera Utara. Jelajahi keindahan dan kekayaan budaya Medan bersama kami.
                    </p>
                </div>
                
             
                <div>
                    <h3 class="text-xl font-bold mb-4">Menu Cepat</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ url('/') }}" class="hover:text-amber-300 transition" style="color: #f3b0c3;">Home</a></li>
                        <li><a href="{{ url('/destinasi') }}" class="hover:text-amber-300 transition" style="color: #f3b0c3;">Destinasi Wisata</a></li>
                        <li><a href="{{ url('/kuliner') }}" class="hover:text-amber-300 transition" style="color: #f3b0c3;">Kuliner Khas</a></li>
                        <li><a href="{{ url('/galeri') }}" class="hover:text-amber-300 transition" style="color: #f3b0c3;">Galeri Foto</a></li>
                    </ul>
                </div>
                
                
                <div>
                    <h3 class="text-xl font-bold mb-4">Kontak</h3>
                    <ul class="space-y-2 text-sm" style="color: #f3b0c3;">
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Medan, Sumatera Utara
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            +62 61 4515441
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            info@eksplormedan.id
                        </li>
                    </ul>
                </div>
                
          
                <div>
                    <h3 class="text-xl font-bold mb-4">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-white text-maroon w-10 h-10 rounded-full flex items-center justify-center hover:bg-amber-300 transition hover-scale">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-white text-maroon w-10 h-10 rounded-full flex items-center justify-center hover:bg-amber-300 transition hover-scale">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="bg-white text-maroon w-10 h-10 rounded-full flex items-center justify-center hover:bg-amber-300 transition hover-scale">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="bg-white text-maroon w-10 h-10 rounded-full flex items-center justify-center hover:bg-amber-300 transition hover-scale">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t mt-8 pt-8 text-center" style="border-color: #c04a62;">
                <p class="text-sm" style="color: #f3b0c3;">
                    &copy; 2025 Eksplor Medan - Pariwisata Nusantara. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

   
    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>