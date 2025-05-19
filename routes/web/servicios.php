<?php

use App\Http\Controllers\ServiciosController;
use App\Http\Middleware\AuthorizedMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/servicios', [ServiciosController::class, 'index'])
     ->name('servicios.index')
     ->middleware(AuthorizedMiddleware::class . ':Servicios.showServicios');

Route::get('/servicios/create', [ServiciosController::class, 'create'])
     ->name('servicios.create')
     ->middleware(AuthorizedMiddleware::class . ':Servicios.createServicios');


Route::get('/servicios/edit/{id}', [ServiciosController::class, 'edit'])
     ->name('servicios.edit')
     ->middleware(AuthorizedMiddleware::class . ':Servicios.updateServicios');


Route::delete('/servicios/delete/{id}', [ServiciosController::class, 'delete'])
     ->name('servicios.delete')
     ->middleware(AuthorizedMiddleware::class . ':Servicios.deleteServicios');


Route::post('/servicios/store', [ServiciosController::class, 'store'])
     ->name('servicios.store')
     ->middleware(AuthorizedMiddleware::class . ':Servicios.createServicios');


Route::put('/servicios/update', [ServiciosController::class, 'update'])
     ->name('servicios.update')
     ->middleware(AuthorizedMiddleware::class . ':Servicios.updateServicios');

