@extends('layout')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-semibold mb-6">Daftar Kategori</h2>

    <a href="{{ route('categories.create') }}" 
       class="mb-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
       Tambah Kategori
    </a>

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">Nama Kategori</th>
                <th class="border border-gray-300 px-4 py-2">Deskripsi</th>
                <th class="border border-gray-300 px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td class="border border-gray-300 px-4 py-2 text-center">{{ $category->id }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $category->name }}</td>
                <td class="border border-gray-300 px-4 py-2">
                    {{ $category->description ?: '-' }}
                </td>
                <td class="border border-gray-300 px-4 py-2 text-center">
                    <a href="{{ route('categories.show', $category->id) }}" class="text-blue-600 hover:underline mr-2">Detail</a>
                    <a href="{{ route('categories.edit', $category->id) }}" class="text-yellow-600 hover:underline mr-2">Edit</a>

                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection
