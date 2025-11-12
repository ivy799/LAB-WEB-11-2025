@extends('layout')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white rounded-lg shadow mt-10">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Daftar Gudang</h2>
    <a href="{{ route('warehouses.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
      Tambah
    </a>
  </div>

  <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
    <thead>
      <tr class="bg-gray-200 text-gray-700 text-left">
        <th class="py-2 px-4 w-16">ID</th>
        <th class="py-2 px-4">Nama</th>
        <th class="py-2 px-4">Lokasi</th>
        <th class="py-2 px-4 w-52 text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($warehouses as $warehouse)
      <tr class="border-t hover:bg-gray-50 transition">
        <td class="py-2 px-4 font-medium text-gray-600">{{ $warehouse->id }}</td>
        <td class="py-2 px-4">{{ $warehouse->name }}</td>
        <td class="py-2 px-4">{{ $warehouse->location ?? '-' }}</td>
        <td class="py-2 px-4 text-center">
          <div class="inline-flex space-x-2 justify-center">
            <a href="{{ route('warehouses.show', $warehouse->id) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm font-medium">
              Detail
            </a>

            <a href="{{ route('warehouses.edit', $warehouse->id) }}" 
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm font-medium">
              Edit
            </a>

            <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" 
                  onsubmit="return confirm('Hapus gudang ini?');" class="inline-block">
              @csrf
              @method('DELETE')
              <button type="submit" 
                      class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm font-medium">
                Hapus
              </button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="4" class="py-3 px-4 text-center text-gray-500">Belum ada data gudang.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
