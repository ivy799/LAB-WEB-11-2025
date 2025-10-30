@extends('layouts.master')

@section('content')
<h2 class="page-title">Kuliner Khas Selayar</h2>

<div class="card-container">
    @foreach($kuliner as $k)
        <x-card image="{{ $k['gambar'] }}" title="{{ $k['nama'] }}" description="{{ $k['deskripsi'] }}" />
    @endforeach
</div>

{{-- Directive untuk menampilkan total data --}}
@if(count($kuliner) > 0)
    <p class="info-count">Terdapat {{ count($kuliner) }} kuliner khas Selayar yang wajib dicoba!</p>
@else
    <p class="info-count error">Belum ada data kuliner.</p>
@endif
@endsection