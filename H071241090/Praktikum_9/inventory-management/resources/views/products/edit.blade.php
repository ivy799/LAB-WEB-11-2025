@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Edit Product</h2>

<form method="POST" action="{{ route('products.update', $product) }}" class="bg-white p-6 rounded shadow w-2/3">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 font-medium">Name</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Price</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Category</label>
            <select name="category_id" class="w-full border rounded p-2">
                <option value="">-- None --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Weight (kg)</label>
            <input type="number" step="0.01" name="weight" value="{{ old('weight', $product->detail->weight ?? '') }}" class="w-full border rounded p-2" required>
        </div>

        <div class="col-span-2">
            <label class="block mb-1 font-medium">Size</label>
            <input type="text" name="size" value="{{ old('size', $product->detail->size ?? '') }}" class="w-full border rounded p-2">
        </div>

        <div class="col-span-2">
            <label class="block mb-1 font-medium">Description</label>
            <textarea name="description" class="w-full border rounded p-2">{{ old('description', $product->detail->description ?? '') }}</textarea>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Update</button>
        <a href="{{ route('products.index') }}" class="ml-2 text-gray-600 hover:underline">Cancel</a>
    </div>
</form>
@endsection
