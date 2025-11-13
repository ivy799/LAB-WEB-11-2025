@extends('layouts.app') @section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Manajemen Stok</h2>
    <a href="{{ route('stocks.transfer.create') }}" class="btn btn-success">+ Transfer Stok</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card mb-4">
    <div class="card-header">Filter Stok Gudang</div>
    <div class="card-body">
        <form action="{{ route('stocks.index') }}" method="GET">
            <div class="row">
                <div class="col-md-10">
                    <select name="warehouse_id" class="form-select" required>
                        <option value="">-- Pilih Gudang untuk Menampilkan Stok --</option>
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}"
                                @if($warehouse->id == $selectedWarehouseId) selected @endif
                            >
                                {{ $warehouse->name }} ({{ $warehouse->location }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>
@if($selectedWarehouseId)
    <div class="card">
        <div class="card-header">Daftar Stok</div>
        <div class="card-body">
            @if($productsInWarehouse && $productsInWarehouse->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jumlah Stok Saat Ini</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productsInWarehouse as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td><strong>{{ $product->pivot->quantity }}</strong> unit</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">Tidak ada stok produk di gudang ini.</p>
            @endif
        </div>
    </div>
@else
    <div class="alert alert-info">
        Silakan pilih gudang di atas untuk melihat daftar stok.
    </div>
@endif
@endsection 