<?php

use App\Http\Controllers\ServiciosController;
use App\Http\Middleware\AuthorizedMiddleware;
use Illuminate\Support\Facades\Route;

// Mostrar todos los servicios
Route::get('/servicios', [ServiciosController::class, 'index'])
     ->name('servicios.index')
     ->middleware(AuthorizedMiddleware::class . ':Servicios.showServicios');

// Crear nuevo servicio
Route::get('/servicios/create', [ServiciosController::class, 'create'])
     ->name('servicios.create')
     ->middleware(AuthorizedMiddleware::class . ':Servicios.createServicios');

// Editar un servicio específico
Route::get('/servicios/edit/{id}', [ServiciosController::class, 'edit'])
     ->name('servicios.edit')
     ->middleware(AuthorizedMiddleware::class . ':Servicios.updateServicios');

// Eliminar un servicio
Route::delete('/servicios/delete/{id}', [ServiciosController::class, 'delete'])
     ->name('servicios.delete')
     ->middleware(AuthorizedMiddleware::class . ':Servicios.deleteServicios');

// Guardar un nuevo servicio
Route::post('/servicios/store', [ServiciosController::class, 'store'])
     ->name('servicios.store')
     ->middleware(AuthorizedMiddleware::class . ':Servicios.createServicios');

// Actualizar un servicio existente
Route::put('/servicios/update/{id}', [ServiciosController::class, 'update'])
     ->name('servicios.update')
     ->middleware(AuthorizedMiddleware::class . ':Servicios.updateServicios');


