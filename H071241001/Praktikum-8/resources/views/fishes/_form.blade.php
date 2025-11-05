<div class="mb-3">
    <label for="name" class="form-label">Nama Ikan <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $fish->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="rarity" class="form-label">Rarity <span class="text-danger">*</span></label>
    <select class="form-select @error('rarity') is-invalid @enderror" id="rarity" name="rarity" required>
        <option value="">Pilih Rarity</option>
        {{-- Dropdown 7 Tingkat Rarity --}}
        @foreach($rarities as $rarity)
            <option value="{{ $rarity }}" {{ old('rarity', $fish->rarity ?? '') == $rarity ? 'selected' : '' }}>
                {{ $rarity }}
            </option>
        @endforeach
    </select>
    @error('rarity')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="base_weight_min" class="form-label">Berat Minimum (kg) <span class="text-danger">*</span></label>
        <input type="number" step="0.01" class="form-control @error('base_weight_min') is-invalid @enderror" id="base_weight_min" name="base_weight_min" value="{{ old('base_weight_min', $fish->base_weight_min ?? '') }}" required min="0.01">
        @error('base_weight_min')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="base_weight_max" class="form-label">Berat Maksimum (kg) <span class="text-danger">*</span></label>
        {{-- Validasi: Berat maksimum harus lebih besar dari minimum akan ditangani di Controller --}}
        <input type="number" step="0.01" class="form-control @error('base_weight_max') is-invalid @enderror" id="base_weight_max" name="base_weight_max" value="{{ old('base_weight_max', $fish->base_weight_max ?? '') }}" required>
        @error('base_weight_max')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="sell_price_per_kg" class="form-label">Harga Jual per kg (Coins) <span class="text-danger">*</span></label>
        <input type="number" class="form-control @error('sell_price_per_kg') is-invalid @enderror" id="sell_price_per_kg" name="sell_price_per_kg" value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg ?? '') }}" required min="1">
        @error('sell_price_per_kg')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="catch_probability" class="form-label">Peluang Tertangkap (%) <span class="text-danger">*</span></label>
        {{-- Validasi: Peluang tangkap antara 0.01% - 100% --}}
        <input type="number" step="0.01" class="form-control @error('catch_probability') is-invalid @enderror" id="catch_probability" name="catch_probability" value="{{ old('catch_probability', $fish->catch_probability ?? '') }}" required min="0.01" max="100.00">
        @error('catch_probability')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Deskripsi</label>
    {{-- Field ini boleh kosong (NULLABLE) --}}
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $fish->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
<a href="{{ route('fishes.index') }}" class="btn btn-secondary">Batal</a>