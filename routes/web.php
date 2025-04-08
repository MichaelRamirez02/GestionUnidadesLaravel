<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SectionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'Index']);
Route::get('/sections', [SectionsController::class, 'Index'])->name("sections.index");

