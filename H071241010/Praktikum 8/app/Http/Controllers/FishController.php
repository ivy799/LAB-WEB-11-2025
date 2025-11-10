<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use App\Http\Requests\FishRequest;

class FishController extends Controller
{
    public function index()
    {
        $fishes = Fish::latest()
            ->filter(request(['rarity', 'search']))
            ->paginate(10)
            ->withQueryString(); 

        return view('fishes.index', [
            'fishes' => $fishes,
            'rarities' => Fish::RARITIES 
        ]);
    }

    /**
     * Menampilkan form untuk menambah ikan baru.
     */
    public function create()
    {
        return view('fishes.create', [
            'rarities' => Fish::RARITIES 
        ]);
    }

   
    public function store(FishRequest $request)
    {
        Fish::create($request->validated());

        return redirect()->route('fishes.index')
            ->with('success', 'Ikan baru berhasil ditambahkan!');
    }

    
    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }

    
    public function edit(Fish $fish)
    {
        return view('fishes.edit', [
            'fish' => $fish,
            'rarities' => Fish::RARITIES
        ]);
    }

    /**
     * Mengupdate data ikan di database.
     */
    public function update(FishRequest $request, Fish $fish)
    {
        $fish->update($request->validated());

        return redirect()->route('fishes.show', $fish)
            ->with('success', 'Data ikan berhasil diperbarui!');
    }

    /**
     * Menghapus data ikan dari database.
     */
    public function destroy(Fish $fish)
    {
        $fish->delete();

        return redirect()->route('fishes.index')
            ->with('success', 'Data ikan berhasil dihapus.');
    }
}
