@extends('layout.app')

@section('content')
<h2 class="mb-3">Daftar Ikan</h2>

<form method="GET" class="row mb-3">
    <div class="col-md-3">
        <select name="rarity" class="form-select" onchange="this.form.submit()">
            <option value="">-- ketegori ikan --</option>
            @foreach ($rarities as $r)
                <option value="{{ $r }}" {{ request('rarity') == $r ? 'selected' : '' }}>{{ $r }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Cari nama ikan..." value="{{ request('search') }}">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">Cari</button>
    </div>
</form>

<table class="table table-bordered table-striped">
    <thead class="table-primary">
        <tr>
            <th>Nama</th>
            <th>Rarity</th>
            <th>Berat (kg)</th>
            <th>Harga/kg</th>
            <th>Catch Prob (%)</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($fishes as $fish)
        <tr>
            <td>{{ $fish->name }}</td>
            <td>{{ $fish->rarity }}</td>
            <td>{{ number_format($fish->base_weight_min, 2) }} - {{ number_format($fish->base_weight_max, 2) }}</td>
            <td>{{ number_format($fish->sell_price_per_kg, 0, ',', '.') }}</td>
            <td>{{ number_format($fish->catch_probability, 2) }}</td>
            <td>
                <a href="{{ route('fishes.show', $fish) }}" class="btn btn-info btn-sm">Detail</a>
                <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('fishes.destroy', $fish) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus ikan ini?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $fishes->links() }} <!-- pignation ->links() otomatis membuat navigasi halaman (< 1 2 3 >) menggunakan Bootstrap. -->

@endsection
