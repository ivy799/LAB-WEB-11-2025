@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-semibold">Products</h2>
    <a href="{{ route('products.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">+ New Product</a>
</div>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-100 text-left">
        <tr>
            <th class="p-3">Name</th>
            <th class="p-3">Category</th>
            <th class="p-3">Price</th>
            <th class="p-3">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $p)
        <tr class="border-t">
            <td class="p-3">{{ $p->name }}</td>
            <td class="p-3">{{ $p->category->name ?? '-' }}</td>
            <td class="p-3">Rp{{ number_format($p->price, 2) }}</td>
            <td class="p-3 space-x-2">
                <a href="{{ route('products.show', $p) }}" class="text-green-600 hover:underline">View</a>
                <a href="{{ route('products.edit', $p) }}" class="text-blue-500 hover:underline">Edit</a>
                <form action="{{ route('products.destroy', $p) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button class="text-red-500 hover:underline" onclick="return confirm('Delete this product?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
