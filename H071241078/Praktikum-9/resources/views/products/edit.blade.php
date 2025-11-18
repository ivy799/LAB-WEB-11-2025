@extends('layout')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md p-8 mt-10">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Produk</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')
        <div>
            <label class="block font-semibold text-gray-700">Nama Produk</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                   class="w-full border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg mt-1"
                   required>
        </div>

        <div>
            <label class="block font-semibold text-gray-700">Kategori</label>
            <select name="category_id"
                    class="w-full border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg mt-1" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold text-gray-700">Harga (Rp)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                   class="w-full border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg mt-1"
                   required>
        </div>

        <div>
            <label class="block font-semibold text-gray-700">Deskripsi</label>
            <textarea name="description" rows="3"
                      class="w-full border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg mt-1"
                      placeholder="Tuliskan deskripsi produk">{{ old('description', $product->detail->description ?? '') }}</textarea>
        </div>

        <div>
            <label class="block font-semibold text-gray-700">Berat (kg)</label>
            <input type="number" step="0.01" name="weight"
                   value="{{ old('weight', $product->detail->weight ?? '') }}"
                   class="w-full border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg mt-1"
                   required>
        </div>

        <div>
            <label class="block font-semibold text-gray-700">Ukuran</label>
            <input type="text" name="size"
                   value="{{ old('size', $product->detail->size ?? '') }}"
                   class="w-full border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg mt-1"
                   placeholder="Contoh: 15 inch">
        </div>

        <div class="flex space-x-3 pt-4">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg">
                Update
            </button>
            <a href="{{ route('products.index') }}"
               class="bg-gray-400 hover:bg-gray-500 text-white font-semibold px-5 py-2 rounded-lg">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection
