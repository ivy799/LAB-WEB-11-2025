<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/destinasi', 'destinasi')->name('destinasi');
Route::view('/kuliner', 'kuliner')->name('kuliner');
Route::view('/galeri', 'galeri')->name('galeri');
Route::view('/kontak', 'kontak')->name('kontak');
Route::view('/event', 'event')->name('event');
Route::view('/peta', 'peta')->name('peta');



