<?php

use App\Http\Controllers\HomeController;
use App\Http\Middleware\AuthorizedMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
     ->name('home.index')
     ->middleware(AuthorizedMiddleware::class);

Route::get('/home/section/{id}', [HomeController::class, 'section'])
     ->name('home.section')
     ->middleware(AuthorizedMiddleware::class);

Route::get('/home/servicios/{id}', [HomeController::class, 'servicios'])
     ->name('home.servicios')
     ->middleware(AuthorizedMiddleware::class);

Route::get('/home/servicio/{id}', [HomeController::class, 'servicios'])->name('home.servicio');

