@extends('layouts.master')

@section('content')
<section class="hero">
    <h1>{{ $judul }}</h1>
</section>

<section class="intro">
    <h2>{{ $tagline }}</h2>

    @php
        $highlight = ['Pantai Pinang', 'Bukit Nane', 'Pulau Tinabo'];
    @endphp

    <p>
        Jelajahi tiga destinasi unggulan:
        @foreach($highlight as $h)
            <strong>{{ $h }}</strong>@if(!$loop->last), @else.@endif
        @endforeach
        <br><br>
        Kepulauan Selayar menyimpan keindahan alam yang memukau: pantai pasir putih, taman laut, 
        dan kuliner khas yang menggoda. Temukan keajaiban alam Sulawesi Selatan di sini.
    </p>
</section>
@endsection