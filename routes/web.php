<?php

use App\Livewire\Character;
use App\Livewire\Equipment;
use App\Livewire\Skills;
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

Route::name('characters.')->prefix('/characters')->group(function () {
    Route::name('index')->get('/', Character\Index::class);
});

Route::name('equipment.')->prefix('/equipment')->group(function () {
    Route::name('index')->get('/', Equipment\Index::class);
});

Route::name('skills.')->prefix('/skills')->group(function () {
    Route::name('index')->get('/', Skills\Index::class);
});
