@extends('layouts.app')
@section('title', 'Fish Database Index')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Fish Database</h2>
    <a href="{{ route('fishes.create') }}" class="btn btn-primary">Tambah Ikan Baru</a>
</div>

{{-- Filter dan Search  --}}
<div class="row mb-3">
    <div class="col-md-5">
        <form method="GET" class="d-flex">
            {{-- Pertahankan filter rarity saat melakukan search --}}
            <input type="hidden" name="rarity" value="{{ request('rarity') }}"> 
            <input type="text" name="search" class="form-control me-2" placeholder="Cari berdasarkan nama..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary">Cari</button>
        </form>
    </div>
    <div class="col-md-4">
        <form method="GET">
            {{-- Pertahankan search saat melakukan filter --}}
            <input type="hidden" name="search" value="{{ request('search') }}"> 
            {{-- Filter Rarity (Dropdown) --}}
            <select name="rarity" class="form-select" onchange="this.form.submit()">
                <option value="">Filter Rarity (Semua)</option>
                @foreach($rarities as $rarity)
                    <option value="{{ $rarity }}" {{ request('rarity') == $rarity ? 'selected': '' }}>
                        {{ $rarity }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><a href="{{ route('fishes.index', ['sort' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'rarity' => request('rarity'), 'search' => request('search')]) }}">ID</a></th>
                        <th><a href="{{ route('fishes.index', ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'rarity' => request('rarity'), 'search' => request('search')]) }}">Nama Ikan</a></th>
                        <th>Rarity</th>
                        <th>Berat (kg)</th>
                        <th><a href="{{ route('fishes.index', ['sort' => 'sell_price_per_kg', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'rarity' => request('rarity'), 'search' => request('search')]) }}">Harga/kg</a></th>
                        <th><a href="{{ route('fishes.index', ['sort' => 'catch_probability', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'rarity' => request('rarity'), 'search' => request('search')]) }}">Probabilitas</a></th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fishes as $fish)
                    <tr>
                        <td>{{ $fish->id }}</td>
                        <td>{{ $fish->name }}</td>
                        <td><span class="badge bg-primary">{{ $fish->rarity }}</span></td>
                        <td>{{ $fish->formatted_weight }}</td> 
                        <td>{{ $fish->formatted_price }}</td> 
                        <td>{{ number_format($fish->catch_probability, 2) }}%</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('fishes.show', $fish) }}" class="btn btn-info">Lihat Detail</a>
                                <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-warning">Edit</a>
                                
                                {{-- Form Hapus dengan Konfirmasi --}}
                                <form method="POST" action="{{ route('fishes.destroy', $fish) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus ikan {{ $fish->name }}?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data ikan ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-center mt-4">
    {{ $fishes->appends(request()->except('page'))->links() }}
</div>
@endsection