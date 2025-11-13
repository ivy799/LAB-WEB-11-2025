@extends('layouts.app')
@section('content')
    <h2>Edit Gudang</h2>

    <form action="{{ route('warehouses.update', $warehouse->id) }}" method="POST">
        @csrf @method('PUT') <div class="mb-3">
            <label class="form-label">Nama Gudang</label>
            <input type="text" name="name" class="form-control" value="{{ $warehouse->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Lokasi (Opsional)</label>
            <textarea name="location" class="form-control">{{ $warehouse->location }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Perbarui</button>
        <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection