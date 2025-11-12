<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Produk</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen">

  <nav class="bg-indigo-600 text-white shadow mb-6">
    <div class="container mx-auto px-6 py-3 flex justify-between items-center">
      <a href="{{ route('products.index') }}" class="font-bold text-xl">Sistem Produk</a>
      <div class="space-x-4">
        <a href="{{ route('categories.index') }}" class="hover:text-gray-200">Kategori</a>
        <a href="{{ route('warehouses.index') }}" class="hover:text-gray-200">Gudang</a>
        <a href="{{ route('products.index') }}" class="hover:text-gray-200">Produk</a>
        <a href="{{ route('stocks.index') }}" class="hover:text-gray-200">Stok</a>
      </div>
    </div>
  </nav>

  <div class="container mx-auto px-6 pb-12">
    @if(session('success'))
      <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
      </div>
    @endif

    @yield('content')
  </div>

</body>
</html>
