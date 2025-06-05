<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiciosController;


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/servicios/update/{id}', [ServiciosController::class, 'update'])->name('servicios.update');

});

require __DIR__.'/auth.php';

include('web/home.php');
include('web/sections.php');
include('web/servicios.php');
include('web/roles.php');
include('web/users.php');
