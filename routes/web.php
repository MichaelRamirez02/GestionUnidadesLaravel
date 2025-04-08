<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SectionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

include('web/sections.php');


