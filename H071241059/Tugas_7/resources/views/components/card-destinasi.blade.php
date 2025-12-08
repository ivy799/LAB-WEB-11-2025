@props(['judul', 'deskripsi', 'gambar'])

<div style="border: 1px solid #ccc; border-radius: 8px; overflow: hidden; margin-bottom: 20px; box-shadow: 2px 2px 5px rgba(0,0,0,0.1);">
    <img src="{{ asset('images/' . $gambar) }}" alt="{{ $judul }}" style="width: 100%; height: 200px; object-fit: cover;">
    <div style="padding: 15px;">
        <h4 style="color: #007bff; margin-top: 0;">{{ $judul }}</h4>
        <p>{{ $deskripsi }}</p>
    </div>
</div>