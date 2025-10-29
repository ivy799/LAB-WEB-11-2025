<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

// Halaman utama
Route::get('/', [PageController::class, 'home']);
Route::get('/home', [PageController::class, 'home']);

// Halaman lain
Route::get('/destinasi', [PageController::class, 'destinasi']);
Route::get('/kuliner', [PageController::class, 'kuliner']);
Route::get('/galeri', [PageController::class, 'galeri']);
Route::get('/kontak', [PageController::class, 'kontak']);

// ATAU
// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home');
// });

// Route::get('/home', function () {
//     return view('home');
// });

// Route::get('/destinasi', function () {
//     return view('destinasi');
// });

// Route::get('/kuliner', function () {
//     return view('kuliner');
// });

// Route::get('/galeri', function () {
//     return view('galeri');
// });

// Route::get('/kontak', function () {
//     return view('kontak');
// });
