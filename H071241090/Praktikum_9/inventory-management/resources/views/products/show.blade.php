@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Product Details</h2>

<div class="bg-white p-6 rounded shadow w-2/3">
    <h3 class="text-xl font-semibold mb-2">{{ $product->name }}</h3>
    <p><strong>Category:</strong> {{ $product->category->name ?? '-' }}</p>
    <p><strong>Price:</strong> Rp{{ number_format($product->price, 2) }}</p>
    <p><strong>Weight:</strong> {{ $product->detail->weight ?? '-' }} kg</p>
    <p><strong>Size:</strong> {{ $product->detail->size ?? '-' }}</p>
    <p class="mt-2"><strong>Description:</strong><br>{{ $product->detail->description ?? '-' }}</p>

    <hr class="my-4">

    <h4 class="text-lg font-semibold mb-2">Stock per Warehouse</h4>
    @if($product->warehouses->isEmpty())
        <p class="text-gray-500">No stock data available.</p>
    @else
        <table class="w-full bg-gray-50 rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Warehouse</th>
                    <th class="p-2 text-left">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($product->warehouses as $wh)
                    <tr class="border-t">
                        <td class="p-2">{{ $wh->name }}</td>
                        <td class="p-2">{{ $wh->pivot->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="mt-4">
        <a href="{{ route('products.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Back</a>
    </div>
</div>
@endsection
