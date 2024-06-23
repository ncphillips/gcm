<?php

use App\Livewire\Equipment;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::name('equipment.')->prefix('/equipment')->group(function () {
    Route::name('index')->get('/', Equipment\Index::class);
});
