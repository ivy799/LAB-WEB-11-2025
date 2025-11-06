@extends('layouts.app')
@section('title', 'Tambah Ikan')

@section('content')
<div class="min-h-screen py-10 px-6 flex justify-center items-start bg-cover bg-center">
  <div class="max-w-3xl w-full border-4 border-blue-300 rounded-2xl shadow-2xl p-8 
              backdrop-blur-md bg-white/40 
              transform hover:scale-[1.01] transition-all hover:shadow-blue-300">

    <h2 class="text-4xl font-extrabold text-center text-indigo-900 drop-shadow-md mb-8 tracking-widest">
      🐟 Tambah Ikan Baru
    </h2>

    <form method="POST" action="{{ route('fishes.store') }}" class="space-y-6">
        @csrf

        <div>
            <label class="block text-indigo-900 font-extrabold mb-1 uppercase tracking-wide">Nama Ikan</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full border-2 rounded-lg px-4 py-3 bg-white/40 backdrop-blur-sm font-semibold text-gray-800 
                       focus:ring-4 focus:ring-blue-300 focus:outline-none transition-all
                       @error('name') border-red-500 ring-2 ring-red-300 bg-red-50 @else border-blue-400 hover:border-indigo-500 @enderror">
            @error('name')<p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-indigo-900 font-extrabold mb-1 uppercase tracking-wide">Rarity</label>
            <select name="rarity"
                class="w-full border-2 rounded-lg px-4 py-3 bg-white/40 backdrop-blur-sm font-semibold text-gray-800
                       focus:ring-4 focus:ring-blue-300 focus:outline-none transition-all
                       @error('rarity') border-red-500 ring-2 ring-red-300 bg-red-50 @else border-blue-400 hover:border-indigo-500 @enderror">
                <option value="">-- Pilih Rarity --</option>
                @foreach(['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'] as $r)
                    <option value="{{ $r }}" {{ old('rarity')==$r ? 'selected' : '' }}>
                        {{ $r }}
                    </option>
                @endforeach
            </select>
            @error('rarity')<p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-indigo-900 font-extrabold mb-1 uppercase tracking-wide">Berat Minimum (kg)</label>
                <input type="number" step="0.01" name="base_weight_min" value="{{ old('base_weight_min') }}"
                    class="w-full border-2 rounded-lg px-4 py-3 bg-white/40 backdrop-blur-sm font-semibold text-gray-800
                           focus:ring-4 focus:ring-blue-300 focus:outline-none transition-all
                           @error('base_weight_min') border-red-500 ring-2 ring-red-300 bg-red-50 @else border-blue-400 hover:border-indigo-500 @enderror">
                @error('base_weight_min')<p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-indigo-900 font-extrabold mb-1 uppercase tracking-wide">Berat Maksimum (kg)</label>
                <input type="number" step="0.01" name="base_weight_max" value="{{ old('base_weight_max') }}"
                    class="w-full border-2 rounded-lg px-4 py-3 bg-white/40 backdrop-blur-sm font-semibold text-gray-800
                           focus:ring-4 focus:ring-blue-300 focus:outline-none transition-all
                           @error('base_weight_max') border-red-500 ring-2 ring-red-300 bg-red-50 @else border-blue-400 hover:border-indigo-500 @enderror">
                @error('base_weight_max')<p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="block text-indigo-900 font-extrabold mb-1 uppercase tracking-wide">Harga per Kg</label>
            <input type="number" name="sell_price_per_kg" value="{{ old('sell_price_per_kg') }}"
                class="w-full border-2 rounded-lg px-4 py-3 bg-white/40 backdrop-blur-sm font-semibold text-gray-800
                       focus:ring-4 focus:ring-blue-300 focus:outline-none transition-all
                       @error('sell_price_per_kg') border-red-500 ring-2 ring-red-300 bg-red-50 @else border-blue-400 hover:border-indigo-500 @enderror">
            @error('sell_price_per_kg')<p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-indigo-900 font-extrabold mb-1 uppercase tracking-wide">Peluang Tertangkap (%)</label>
            <input type="number" step="0.01" name="catch_probability" value="{{ old('catch_probability') }}"
                class="w-full border-2 rounded-lg px-4 py-3 bg-white/40 backdrop-blur-sm font-semibold text-gray-800
                       focus:ring-4 focus:ring-blue-300 focus:outline-none transition-all
                       @error('catch_probability') border-red-500 ring-2 ring-red-300 bg-red-50 @else border-blue-400 hover:border-indigo-500 @enderror">
            @error('catch_probability')<p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-indigo-900 font-extrabold mb-1 uppercase tracking-wide">Deskripsi</label>
            <textarea name="description" rows="4"
                class="w-full border-2 rounded-lg px-4 py-3 bg-white/40 backdrop-blur-sm font-semibold text-gray-800
                       focus:ring-4 focus:ring-blue-300 focus:outline-none transition-all
                       @error('description') border-red-500 ring-2 ring-red-300 bg-red-50 @else border-blue-400 hover:border-indigo-500 @enderror">{{ old('description') }}</textarea>
            @error('description')<p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-between pt-6">
            <a href="{{ route('fishes.index') }}"
                class="bg-blue-200 hover:bg-blue-500 border-2 border-blue-600 text-gray-900 font-extrabold px-6 py-3 rounded-lg shadow-lg transform hover:scale-105 transition-all">
                ⬅ Kembali
            </a>
            <button type="submit"
                class="bg-purple-200 hover:bg-purple-600 border-2 border-purple-700 text-black font-extrabold px-6 py-3 rounded-lg shadow-lg transform hover:scale-105 transition-all">
                Simpan
            </button>
        </div>
    </form>
  </div>
</div>
@endsection
