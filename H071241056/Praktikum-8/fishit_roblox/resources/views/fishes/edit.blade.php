@extends('layout.app')

@section('content')
<h2>Edit Ikan</h2>

<form method="POST" action="{{ route('fishes.update', $fish) }}">
    @method('PUT')
    @include('fishes._form')
</form>
@endsection


