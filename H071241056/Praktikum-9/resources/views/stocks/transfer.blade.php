@extends('layouts.app')

@section('title', 'Transfer Stok')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Transfer Stok</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('stocks.process-transfer') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="warehouse_id" class="form-label">Pilih Gudang <span class="text-danger">*</span></label>
                        <select class="form-control @error('warehouse_id') is-invalid @enderror" 
                                id="warehouse_id" name="warehouse_id" required>
                            <option value="">Pilih Gudang</option>
                            @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('warehouse_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Pilih Produk <span class="text-danger">*</span></label>
                        <select class="form-control @error('product_id') is-invalid @enderror" 
                                id="product_id" name="product_id" required>
                            <option value="">Pilih Produk</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Jumlah Stok <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                           id="quantity" name="quantity" value="{{ old('quantity') }}" required 
                           placeholder="Contoh: +10 untuk tambah stok, -5 untuk kurangi stok">
                </div>
                <small class="form-text text-muted">
                    Masukkan nilai positif (+) untuk menambah stok, nilai negatif (-) untuk mengurangi stok.
                    Stok tidak boleh minus.
                </small>
                @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-exchange-alt"></i> Proses Transfer
                </button>
                <a href="{{ route('stocks.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection