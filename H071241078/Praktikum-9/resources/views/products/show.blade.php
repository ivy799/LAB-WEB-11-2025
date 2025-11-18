@extends('layout')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-xl p-8 mt-10">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Detail Produk</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <p class="text-gray-500">Nama Produk</p>
            <p class="font-semibold text-lg text-gray-800">{{ $product->name }}</p>
        </div>

        <div>
            <p class="text-gray-500">Kategori</p>
            <p class="font-semibold text-lg text-gray-800">{{ $product->category->name ?? '-' }}</p>
        </div>

        <div>
            <p class="text-gray-500">Harga</p>
            <p class="font-semibold text-lg text-green-700">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        </div>

        <div>
            <p class="text-gray-500">Dibuat pada</p>
            <p class="font-semibold text-lg text-gray-800">{{ $product->created_at->format('d M Y') }}</p>
        </div>
    </div>


    <div class="mt-6 border-t pt-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-3">Detail Produk</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-500">Deskripsi</p>
                <p class="text-gray-800">{{ $product->detail->description ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Berat</p>
                <p class="text-gray-800">{{ $product->detail->weight ?? '-' }} Kg</p>
            </div>

            <div>
                <p class="text-gray-500">Ukuran</p>
                <p class="text-gray-800">{{ $product->detail->size ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="mt-8 border-t pt-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-3">Stok per Gudang</h3>

        @if($product->warehouses->count() > 0)
        <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-left">
                    <th class="py-3 px-4 font-semibold">Nama Gudang</th>
                    <th class="py-3 px-4 font-semibold">Jumlah Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach($product->warehouses as $warehouse)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="py-2 px-4">{{ $warehouse->name }}</td>
                        <td class="py-2 px-4">{{ $warehouse->pivot->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p class="text-gray-600">Belum ada stok untuk produk ini di gudang manapun.</p>
        @endif
    </div>

    <div class="mt-8 flex space-x-3">
        <a href="{{ route('products.edit', $product->id) }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-5 py-2 rounded-lg">
            Edit
        </a>
        <a href="{{ route('products.index') }}"
           class="bg-gray-400 hover:bg-gray-500 text-white font-semibold px-5 py-2 rounded-lg">
            Kembali
        </a>
    </div>
</div>
@endsection
