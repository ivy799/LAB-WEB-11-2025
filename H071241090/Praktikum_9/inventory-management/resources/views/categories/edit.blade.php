@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Edit Category</h2>

<form method="POST" action="{{ route('categories.update', $category) }}" class="bg-white p-6 rounded shadow w-1/2">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="block mb-1 font-medium">Name</label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full border rounded p-2" required>
    </div>
    <div class="mb-3">
        <label class="block mb-1 font-medium">Description</label>
        <textarea name="description" class="w-full border rounded p-2">{{ old('description', $category->description) }}</textarea>
    </div>

    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Update</button>
    <a href="{{ route('categories.index') }}" class="ml-2 text-gray-600 hover:underline">Cancel</a>
</form>
@endsection
