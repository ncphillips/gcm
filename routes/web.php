<?php

use App\Http\Controllers\EquipmentController;
use App\Livewire\EquipmentIndex;
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


Route::name('equipment.')->prefix('/equipment')->group(function() {
    Route::name('index')->get('/', EquipmentIndex::class);
});
