<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksplor Pariwisata Selayar</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="navbar">
        <h1 class="logo">Eksplor Pariwisata Selayar</h1>
        <nav>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="/destinasi">Destinasi</a></li>
                <li><a href="/kuliner">Kuliner</a></li>
                <li><a href="/galeri">Galeri</a></li>
                <li><a href="/kontak">Kontak</a></li>
            </ul>
        </nav>
    </header>

    <main class="content">
        @yield('content')
    </main>

    <footer class="footer">
        <p>© 2025 Eksplor Pariwisata Selayar. Semua hak cipta dilindungi.</p>
    </footer>
</body>
</html>