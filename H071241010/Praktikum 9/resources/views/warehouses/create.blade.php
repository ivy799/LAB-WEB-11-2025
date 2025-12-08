@extends('layouts.app') @section('content')
    <h2>Tambah Gudang Baru</h2>

    <form action="{{ route('warehouses.store') }}" method="POST">
        @csrf <div class="mb-3">
            <label class="form-label">Nama Gudang</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Lokasi (Opsional)</label>
            <textarea name="location" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection