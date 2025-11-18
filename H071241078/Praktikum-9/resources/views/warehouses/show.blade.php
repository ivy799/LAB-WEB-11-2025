@extends('layout')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-xl p-8 mt-10">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Detail Gudang</h2>

    <div class="mb-4">
        <p class="text-gray-500">Nama Gudang</p>
        <p class="font-semibold text-lg text-gray-800">{{ $warehouse->name }}</p>
    </div>

    <div class="mb-4">
        <p class="text-gray-500">Alamat</p>
        <p class="font-semibold text-lg text-gray-800">{{ $warehouse->address ?? '-' }}</p>
    </div>

    {{-- Tambahkan keterangan waktu --}}
    <div class="mb-6">
        <p class="text-gray-500">Dibuat pada</p>
        <p class="font-semibold text-sm text-gray-600">{{ $warehouse->created_at->format('d M Y, H:i') }}</p>
    </div>

    <div class="mb-6">
        <p class="text-gray-500">Diperbarui pada</p>
        <p class="font-semibold text-sm text-gray-600">{{ $warehouse->updated_at->format('d M Y, H:i') }}</p>
    </div>

    <h3 class="text-xl font-semibold mt-8 mb-4">Daftar Produk di Gudang Ini</h3>

    @if($warehouse->products->count() > 0)
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">Nama Produk</th>
                    <th class="border border-gray-300 px-4 py-2">Jumlah Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach($warehouse->products as $product)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $product->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $product->pivot->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-600">Tidak ada produk di gudang ini.</p>
    @endif

    <div class="mt-8">
        <a href="{{ route('warehouses.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold px-5 py-2 rounded-lg">Kembali</a>
    </div>
</div>
@endsection
