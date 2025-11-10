<!--
File ini berisi field form yang dipakai bersama
oleh create.blade.php dan edit.blade.php
-->

<!-- Menampilkan error validasi jika ada -->
@if ($errors->any())
    <div class="alert alert-danger">
        <h5 class="alert-heading">Terjadi Kesalahan!</h5>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@csrf <!-- Token CSRF untuk keamanan form -->

<div class="row">
    <!-- Kolom Kiri -->
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Ikan <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ old('name', $fish->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="rarity" class="form-label">Rarity <span class="text-danger">*</span></label>
            <select class="form-select" id="rarity" name="rarity" required>
                <option value="" disabled {{ !isset($fish) ? 'selected' : '' }}>-- Pilih Rarity --</option>
                @foreach($rarities as $rarity)
                    <option value="{{ $rarity }}"
                        {{ old('rarity', $fish->rarity ?? '') == $rarity ? 'selected' : '' }}>
                        {{ $rarity }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="base_weight_min" class="form-label">Berat Minimum (kg) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control" id="base_weight_min" name="base_weight_min"
                           value="{{ old('base_weight_min', $fish->base_weight_min ?? '') }}" required>
                </div>
            </div>
            <div class="col-6">
                 <div class="mb-3">
                    <label for="base_weight_max" class="form-label">Berat Maksimum (kg) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control" id="base_weight_max" name="base_weight_max"
                           value="{{ old('base_weight_max', $fish->base_weight_max ?? '') }}" required>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan -->
    <div class="col-md-6">
        <div class="mb-3">
            <label for="sell_price_per_kg" class="form-label">Harga Jual /kg (Coins) <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="sell_price_per_kg" name="sell_price_per_kg"
                   value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="catch_probability" class="form-label">Peluang Tangkap (%) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control" id="catch_probability" name="catch_probability"
                   placeholder="0.01 - 100.00"
                   value="{{ old('catch_probability', $fish->catch_probability ?? '') }}" required>
        </div>
    </div>
</div>

<!-- Baris Penuh -->
<div class="row">
    <div class="col-12">
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Ikan</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $fish->description ?? '') }}</textarea>
            <div class="form-text">Boleh dikosongkan.</div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between">
    <a href="{{ url()->previous() }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Batal
    </a>
    <button type="submit" class="btn btn-primary">
        <!-- $submitButtonText akan dikirim dari create.blade.php atau edit.blade.php -->
        {{ $submitButtonText ?? 'Simpan Data' }}
    </button>
</div>
