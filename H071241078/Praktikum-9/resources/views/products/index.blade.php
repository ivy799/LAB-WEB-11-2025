@extends('layout')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white rounded-xl shadow-md p-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Produk</h2>
        <a href="{{ route('products.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-lg shadow-sm">
            Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($products->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-left">
                    <th class="py-3 px-4 font-semibold w-20">ID</th>
                    <th class="py-3 px-4 font-semibold">Nama</th>
                    <th class="py-3 px-4 font-semibold">Kategori</th>
                    <th class="py-3 px-4 font-semibold">Harga</th>
                    <th class="py-3 px-4 font-semibold text-center w-48">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="py-2 px-4 text-gray-700 font-medium">{{ $product->id }}</td>
                        <td class="py-2 px-4">{{ $product->name }}</td>
                        <td class="py-2 px-4">{{ $product->category->name ?? '-' }}</td>
                        <td class="py-2 px-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="py-2 px-4 text-center space-x-2">
                            <a href="{{ route('products.show', $product->id) }}"
                               class="text-blue-600 hover:text-blue-800 font-medium">Detail</a>
                            <a href="{{ route('products.edit', $product->id) }}"
                               class="text-yellow-600 hover:text-yellow-700 font-medium">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Yakin ingin menghapus produk ini?')"
                                    class="text-red-600 hover:text-red-800 font-medium">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p class="text-gray-600 text-center py-6">Belum ada produk yang ditambahkan.</p>
    @endif
</div>
@endsection
