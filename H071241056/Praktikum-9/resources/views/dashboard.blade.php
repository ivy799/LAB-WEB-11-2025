@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0" style="color: #2c3e50; font-weight: 600;">Dashboard</h1>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h2 class="fw-bold">{{ $data['total_categories'] }}</h2>
                            <p class="mb-0">Kategori</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-tags fa-2x opacity-75"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small><i class="fas fa-arrow-up me-1"></i> 5% dari bulan lalu</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h2 class="fw-bold">{{ $data['total_products'] }}</h2>
                            <p class="mb-0">Total Produk</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-box fa-2x opacity-75"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small><i class="fas fa-arrow-up me-1"></i> 12% dari bulan lalu</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h2 class="fw-bold">{{ $data['total_warehouses'] }}</h2>
                            <p class="mb-0">Gudang</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-warehouse fa-2x opacity-75"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small><i class="fas fa-minus me-1"></i> Tidak berubah</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h2 class="fw-bold">{{ $data['total_stock'] }}</h2>
                            <p class="mb-0">Total Stok</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-pallet fa-2x opacity-75"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small><i class="fas fa-arrow-up me-1"></i> 8% dari bulan lalu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card nav-card">
                <div class="card-body text-center">
                    <i class="fas fa-tags fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Manajemen Kategori</h5>
                    <p class="card-text text-muted">Kelola kategori produk</p>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary">Buka</a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card nav-card">
                <div class="card-body text-center">
                    <i class="fas fa-warehouse fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Manajemen Gudang</h5>
                    <p class="card-text text-muted">Kelola data gudang</p>
                    <a href="{{ route('warehouses.index') }}" class="btn btn-success">Buka</a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card nav-card">
                <div class="card-body text-center">
                    <i class="fas fa-box fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Manajemen Produk</h5>
                    <p class="card-text text-muted">Kelola data produk</p>
                    <a href="{{ route('products.index') }}" class="btn btn-warning">Buka</a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card nav-card">
                <div class="card-body text-center">
                    <i class="fas fa-exchange-alt fa-3x text-info mb-3"></i>
                    <h5 class="card-title">Manajemen Stok</h5>
                    <p class="card-text text-muted">Kelola stok produk</p>
                    <a href="{{ route('stocks.index') }}" class="btn btn-info">Buka</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection