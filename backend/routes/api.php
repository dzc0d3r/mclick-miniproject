<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:sanctum'])->group(function () {
    // Agenda routes
    Route::get('/agendas', [AgendaController::class, 'index']);
    Route::post('/agendas', [AgendaController::class, 'store']);
    Route::post('/agendas/{agenda}/share', [AgendaController::class, 'share']);
    Route::delete('/agendas/{agenda}', [AgendaController::class, 'destroy']);
    Route::get('/agendas/{agenda}', [AgendaController::class, 'show']);
    Route::put('/agendas/{agenda}', [AgendaController::class, 'update']);
});