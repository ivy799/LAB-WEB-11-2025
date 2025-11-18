@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Stock Management</h2>

<form method="GET" class="mb-4 flex space-x-3">
    <select name="warehouse_id" class="border rounded p-2">
        <option value="">All Warehouses</option>
        @foreach($warehouses as $w)
            <option value="{{ $w->id }}" {{ request('warehouse_id') == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
        @endforeach
    </select>
    <button class="bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600">Filter</button>
</form>

<table class="w-full bg-white shadow rounded mb-6">
    <thead class="bg-gray-100 text-left">
        <tr>
            <th class="p-3">Product</th>
            <th class="p-3">Warehouse</th>
            <th class="p-3">Quantity</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stocks as $s)
        <tr class="border-t">
            <td class="p-3">{{ $s->product_name }}</td>
            <td class="p-3">{{ $s->warehouse_name }}</td>
            <td class="p-3">{{ $s->total }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3 class="text-xl font-semibold mb-2">Transfer / Adjust Stock</h3>
<form method="POST" action="{{ route('stocks.transfer') }}" class="bg-white p-6 rounded shadow w-2/3">
    @csrf
    <div class="grid grid-cols-3 gap-4">
        <div>
            <label class="block mb-1 font-medium">Product</label>
            <select name="product_id" class="w-full border rounded p-2" required>
                @foreach(\App\Models\Product::all() as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block mb-1 font-medium">Warehouse</label>
            <select name="warehouse_id" class="w-full border rounded p-2" required>
                @foreach($warehouses as $w)
                    <option value="{{ $w->id }}">{{ $w->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block mb-1 font-medium">Change (+/-)</label>
            <input type="number" name="quantity_change" class="w-full border rounded p-2" required>
        </div>
    </div>
    <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Submit</button>
</form>
@endsection
