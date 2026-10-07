<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SenhaController;

Route::get('/healthz', function () {
    return response()->json(['status' => 'ok'], 200);
});

Route::post('/senhas', [SenhaController::class, 'emitir']);
Route::get('/senhas/proxima', [SenhaController::class, 'proxima']);
Route::post('/senhas/{codigo}/concluir', [SenhaController::class, 'concluir']);
Route::post('/senhas/{codigo}/rechamar', [SenhaController::class, 'rechamar']);
Route::post('/senhas/{codigo}/cancelar', [SenhaController::class, 'cancelar']);
Route::get('/painel', [SenhaController::class, 'painel']);
