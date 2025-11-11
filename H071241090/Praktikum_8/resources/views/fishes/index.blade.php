@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
  <h1 class="text-2xl font-bold text-sky-800">Daftar Ikan</h1>
</div>

<form method="GET" class="flex flex-wrap gap-3 mb-5">
  <select name="rarity" class="border border-gray-300 rounded px-3 py-2">
    <option value="All">Semua Rarity</option>
    @foreach(['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'] as $r)
      <option value="{{ $r }}" {{ $r == ($rarity ?? '') ? 'selected':'' }}>{{ $r }}</option>
    @endforeach
  </select>

  <input name="search" placeholder="Cari nama ikan..." value="{{ request('search') }}"
         class="border border-gray-300 rounded px-3 py-2 flex-1"/>

  <button class="bg-sky-700 text-white rounded px-4 py-2 hover:bg-sky-800">Filter</button>
</form>

<div class="overflow-x-auto bg-white shadow rounded-lg">
  <table class="w-full text-left border-collapse">
    <thead class="bg-sky-700 text-white">
      <tr>
        <th class="py-2 px-3">Nama</th>
        <th class="py-2 px-3">Rarity</th>
        <th class="py-2 px-3">Harga</th>
        <th class="py-2 px-3">Peluang Tangkap</th>
        <th class="py-2 px-3 text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($fishes as $fish)
        <tr class="border-b hover:bg-sky-50">
          <td class="py-2 px-3">{{ $fish->name }}</td>
          <td class="py-2 px-3">{{ $fish->rarity }}</td>
          <td class="py-2 px-3">{{ $fish->formatted_price ?? $fish->sell_price_per_kg }}</td>
          <td class="py-2 px-3">{{ $fish->catch_probability }}%</td>
          <td class="py-2 px-3 text-center">
            <a href="{{ route('fishes.show',$fish) }}" class="text-sky-600 hover:underline">Lihat</a> |
            <a href="{{ route('fishes.edit',$fish) }}" class="text-yellow-600 hover:underline">Edit</a> |
            <form action="{{ route('fishes.destroy',$fish) }}" method="POST" class="inline">
              @csrf @method('DELETE')
              <button onclick="return confirm('Hapus ikan ini?')" class="text-red-600 hover:underline">
                Hapus
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center py-3">Belum ada data ikan.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-4">{{ $fishes->links() }}</div>
@endsection
