@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Detail Produk: {{ $product->name }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Informasi Dasar</h5>
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Produk</th>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>
                            @if($product->category)
                                <span class="badge bg-primary">{{ $product->category->name }}</span>
                            @else
                                <span class="badge bg-secondary">Tidak ada kategori</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diperbarui Pada</th>
                        <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
            
            <div class="col-md-6">
                <h5>Detail Produk</h5>
                <table class="table table-bordered">
                    <tr>
                        <th>Berat</th>
                        <td>{{ $product->detail ? $product->detail->weight . ' kg' : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Ukuran</th>
                        <td>{{ $product->detail ? $product->detail->size : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $product->detail ? $product->detail->description : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Section Stok di Gudang -->
        <div class="row mt-4">
            <div class="col-12">
                <h5>Stok di Gudang</h5>
                @if($product->warehouses->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Gudang</th>
                                <th>Lokasi</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product->warehouses as $warehouse)
                            <tr>
                                <td>{{ $warehouse->name }}</td>
                                <td>{{ $warehouse->location ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $warehouse->pivot->quantity > 0 ? 'success' : 'secondary' }}">
                                        {{ $warehouse->pivot->quantity }} pcs
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        Produk ini belum memiliki stok di gudang manapun.
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
</div>
@endsection