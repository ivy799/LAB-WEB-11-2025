@extends('layout')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-semibold mb-6">Detail Kategori Produk</h2>

    <div class="mb-4">
        <label class="font-bold block">ID</label>
        <p>{{ $category->id }}</p>
    </div>

    <div class="mb-4">
        <label class="font-bold block">Nama Kategori</label>
        <p>{{ $category->name }}</p>
    </div>

    <div class="mb-4">
        <label class="font-bold block">Deskripsi</label>
        <p>{{ $category->description ?: 'Tidak ada deskripsi.' }}</p>
    </div>

    <div class="mb-4">
        <label class="font-bold block">Dibuat pada</label>
        <p>{{ $category->created_at->format('d M Y, H:i') }}</p>
    </div>

    <div class="mb-6">
        <label class="font-bold block">Diperbarui pada</label>
        <p>{{ $category->updated_at->format('d M Y, H:i') }}</p>
    </div>

    <hr class="my-6" />

    <h3 class="text-xl font-semibold mb-4">Produk terkait kategori ini</h3>

    @if ($category->products->isEmpty())
        <p class="italic text-gray-600">Belum ada produk di kategori ini.</p>
    @else
        <ul class="list-disc list-inside">
            @foreach ($category->products as $product)
                <li>{{ $product->name }}</li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('categories.index') }}" class="inline-block mt-6 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
        Kembali
    </a>
</div>
@endsection
