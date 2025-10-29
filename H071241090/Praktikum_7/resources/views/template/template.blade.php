<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Tambahkan link Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">
    <header class="bg-teal-700 text-white p-4">
        <div class="flex justify-between items-center p-4">
            <h1 class="text-2xl font-bold">Eksplor Bandung</h1>
            <nav class="mt-2">
                <a href="/" class="px-3 hover:underline">Beranda</a>
                <a href="/destinasi" class="px-3 hover:underline">Destinasi</a>
                <a href="/kuliner" class="px-3 hover:underline">Kuliner</a>
                <a href="/galeri" class="px-3 hover:underline">Galeri</a>
                <a href="/kontak" class="px-3 hover:underline">Kontak</a>
            </nav>
        </div>
    </header>

    <main class="p-6">
        @yield('content')
    </main>

    <footer class="bg-gray-200 text-center p-6 mt-6">
        <p>&copy; {{ date('Y') }} Eksplor Bandung</p>
    </footer>
</body>

</html>
