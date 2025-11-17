@extends('layouts.app')

@section('title', 'Manajemen Stok')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manajemen Stok</h2>
    <a href="{{ route('stocks.transfer') }}" class="btn btn-primary">
        <i class="fas fa-exchange-alt"></i> Transfer Stok
    </a>
</div>

<!-- Filter Gudang -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('stocks.index') }}">
            <div class="row">
                <div class="col-md-6">
                    <label for="warehouse_id" class="form-label">Filter Berdasarkan Gudang</label>
                    <select name="warehouse_id" id="warehouse_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Gudang</option>
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ $selectedWarehouse == $warehouse->id ? 'selected' : '' }}>
                                {{ $warehouse->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nama Produk</th>
                        <th>Gudang</th>
                        <th>Stok</th>
                        <th>Diperbarui</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stocks as $stock)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $stock->product->name }}</td>
                        <td>{{ $stock->warehouse->name }}</td>
                        <td>
                            <span class="badge bg-{{ $stock->quantity > 0 ? 'success' : 'secondary' }}">
                                {{ $stock->quantity }} pcs
                            </span>
                        </td>
                        <td>{{ $stock->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data stok</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection