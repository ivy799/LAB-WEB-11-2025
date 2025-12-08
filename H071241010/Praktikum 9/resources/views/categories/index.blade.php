@extends('layouts.app') @section('content') <h2>Daftar Kategori</h2>

<a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">+ Tambah Kategori</a>

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
        <th>Deskripsi</th> <th>Aksi</th>
    </tr>
    @foreach($categories as $key => $category)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $category->name }}</td>
        <td>{{ $category->description }}</td> <td>
            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
            
            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus Kategori ini?')">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{{ $categories->links() }}

@endsection 