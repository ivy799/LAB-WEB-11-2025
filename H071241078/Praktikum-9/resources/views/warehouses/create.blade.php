@extends('layout')

@section('content')
<h2 class="text-2xl font-bold mb-4">Tambah Gudang</h2>

<form action="{{ route('warehouses.store') }}" method="POST" class="bg-white shadow p-6 rounded-lg">
  @csrf
  <div class="mb-3">
    <label class="block font-medium">Nama</label>
    <input type="text" name="name" class="w-full border-gray-300 rounded-lg mt-1" required>
  </div>

  <div class="mb-3">
    <label class="block font-medium">Lokasi</label>
    <textarea name="location" class="w-full border-gray-300 rounded-lg mt-1"></textarea>
  </div>

  <div class="flex space-x-2">
    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Simpan</button>
    <a href="{{ route('warehouses.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
  </div>
</form>
@endsection
