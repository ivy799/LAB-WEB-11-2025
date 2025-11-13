@extends('layouts.app') @section('content')
<h2>Tambah Kategori Baru</h2>

<form action="{{ route('categories.store') }}" method="POST">
    @csrf <div class="mb-3">
        <label class="form-label">Nama Kategori</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Deskripsi (Opsional)</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection