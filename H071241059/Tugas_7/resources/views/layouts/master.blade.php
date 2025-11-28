<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pesona Bumi Latemmamala')</title>
    <style>
        :root {
            /* Tema Hijau (Alam/Lejja) & Emas (Sejarah) */
            --primary-color: #2d6a4f; /* Forest Green */
            --secondary-color: #52b788; /* Light Green */
            --text-color: #333;
            --background-light: #f1f8f5; /* Very light green tint */
            --accent-color: #d4a373; /* Earthy Gold */
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: var(--background-light);
            color: var(--text-color);
            line-height: 1.6;
        }
        .header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px 5%;
            box-shadow: 0 4px 6px rgba(0,0,0,0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            font-size: 1.8em;
            margin: 0;
            font-weight: 700;
        }
        .nav-menu a {
            color: white;
            margin-left: 25px;
            text-decoration: none;
            font-weight: 600;
            padding: 5px 0;
            transition: color 0.3s ease, border-bottom 0.3s ease;
        }
        .nav-menu a:hover {
            color: var(--accent-color);
            border-bottom: 2px solid var(--accent-color);
        }
        .container {
            padding: 40px 5%;
            min-height: 75vh;
            max-width: 1200px;
            margin: 0 auto;
        }
        .footer {
            background-color: #1b4332; /* Darker Green */
            color: #d8f3dc;
            text-align: center;
            padding: 25px 0;
            font-size: 0.9em;
            margin-top: auto;
        }
        h2 {
            color: var(--primary-color);
            border-bottom: 3px solid var(--accent-color);
            padding-bottom: 10px;
            margin-bottom: 30px;
            display: inline-block;
        }
        /* Utility class untuk teks tengah agar tidak berulang di setiap view */
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <header class="header">
        <h1>Visit Soppeng</h1>
        <nav class="nav-menu">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('/destinasi') }}">Destinasi</a>
            <a href="{{ url('/kuliner') }}">Kuliner</a>
            <a href="{{ url('/galeri') }}">Galeri</a>
            <a href="{{ url('/kontak') }}">Kontak</a>
        </nav>
    </header>

    <div class="container">
        @yield('content')
    </div>

    <footer class="footer">
        &copy; {{ date('Y') }} Dinas Pariwisata Kabupaten Soppeng. Menjelajahi Kota Kalong.
    </footer>

</body>
</html>
