@csrf

<div class="mb-3">
    <label>Nama Ikan</label>
    <input type="text" name="name" value="{{ old('name', $fish->name ?? '') }}" class="form-control">
    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
    <label>Rarity</label>
    <select name="rarity" class="form-select">
        <option value="">-- Pilih Rarity --</option>
        @foreach ($rarities as $r)
            <option value="{{ $r }}" {{ old('rarity', $fish->rarity ?? '') == $r ? 'selected' : '' }}>{{ $r }}</option>
        @endforeach
    </select>
    @error('rarity') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label>Berat Minimum (kg)</label>
        <input type="number" step="0.01" name="base_weight_min" value="{{ old('base_weight_min', $fish->base_weight_min ?? '') }}" class="form-control">
        @error('base_weight_min') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label>Berat Maksimum (kg)</label>
        <input type="number" step="0.01" name="base_weight_max" value="{{ old('base_weight_max', $fish->base_weight_max ?? '') }}" class="form-control">
        @error('base_weight_max') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
</div>

<div class="mb-3">
    <label>Harga per kg</label>
    <input type="number" name="sell_price_per_kg" value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg ?? '') }}" class="form-control">
    @error('sell_price_per_kg') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
    <label>Catch Probability (%)</label>
    <input type="number" step="0.01" name="catch_probability" value="{{ old('catch_probability', $fish->catch_probability ?? '') }}" class="form-control">
    @error('catch_probability') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $fish->description ?? '') }}</textarea>
</div>

<button type="submit" class="btn btn-success">Simpan</button>
<a href="{{ route('fishes.index') }}" class="btn btn-secondary">Kembali</a>
