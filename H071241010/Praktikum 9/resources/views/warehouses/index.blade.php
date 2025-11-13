@extends('layouts.app') @section('content')
    <h2>Daftar Gudang (Warehouse)</h2>
    <!-- <a href="{{ route('warehouses.create') }}" class="btn btn-primary mb-3">+ Tambah Gudang</a> -->
    <a href="/warehouses/create" class="btn btn-primary mb-3">+ Tambah Gudang</a>


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Lokasi</th>
            <th>Aksi</th>
        </tr>
        @foreach($warehouses as $key => $warehouse)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $warehouse->name }}</td>
                <td>{{ $warehouse->location }}</td>
                <td>
                    <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus Gudang ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {{ $warehouses->links() }}

@endsection