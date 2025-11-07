<?php

use App\Http\Controllers\FishController;
use Illuminate\Support\Facades\Route;



// Arahkan halaman utama (/) ke halaman index ikan
Route::get('/', function () {
    return redirect()->route('fishes.index');
});

// Route::resource() otomatis membuatkan 7 route untuk CRUD:
// GET /fishes -> index()
// GET /fishes/create -> create()
// POST /fishes -> store()
// GET /fishes/{fish} -> show()
// GET /fishes/{fish}/edit -> edit()
// PUT/PATCH /fishes/{fish} -> update()
// DELETE /fishes/{fish} -> destroy()
Route::resource('fishes', FishController::class);
