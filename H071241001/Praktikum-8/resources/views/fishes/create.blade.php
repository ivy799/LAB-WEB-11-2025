@extends('layouts.app')
@section('title', 'Tambah Ikan Baru')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Tambah Ikan Baru</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('fishes.store') }}" method="POST">
            @csrf
            @php $buttonText = 'Simpan Ikan' @endphp
            {{-- Memanggil partial form --}}
            @include('fishes._form')
        </form>
    </div>
</div>
@endsection