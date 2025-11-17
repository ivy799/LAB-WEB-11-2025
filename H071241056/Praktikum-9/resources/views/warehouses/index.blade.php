@extends('layouts.app')

@section('title', 'Manajemen Gudang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manajemen Gudang</h2>
    <a href="{{ route('warehouses.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Gudang
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nama Gudang</th>
                        <th>Lokasi</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($warehouses as $warehouse)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $warehouse->name }}</td>
                        <td>{{ $warehouse->location ?? '-' }}</td>
                        <td>{{ $warehouse->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('warehouses.show', $warehouse) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('warehouses.destroy', $warehouse) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus gudang?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection