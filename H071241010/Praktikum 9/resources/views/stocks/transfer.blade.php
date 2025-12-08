@extends('layouts.app') @section('content')
<h2>Formulir Transfer Stok</h2>
<p classC="text-muted">Gunakan form ini untuk menambah (nilai positif) atau mengurangi (nilai negatif) stok produk di gudang.</p>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form action="{{ route('stocks.transfer.store') }}" method="POST">
    @csrf <div class="mb-3">
        <label class="form-label">Gudang Tujuan</label>
        <select name="warehouse_id" class="form-select" required>
            <option value="">-- Pilih Gudang --</option>
            @foreach($warehouses as $warehouse)
                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Produk</label>
        <select name="product_id" class="form-select" required>
            <option value="">-- Pilih Produk --</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Perubahan Kuantitas</label>
        <input type="number" name="quantity_change" class="form-control" required placeholder="Contoh: 10 atau -5">
        <div class="form-text">
            Masukkan angka positif (misal: 10) untuk **menambah** stok.
            <br>
            Masukkan angka negatif (misal: -10) untuk **mengurangi** stok.
        </div>
    </div>
    
    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection