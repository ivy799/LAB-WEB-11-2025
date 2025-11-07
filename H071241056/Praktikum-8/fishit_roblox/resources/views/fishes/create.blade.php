@extends('layout.app')

@section('content')
<h2>Tambah Ikan</h2>

<form method="POST" action="{{ route('fishes.store') }}">
    @include('fishes._form')
</form>
@endsection
