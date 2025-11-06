@extends('layouts.master')

@section('content')
<h2 style="color:#4B0082; text-align:center; margin-top:40px; font-size: 40px;">Galeri Selayar</h2>

<div class="card-container">
    @foreach($foto as $f)
        <div class="card">
            <img src="{{ asset('images/' . $f) }}" alt="Foto Galeri">
        </div>
    @endforeach
</div>
@endsection
