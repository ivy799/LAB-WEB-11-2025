@extends('layout.app')

@section('content')
<h2>Detail Ikan</h2>

<div class="card mb-3">
    <div class="card-body">
        <h4 class="card-title">{{ $fish->name }}</h4>
        <p><strong>Rarity:</strong> {{ $fish->rarity }}</p>
        <p><strong>Berat:</strong> {{ number_format($fish->base_weight_min,2) }} - {{ number_format($fish->base_weight_max,2) }} kg</p>
        <p><strong>Harga/kg:</strong> {{ number_format($fish->sell_price_per_kg, 0, ',', '.') }}</p>
        <p><strong>Catch Probability:</strong> {{ number_format($fish->catch_probability,2) }}%</p>
        <p><strong>Deskripsi:</strong> {{ $fish->description ?? '-' }}</p>
    </div>
</div>

<a href="{{ route('fishes.edit', $fish) }}" class="btn btn-warning">Edit</a>
<a href="{{ route('fishes.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
