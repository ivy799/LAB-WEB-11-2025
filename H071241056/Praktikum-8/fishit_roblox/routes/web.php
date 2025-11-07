<?php

use App\Http\Controllers\FishController;
use Illuminate\Support\Facades\Route;


Route::get('/', [FishController::class, 'index'])-> name('home');

Route::resource('fishes', FishController::class);