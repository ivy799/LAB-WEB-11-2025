@extends('layouts.app')

@section('content')
    <!-- Menampilkan pesan sukses -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0">Detail: {{ $fish->name }}</h1>
            
            <!-- Tombol Aksi di Header -->
            <div class="card-header-actions">
                <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-warning">
                    Edit
                </a>
                <!-- Form Hapus -->
                <form action="{{ route('fishes.destroy', $fish) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus ikan {{ $fish->name }}?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
                <a href="{{ route('fishes.index') }}" class="btn btn-secondary">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Nama Ikan</dt>
                        <dd class="col-sm-8">{{ $fish->name }}</dd>

                        <dt class="col-sm-4">Rarity</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-primary fs-6">{{ $fish->rarity }}</span>
                        </dd>

                        <dt class="col-sm-4">Rentang Berat</dt>
                        <dd class="col-sm-8">{{ $fish->formatted_weight_range }}</dd>
                    </dl>
                </div>
                
                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-5">Harga Jual per kg</dt>
                        <dd class="col-sm-7">{{ $fish->formatted_price }}</dd>

                        <dt class="col-sm-5">Peluang Tangkap</dt>
                        <dd class="col-sm-7">{{ $fish->catch_probability }}%</dd>

                        <dt class="col-sm-5">Data Dibuat</dt>
                        <dd class="col-sm-7">{{ $fish->created_at->format('d M Y, H:i') }}</dt>
                        
                        <dt class="col-sm-5">Update Terakhir</dt>
                        <dd class="col-sm-7">{{ $fish->updated_at->diffForHumans() }}</dd>
                    </dl>
                </div>
            </div>

            <!-- Deskripsi -->
            <hr>
            <h5>Deskripsi</h5>
            <p class="text-muted">
                {!! nl2br(e($fish->description ?? 'Tidak ada deskripsi.')) !!}
            </p>
        </div>
    </div>
@endsection
