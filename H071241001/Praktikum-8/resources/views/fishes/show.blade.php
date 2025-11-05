@extends('layouts.app')
@section('title', 'Detail Ikan: ' . $fish->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Detail Ikan: {{ $fish->name }}</h2>
    {{-- Tombol untuk kembali ke daftar --}}
    <a href="{{ route('fishes.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
</div>

<div class="card mb-4">
    <div class="card-header">
        Informasi Lengkap
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>ID:</strong> {{ $fish->id }}</p>
                <p><strong>Nama:</strong> {{ $fish->name }}</p>
                <p><strong>Rarity:</strong> <span class="badge bg-primary">{{ $fish->rarity }}</span></p>
                {{-- Menggunakan Accessor --}}
                <p><strong>Berat (Min-Max):</strong> {{ $fish->formatted_weight }}</p> 
                <p><strong>Harga Jual per kg:</strong> {{ $fish->formatted_price }}</p>
                <p><strong>Peluang Tertangkap:</strong> {{ number_format($fish->catch_probability, 2) }}%</p>
            </div>
            <div class="col-md-6">
                <p><strong>Waktu Dibuat:</strong> {{ $fish->created_at }}</p>
                <p><strong>Waktu Update Terakhir:</strong> {{ $fish->updated_at }}</p>
                <p><strong>Deskripsi:</strong></p>
                <p class="border p-2">{{ $fish->description ?? 'Tidak ada deskripsi.' }}</p>
            </div>
        </div>
    </div>
    <div class="card-footer">
        {{-- Tombol Edit dan Hapus --}}
        <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-warning">Edit Data</a>
        <form method="POST" action="{{ route('fishes.destroy', $fish) }}" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus ikan {{ $fish->name }}?')">Hapus</button>
        </form>
    </div>
</div>
@endsection