@extends('layout')

@section('content')
<h2 class="text-2xl font-bold mb-4">Edit Kategori</h2>

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form action="{{ route('categories.update', $category->id) }}" method="POST" class="bg-white shadow p-6 rounded-lg">
  @csrf @method('PUT')
  <div class="mb-3">
    <label class="block font-medium">Nama</label>
    <input type="text" name="name" value="{{ $category->name }}" class="w-full border-gray-300 rounded-lg mt-1" required>
  </div>

  <div class="mb-3">
    <label class="block font-medium">Deskripsi</label>
    <textarea name="description" class="w-full border-gray-300 rounded-lg mt-1">{{ $category->description }}</textarea>
  </div>

  <div class="flex space-x-2">
    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Update</button>
    <a href="{{ route('categories.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
  </div>
</form>
@endsection
