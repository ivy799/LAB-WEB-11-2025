@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold text-sky-800 mb-4">Edit Ikan: {{ $fish->name }}</h1>

<form method="POST" action="{{ route('fishes.update',$fish) }}" class="bg-white p-6 rounded shadow-md space-y-4">
  @csrf
  @method('PUT')

  <div>
    <label class="block font-medium">Nama Ikan</label>
    <input type="text" name="name" value="{{ old('name', $fish->name) }}" class="w-full border rounded px-3 py-2">
  </div>

  <div>
    <label class="block font-medium">Rarity</label>
    <select name="rarity" class="w-full border rounded px-3 py-2">
      @foreach(['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'] as $r)
        <option value="{{ $r }}" {{ $fish->rarity == $r ? 'selected' : '' }}>{{ $r }}</option>
      @endforeach
    </select>
  </div>

  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="block font-medium">Berat Minimum (kg)</label>
      <input type="number" step="0.01" name="base_weight_min" value="{{ old('base_weight_min', $fish->base_weight_min) }}" class="w-full border rounded px-3 py-2">
    </div>
    <div>
      <label class="block font-medium">Berat Maksimum (kg)</label>
      <input type="number" step="0.01" name="base_weight_max" value="{{ old('base_weight_max', $fish->base_weight_max) }}" class="w-full border rounded px-3 py-2">
    </div>
  </div>

  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="block font-medium">Harga Jual /kg</label>
      <input type="number" name="sell_price_per_kg" value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg) }}" class="w-full border rounded px-3 py-2">
    </div>
    <div>
      <label class="block font-medium">Peluang Tangkap (%)</label>
      <input type="number" step="0.01" name="catch_probability" value="{{ old('catch_probability', $fish->catch_probability) }}" class="w-full border rounded px-3 py-2">
    </div>
  </div>

  <div>
    <label class="block font-medium">Deskripsi</label>
    <textarea name="description" class="w-full border rounded px-3 py-2" rows="3">{{ old('description', $fish->description) }}</textarea>
  </div>

  <div class="flex justify-end gap-3">
    <a href="{{ route('fishes.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Batal</a>
    <button type="submit" class="bg-sky-700 text-white px-4 py-2 rounded hover:bg-sky-800">Simpan Perubahan</button>
  </div>
</form>
@endsection
