<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fish It Roblox 🎣</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-sky-50 text-gray-800 min-h-screen flex flex-col">
  <nav class="bg-sky-700 text-white py-4 shadow-md">
    <div class="container mx-auto px-6 flex justify-between items-center">
      <a href="{{ route('fishes.index') }}" class="text-xl font-semibold">🐟 Fish It Roblox</a>
      <a href="{{ route('fishes.create') }}" class="bg-white text-sky-700 font-semibold py-1 px-3 rounded hover:bg-sky-100">
        + Tambah Ikan
      </a>
    </div>
  </nav>

  <main class="flex-grow container mx-auto px-6 py-6">
    @if(session('success'))
      <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
        {{ session('success') }}
      </div>
    @endif

    @yield('content')
  </main>

  <footer class="bg-sky-700 text-white text-center py-3 text-sm">
    &copy; {{ date('Y') }} Fish It Roblox Simulator
  </footer>
</body>

</html>
