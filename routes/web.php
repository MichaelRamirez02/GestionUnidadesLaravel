<?php

use App\Http\Controllers\LandlordsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/landlords',[LandlordsController::class,'index'])->name('landlords.index');
