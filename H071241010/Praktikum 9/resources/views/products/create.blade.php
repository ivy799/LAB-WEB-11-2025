@extends('layouts.app') @section('content')
<h2>Tambah Produk Baru</h2>

<form action="{{ route('products.store') }}" method="POST">
    @csrf <h4>Data Produk Utama</h4>
    <div class="mb-3">
        <label class="form-label">Nama Produk</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Harga</label>
        <input type="number" name="price" class="form-control" required step="0.01">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <hr> <h4>Data Detail Produk</h4>
    <div class="mb-3">
        <label class="form-label">Deskripsi (Opsional)</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Berat (kg)</label>
        <input type="number" name="weight" class="form-control" required step="0.01">
    </div>

    <div class="mb-3">
        <label class="form-label">Ukuran (misal: 15 inch)</label>
        <input type="text" name="size" class="form-control">
    </div>
    
    <button type="submit" class="btn btn-success">Simpan Produk</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection