<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedanController;

Route::get('/', [MedanController::class, 'home'])->name('home');
Route::get('/destinasi', [MedanController::class, 'destinasi'])->name('destinasi');
Route::get('/kuliner', [MedanController::class, 'kuliner'])->name('kuliner');
Route::get('/galeri', [MedanController::class, 'galeri'])->name('galeri');
Route::get('/kontak', [MedanController::class, 'kontak'])->name('kontak');
