<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;


Route::get('/', function () {
    return redirect()->route('products.index');
});

// 2. Ini adalah rute CRUD yang sudah kita buat
// (perintah ini sudah otomatis membuatkan rute /categories, 
// /categories/create, /categories/{id}/edit, dll.)
Route::resource("categories", CategoryController::class);
Route::resource("warehouses", WarehouseController::class);
Route::resource("products", ProductController::class);

// 3. Ini adalah rute khusus untuk Stok
Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
Route::get('/stocks/transfer', [StockController::class, 'createTransfer'])->name('stocks.transfer.create');
Route::post('/stocks/transfer', [StockController::class, 'storeTransfer'])->name('stocks.transfer.store');