@extends('layout')

@section('content')
<h2 class="text-2xl font-bold mb-4">Tambah Kategori</h2>

<form action="{{ route('categories.store') }}" method="POST" class="bg-white shadow p-6 rounded-lg">
  @csrf
  <div class="mb-3">
    <label class="block font-medium">Nama</label>
    <input type="text" 
           name="name" 
           value="{{ old('name') }}" 
           class="w-full border-gray-300 rounded-lg mt-1 @error('name') border-red-500 @enderror"
           required>
    @error('name')
      <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div class="mb-3">
    <label class="block font-medium">Deskripsi</label>
    <textarea name="description" 
              class="w-full border-gray-300 rounded-lg mt-1">{{ old('description') }}</textarea>
  </div>

  <div class="flex space-x-2">
    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Simpan</button>
    <a href="{{ route('categories.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
  </div>
</form>
@endsection
