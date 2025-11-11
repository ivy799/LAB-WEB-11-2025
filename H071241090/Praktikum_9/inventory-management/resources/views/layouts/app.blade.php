<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen">
    <nav class="bg-white shadow mb-6">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <h1 class="text-xl font-bold text-green-600">Inventory Management</h1>
            <div class="space-x-4">
                <a href="{{ route('categories.index') }}" class="hover:text-green-500">Categories</a>
                <a href="{{ route('warehouses.index') }}" class="hover:text-green-500">Warehouses</a>
                <a href="{{ route('products.index') }}" class="hover:text-green-500">Products</a>
                <a href="{{ route('stocks.index') }}" class="hover:text-green-500">Stocks</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>

</html>
