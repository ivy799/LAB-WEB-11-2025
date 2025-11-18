@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-semibold">Categories</h2>
    <a href="{{ route('categories.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">+ New Category</a>
</div>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-100 text-left">
        <tr>
            <th class="p-3">Name</th>
            <th class="p-3">Description</th>
            <th class="p-3">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $cat)
        <tr class="border-t">
            <td class="p-3">{{ $cat->name }}</td>
            <td class="p-3">{{ $cat->description ?? '-' }}</td>
            <td class="p-3 space-x-2">
                <a href="{{ route('categories.edit', $cat) }}" class="text-blue-500 hover:underline">Edit</a>
                <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button class="text-red-500 hover:underline" onclick="return confirm('Delete this category?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
