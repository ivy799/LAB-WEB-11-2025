@extends('layouts.app')
@section('title', 'Edit Ikan: ' . $fish->name)

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Edit Ikan: {{ $fish->name }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('fishes.update', $fish) }}" method="POST">
            @csrf
            @method('PUT')
            {{-- Menggunakan variabel untuk teks tombol --}}
            @php $buttonText = 'Update Data Ikan' @endphp
            {{-- Memanggil partial form, data otomatis terisi karena $fish tersedia --}}
            @include('fishes._form')
        </form>
    </div>
</div>
@endsection