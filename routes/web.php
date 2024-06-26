<?php

use App\Livewire\Character;
use App\Livewire\Equipment;
use App\Livewire\Root;
use App\Livewire\Skills;
use Illuminate\Support\Facades\Route;

/**
 * Root
 */
Route::name('root')->get('/', Root::class);

/**
 * Characters
 */
Route::name('characters.')->prefix('/characters')->group(function () {
    Route::name('index')->get('/', Character\Index::class);
    Route::name('show')->get('/{character}', Character\Show::class);
});

/**
 * Equipment
 */
Route::name('equipment.')->prefix('/equipment')->group(function () {
    Route::name('index')->get('/', Equipment\Index::class);
});

/**
 * Skills
 */
Route::name('skills.')->prefix('/skills')->group(function () {
    Route::name('index')->get('/', Skills\Index::class);
});

/**
 * Logged In
 */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

