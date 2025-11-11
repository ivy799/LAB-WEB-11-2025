@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-semibold">Warehouses</h2>
    <a href="{{ route('warehouses.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">+ New Warehouse</a>
</div>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-100 text-left">
        <tr>
            <th class="p-3">Name</th>
            <th class="p-3">Location</th>
            <th class="p-3">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($warehouses as $w)
        <tr class="border-t">
            <td class="p-3">{{ $w->name }}</td>
            <td class="p-3">{{ $w->location ?? '-' }}</td>
            <td class="p-3">
                <a href="{{ route('warehouses.edit', $w) }}" class="text-blue-500 hover:underline">Edit</a>
                <form action="{{ route('warehouses.destroy', $w) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button class="text-red-500 hover:underline" onclick="return confirm('Delete this warehouse?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
