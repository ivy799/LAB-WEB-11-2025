<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Eksplor Palembang')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header & Navigation -->
    <header class="hero-bg shadow-lg">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-white text-2xl font-bold">
                    🏛️ Eksplor Palembang
                </div>
                <div class="hidden md:flex space-x-6">
                    <a href="/" class="text-white hover:text-yellow-300 transition duration-300 font-medium">Home</a>
                    <a href="/destinasi" class="text-white hover:text-yellow-300 transition duration-300 font-medium">Destinasi</a>
                    <a href="/kuliner" class="text-white hover:text-yellow-300 transition duration-300 font-medium">Kuliner</a>
                    <a href="/galeri" class="text-white hover:text-yellow-300 transition duration-300 font-medium">Galeri</a>
                    <a href="/kontak" class="text-white hover:text-yellow-300 transition duration-300 font-medium">Kontak</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-purple-600 text-white py-6 mt-12">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; 2024 Eksplor Palembang. All rights reserved.</p>
            <p class="text-sm text-gray-400 mt-2">Dibuat dengan ❤️ untuk mempromosikan keindahan Palembang</p>
        </div>
    </footer>
</body>
</html>