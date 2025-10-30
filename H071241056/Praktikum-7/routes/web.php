<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HalamanController;

Route::get('/', [HalamanController::class, 'home'])->name('home');
Route::get('/destinasi', [HalamanController::class, 'destinasi'])->name('destinasi');
Route::get('/kuliner', [HalamanController::class, 'kuliner'])->name('kuliner');
Route::get('/galeri', [HalamanController::class, 'galeri'])->name('galeri');
Route::get('/kontak', [HalamanController::class, 'kontak'])->name('kontak');

Route::post('/kontak', [HalamanController::class, 'kirimPesan'])->name('kirim.pesan');
