@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow-md">
  <h1 class="text-2xl font-bold text-sky-800 mb-3">{{ $fish->name }}</h1>

  <div class="space-y-2">
    <p><span class="font-semibold">Rarity:</span> {{ $fish->rarity }}</p>
    <p><span class="font-semibold">Berat:</span> {{ $fish->base_weight_min }} - {{ $fish->base_weight_max }} kg</p>
    <p><span class="font-semibold">Harga /kg:</span> {{ $fish->formatted_price ?? $fish->sell_price_per_kg }}</p>
    <p><span class="font-semibold">Peluang Tangkap:</span> {{ $fish->catch_probability }}%</p>
    <p><span class="font-semibold">Deskripsi:</span> {{ $fish->description ?? '-' }}</p>
  </div>

  <div class="flex justify-end mt-6 gap-3">
    <a href="{{ route('fishes.edit',$fish) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
    <form action="{{ route('fishes.destroy',$fish) }}" method="POST">
      @csrf @method('DELETE')
      <button onclick="return confirm('Hapus ikan ini?')" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Hapus</button>
    </form>
    <a href="{{ route('fishes.index') }}" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Kembali</a>
  </div>
</div>
@endsection
