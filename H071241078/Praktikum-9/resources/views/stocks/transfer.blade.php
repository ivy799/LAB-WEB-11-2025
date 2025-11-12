@extends('layout')

@section('content')
<h2 class="text-2xl font-bold mb-6">Transfer Stok Produk</h2>

@if ($errors->any())
  <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
    <p>{{ $errors->first() }}</p>
  </div>
@endif

<form action="{{ route('stocks.transfer.process') }}" method="POST" class="bg-white shadow p-6 rounded-lg space-y-5">
  @csrf

  <div>
    <label class="block font-medium text-gray-700">Gudang</label>
    <select name="warehouse_id" 
            class="w-full border-gray-300 rounded-lg mt-1 focus:ring-indigo-500 focus:border-indigo-500 @error('warehouse_id') border-red-500 @enderror" 
            required>
      <option value="">-- Pilih Gudang --</option>
      @foreach($warehouses as $w)
        <option value="{{ $w->id }}" {{ old('warehouse_id') == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
      @endforeach
    </select>

    @error('warehouse_id')
      @if ($message !== $errors->first())
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @endif
    @enderror
  </div>

  <div>
    <label class="block font-medium text-gray-700">Produk</label>
    <select name="product_id" 
            class="w-full border-gray-300 rounded-lg mt-1 focus:ring-indigo-500 focus:border-indigo-500 @error('product_id') border-red-500 @enderror" 
            required>
      <option value="">-- Pilih Produk --</option>
      @foreach($products as $p)
        <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
      @endforeach
    </select>
    @error('product_id')
      @if ($message !== $errors->first())
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @endif
    @enderror
  </div>

  <div>
    <label class="block font-medium text-gray-700">Jumlah (+ / -)</label>
    <input 
      type="number" 
      name="quantity" 
      value="{{ old('quantity') }}"
      class="w-full border-gray-300 rounded-lg mt-1 focus:ring-indigo-500 focus:border-indigo-500 @error('quantity') border-red-500 @enderror" 
      placeholder="Contoh: 10 atau -5" 
      required
    >
    <p class="text-sm text-gray-500 mt-1">Gunakan angka negatif untuk mengurangi stok. Contoh: -3</p>
    @error('quantity')
      @if ($message !== $errors->first())
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @endif
    @enderror
  </div>

  <div class="flex space-x-3">
    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow">
      Simpan
    </button>
    <a href="{{ route('stocks.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-lg shadow">
      Kembali
    </a>
  </div>
</form>
@endsection
