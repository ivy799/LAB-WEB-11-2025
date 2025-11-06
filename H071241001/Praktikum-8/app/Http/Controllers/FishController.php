<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;

class FishController extends Controller
{
    private $rarities = [
        'Common', 'Uncommon', 'Rare', 'Epic',
        'Legendary', 'Mythic', 'Secret'
    ];

    public function index(Request $request)
    {
        $query = Fish::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        
        $query->rarityFilter($request->rarity);

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'sell_price_per_kg', 'catch_probability', 'rarity'])) {
            $query->orderBy($sort, $direction);
        } else {
             $query->latest(); 
        }
        
        $fishes = $query->paginate(10); 
        
        $rarities = $this->rarities;
        
        return view('fishes.index', compact('fishes', 'rarities', 'sort', 'direction'));
    }

   
    public function create()
    {
        $rarities = $this->rarities;
        return view('fishes.create', compact('rarities'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:fishes,name',
            'rarity' => 'required|in:' . implode(',', $this->rarities),
            'base_weight_min' => 'required|numeric|min:0.01',
            // Berat maksimum harus lebih besar dari minimum
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:1',
            // Peluang tangkap antara 0.01% - 100%
            'catch_probability' => 'required|numeric|between:0.01,100.00', 
            'description' => 'nullable|string',
        ]);

        Fish::create($request->all());

        return redirect()->route('fishes.index')
            ->with('success', 'Ikan baru berhasil ditambahkan!');
    }

    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }


    public function edit(Fish $fish)
    {
        $rarities = $this->rarities;
        return view('fishes.edit', compact('fish', 'rarities'));
    }

    public function update(Request $request, Fish $fish)
    {
        // Validasi input
        $request->validate([
            // unique:fishes,name harus mengecualikan ID ikan saat ini
            'name' => 'required|string|max:100|unique:fishes,name,' . $fish->id,
            'rarity' => 'required|in:' . implode(',', $this->rarities),
            'base_weight_min' => 'required|numeric|min:0.01',
            // Berat maksimum harus lebih besar dari minimum
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:1',
            // Peluang tangkap antara 0.01% - 100%
            'catch_probability' => 'required|numeric|between:0.01,100.00', 
            'description' => 'nullable|string',
        ]);
        
        $fish->update($request->all());
        
        return redirect()->route('fishes.index')
            ->with('success', 'Data ikan berhasil diperbarui!');
    }


    public function destroy(Fish $fish)
    {
        $fish->delete();
        
        return redirect()->route('fishes.index')
            ->with('success', 'Data ikan berhasil dihapus!');
    }
}