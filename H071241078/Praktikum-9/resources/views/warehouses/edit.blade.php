@extends('layout')

@section('content')
<h2 class="text-2xl font-bold mb-4">Edit Gudang</h2>

<form action="{{ route('warehouses.update', $warehouse->id) }}" method="POST" class="bg-white shadow p-6 rounded-lg">
  @csrf @method('PUT')
  <div class="mb-3">
    <label class="block font-medium">Nama</label>
    <input type="text" name="name" value="{{ $warehouse->name }}" class="w-full border-gray-300 rounded-lg mt-1" required>
  </div>

  <div class="mb-3">
    <label class="block font-medium">Lokasi</label>
    <textarea name="location" class="w-full border-gray-300 rounded-lg mt-1">{{ $warehouse->location }}</textarea>
  </div>

  <div class="flex space-x-2">
    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Update</button>
    <a href="{{ route('warehouses.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
  </div>
</form>
@endsection
