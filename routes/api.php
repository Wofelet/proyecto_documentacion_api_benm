<?php

use App\Http\Controllers\PersonaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/obtener/{id}',[PersonaController::class,"obtener"]);
Route::post('/guardar',[PersonaController::class,"guardar"]);
Route::patch('/actualizar',[PersonaController::class,"actualizar"]);
Route::delete('/eliminar',[PersonaController::class,"eliminar"]);