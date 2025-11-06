@extends('layouts.master')

@section('content')
<h2 class="page-title">Destinasi Wisata Unggulan</h2>

<div class="card-container">
    @foreach($destinasi as $d)
        <x-card 
            image="{{ $d['gambar'] }}" 
            title="{{ $d['nama'] }}" 
            description="{{ $d['deskripsi'] }}" 
        />
    @endforeach
</div>

{{-- Directive untuk menampilkan total data --}}
@if(count($destinasi) > 0)
    <p class="info-count">Terdapat {{ count($destinasi) }} destinasi menarik di Selayar</p>
@else
    <p class="info-count error">Belum ada data destinasi.</p>
@endif
@endsection