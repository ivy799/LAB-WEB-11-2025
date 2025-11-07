<?php

namespace App\Http\Requests;

use App\Models\Fish;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; 

class FishRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'rarity' => ['required', Rule::in(Fish::RARITIES)],
            'base_weight_min' => ['required', 'numeric', 'min:0.01'],
            'base_weight_max' => ['required', 'numeric', 'gt:base_weight_min'],
            'sell_price_per_kg' => ['required', 'integer', 'min:1'],
            'catch_probability' => ['required', 'numeric', 'between:0.01,100.00'],
            'description' => ['nullable', 'string'],
        ];
    }

    
    public function messages(): array
    {
        return [
            'name.required' => 'Nama ikan wajib diisi.',
            'rarity.required' => 'Rarity wajib dipilih.',
            'rarity.in' => 'Rarity yang dipilih tidak valid.',
            'base_weight_min.required' => 'Berat minimum wajib diisi.',
            'base_weight_max.required' => 'Berat maksimum wajib diisi.',
            'base_weight_max.gt' => 'Berat maksimum harus lebih besar dari berat minimum.',
            'sell_price_per_kg.required' => 'Harga jual wajib diisi.',
            'catch_probability.required' => 'Peluang tangkap wajib diisi.',
            'catch_probability.between' => 'Peluang tangkap harus antara 0.01 dan 100.',
        ];
    }
}
