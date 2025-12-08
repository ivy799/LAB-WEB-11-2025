@extends('layouts.master')

@section('title', 'Hubungi Kami')

@section('content')
    <div class="text-center">
        <h2>Kontak & Informasi</h2>
        <p>Ada pertanyaan seputar wisata Soppeng? Hubungi kami.</p>
    </div>

    <div style="display: flex; gap: 40px; margin-top: 30px; flex-wrap: wrap;">

        {{-- Bagian Informasi Kontak --}}
        <div style="flex: 1; min-width: 300px;">
            <h3 style="color: var(--primary-color);">Kantor Pariwisata</h3>
            <p><strong>Alamat:</strong> Jl. Lamumpatue No. 12, Watansoppeng, Kab. Soppeng, Sulawesi Selatan</p>
            <p><strong>Email:</strong> info@visitsoppeng.go.id</p>
            <p><strong>Telepon:</strong> (0484) 21xxx</p>
            <p style="margin-top: 20px;">Kami siap memandu perjalanan Anda menikmati keindahan Bumi Latemmamala.</p>
        </div>

        {{-- Bagian Formulir --}}
        <div style="flex: 2; min-width: 300px; background-color: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-top: 4px solid var(--primary-color);">
            <h3>Kirim Pesan</h3>
            <form action="#" method="POST">
                <div style="margin-bottom: 15px;">
                    <label for="nama" style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Nama:</label>
                    <input type="text" id="nama" name="nama" required
                           style="width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="email" style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Email:</label>
                    <input type="email" id="email" name="email" required
                           style="width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="pesan" style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Pesan:</label>
                    <textarea id="pesan" name="pesan" rows="4" required
                              style="width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ddd; border-radius: 4px;"></textarea>
                </div>

                <button type="submit"
                        style="background-color: var(--primary-color); color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; transition: background 0.2s;">
                    Kirim Pesan
                </button>
            </form>
        </div>
    </div>
@endsection
