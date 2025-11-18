<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fish; 

class FishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rarity = $request->input('rarity');
        $fishes = Fish::byRarity($rarity)->when($request->search, fn($q,$s)=>$q->where('name','like',"%$s%"))->paginate(5);

        return view('fishes.index', compact('fishes', 'rarity'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fishes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'rarity' => 'required',
            'base_weight_min' => 'required|numeric',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|between:0.01,100',
        ]);

        Fish::create($request->all());
        return redirect()->route('fishes.index')->with('success', 'Ikan baru ditambahkan!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fish $fish)
    {
        return view('fishes.edit', compact('fish'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fish $fish)
    {
        $request->validate([
            'name' => 'required',
            'rarity' => 'required',
            'base_weight_min' => 'required|numeric',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|between:0.01,100',
        ]);

        $fish->update($request->all());
        return redirect()->route('fishes.index')->with('success', 'Data ikan diperbarui!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fish $fish)
    {
        $fish->delete();
        return redirect()->route('fishes.index')->with('success', 'Ikan dihapus!');

    }
}
