<?php

use App\Http\Controllers\AulaColetivaController;
use App\Http\Controllers\InstrutorController;
use App\Http\Controllers\PagamentoPlanoAlunoController;
use App\Http\Controllers\PlanoAlunoController;
use App\Http\Controllers\ReservaAulaColetivaController;
use App\Http\Controllers\TreinoAlunoController;
use App\Http\Controllers\TreinoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('usuarios', UserController::class);
Route::apiResource('instrutores', InstrutorController::class);
Route::apiResource('treinos', TreinoController::class);
Route::apiResource('treino-alunos', TreinoAlunoController::class);
Route::apiResource('plano-alunos', PlanoAlunoController::class);
Route::apiResource('pagamento-plano-alunos', PagamentoPlanoAlunoController::class);
Route::apiResource('aulas-coletivas', AulaColetivaController::class);
Route::apiResource('reserva-aulas-coletivas', ReservaAulaColetivaController::class);
