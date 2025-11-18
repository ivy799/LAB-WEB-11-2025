@extends('layout')

@section('content')
<h2 class="text-2xl font-bold mb-6">Manajemen Stok Produk</h2>

<form action="{{ route('stocks.index') }}" method="GET" class="flex items-center gap-2 mb-6">
  <label class="font-medium">Pilih Gudang:</label>
  <select name="warehouse_id" class="border-gray-300 rounded-lg px-2 py-1">
    <option value="">-- Semua Gudang --</option>
    @foreach($warehouses as $w)
      <option value="{{ $w->id }}" {{ $selectedWarehouseId == $w->id ? 'selected' : '' }}>
        {{ $w->id }} - {{ $w->name }}
      </option>
    @endforeach
  </select>
  <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded">Filter</button>
  <a href="{{ route('stocks.transfer') }}" class="ml-auto bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
    Transfer Stok
  </a>
</form>

@if(!$selectedWarehouseId)
  @foreach($warehouses as $warehouse)
    <div class="bg-white shadow rounded-lg p-6 mb-8">
      <h3 class="text-xl font-semibold mb-4">
        Gudang #{{ $warehouse->id }} — {{ $warehouse->name }}
      </h3>

      @if($warehouse->products->count() > 0)
        <table class="min-w-full border-collapse bg-white">
          <thead>
            <tr class="bg-gray-200 text-left">
              <th class="py-2 px-4">ID Produk</th>
              <th class="py-2 px-4">Nama Produk</th>
              <th class="py-2 px-4 text-right">Jumlah</th>
            </tr>
          </thead>
          <tbody>
            @php $total = 0; @endphp
            @foreach($warehouse->products as $p)
              <tr class="border-t hover:bg-gray-50">
                <td class="py-2 px-4">{{ $p->id }}</td>
                <td class="py-2 px-4">{{ $p->name }}</td>
                <td class="py-2 px-4 text-right">{{ $p->pivot->quantity }}</td>
                @php $total += $p->pivot->quantity; @endphp
              </tr>
            @endforeach
            <tr class="bg-gray-100 font-semibold">
              <td colspan="2" class="py-2 px-4 text-right">Total Stok</td>
              <td class="py-2 px-4 text-right">{{ $total }}</td>
            </tr>
          </tbody>
        </table>
      @else
        <p class="text-gray-500">Tidak ada stok di gudang ini.</p>
      @endif
    </div>
  @endforeach

@elseif($selectedWarehouse)
  <div class="bg-white shadow rounded-lg p-6">
    <h3 class="text-xl font-semibold mb-4">
      Gudang #{{ $selectedWarehouse->id }} — {{ $selectedWarehouse->name }}
    </h3>

    <table class="min-w-full border-collapse bg-white">
      <thead>
        <tr class="bg-gray-200 text-left">
          <th class="py-2 px-4">ID Produk</th>
          <th class="py-2 px-4">Nama Produk</th>
          <th class="py-2 px-4 text-right">Jumlah</th>
        </tr>
      </thead>
      <tbody>
        @php $total = 0; @endphp
        @forelse($selectedWarehouse->products as $p)
          <tr class="border-t hover:bg-gray-50">
            <td class="py-2 px-4">{{ $p->id }}</td>
            <td class="py-2 px-4">{{ $p->name }}</td>
            <td class="py-2 px-4 text-right">{{ $p->pivot->quantity }}</td>
            @php $total += $p->pivot->quantity; @endphp
          </tr>
        @empty
          <tr>
            <td colspan="3" class="text-center py-3 text-gray-500">Tidak ada stok di gudang ini.</td>
          </tr>
        @endforelse
        <tr class="bg-gray-100 font-semibold">
          <td colspan="2" class="py-2 px-4 text-right">Total Stok</td>
          <td class="py-2 px-4 text-right">{{ $total }}</td>
        </tr>
      </tbody>
    </table>
  </div>
@endif
@endsection
