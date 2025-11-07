<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Eksplor Bone') - Pariwisata Nusantara</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                Eksplor Bone
            </a>
            <div class="flex-wrap justify-center mt-4 md:mt-0 space-x-2 md:space-x-4">
                <x-nav-link :route="'home'">Home</x-nav-link>
                <x-nav-link :route="'destinasi'">Destinasi</x-nav-link>
                <x-nav-link :route="'kuliner'">Kuliner</x-nav-link>
                <x-nav-link :route="'galeri'">Galeri</x-nav-link>
                <x-nav-link :route="'kontak'">Kontak</x-nav-link>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-6 py-8 min-h-screen">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-gray-300 p-6 text-center">
        <p>&copy; 2025 - Praktikum Web - Eksplor Pariwisata Kabupaten Bone</p>
    </footer>

</body>
</html>