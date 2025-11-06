@extends('layouts.master')

@section('content')
<h2 class="page-title">Kontak Kami</h2>

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="contact-container">
    <div class="contact-info">
        <h3>Informasi Kontak</h3>
        <div class="contact-item">
            <i class="fas fa-map-marker-alt"></i>
            <div>
                <strong>Alamat</strong>
                <p>Jl. Poros Benteng No.10, Kepulauan Selayar</p>
            </div>
        </div>
        <div class="contact-item">
            <i class="fas fa-envelope"></i>
            <div>
                <strong>Email</strong>
                <p>info@eksplorselayar.com</p>
            </div>
        </div>
        <div class="contact-item">
            <i class="fas fa-phone"></i>
            <div>
                <strong>Telepon</strong>
                <p>+62 812-3456-7890</p>
            </div>
        </div>
    </div>

    <div class="contact-form">
        <h3>Kirim Pesan</h3>
        <form method="POST" action="{{ route('kirim.pesan') }}">
            @csrf
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" placeholder="Masukkan nama Anda" required>
            </div>

            <div class="form-group">
                <label for="pesan">Pesan</label>
                <textarea id="pesan" name="pesan" rows="4" placeholder="Tulis pesan Anda di sini..." required></textarea>
            </div>

            <button type="submit" class="submit-button">Kirim Pesan</button>
        </form>
    </div>
</div>
@endsection