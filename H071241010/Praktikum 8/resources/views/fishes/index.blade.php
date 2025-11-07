@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h2 mb-0">Fish It Database</h1>
        <a href="{{ route('fishes.create') }}" class="btn btn-primary">
            + Tambah Ikan Baru
        </a>
    </div>

    <!-- Menampilkan pesan sukses -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Filter dan Search (Bonus) -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('fishes.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="search" class="form-label">Cari Nama Ikan</label>
                    <input type="text" class="form-control" name="search" id="search"
                           placeholder="Contoh: Goldfish" value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label for="rarity" class="form-label">Filter Rarity</label>
                    <select name="rarity" id="rarity" class="form-select">
                        <option value="">Semua Rarity</option>
                        @foreach($rarities as $rarity)
                            <option value="{{ $rarity }}" {{ request('rarity') == $rarity ? 'selected' : '' }}>
                                {{ $rarity }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-dark w-100">Filter</button>
                    @if(request('search') || request('rarity'))
                         <a href="{{ route('fishes.index') }}" class="btn btn-outline-secondary w-100 mt-2">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data Ikan -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Ikan</th>
                            <th>Rarity</th>
                            <th>Berat (Min/Max)</th>
                            <th>Harga Jual</th>
                            <th>Peluang</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($fishes as $fish)
                            <tr>
                                <td>
                                    <a href="{{ route('fishes.show', $fish) }}" class="fw-bold text-dark text-decoration-none">
                                        {{ $fish->name }}
                                    </a>
                                </td>
                                <td><span class="badge bg-secondary">{{ $fish->rarity }}</span></td>
                                <td>{{ $fish->base_weight_min }}kg / {{ $fish->base_weight_max }}kg</td>
                                <td>{{ $fish->sell_price_per_kg }} Coins/kg</td>
                                <td>{{ $fish->catch_probability }}%</td>
                                <td class="text-end">
                                    <a href="{{ route('fishes.show', $fish) }}" class="btn btn-sm btn-info text-white">Lihat</a>
                                    <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <!-- Form Hapus -->
                                    <form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus ikan {{ $fish->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-4">
                                    <p class="mb-0 text-muted">Data ikan tidak ditemukan.</p>
                                    @if(request('search') || request('rarity'))
                                        <a href="{{ route('fishes.index') }}" class="btn btn-sm btn-outline-primary mt-2">Reset Filter</a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Pagination Links -->
        @if ($fishes->hasPages())
            <div class="card-footer">
                {{ $fishes->links() }}
            </div>
        @endif
    </div>
@endsection
