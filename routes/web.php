<?php

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\AulaColetivaController;
use App\Http\Controllers\InstrutorController;
use App\Http\Controllers\PagamentoPlanoAlunoController;
use App\Http\Controllers\PlanoAlunoController;
use App\Http\Controllers\ReservaAulaColetivaController;
use App\Http\Controllers\TreinoAlunoController;
use App\Http\Controllers\TreinoController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Http\Controllers\InstrutorDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InstrutorController;
use App\Http\Controllers\TreinoController;
use App\Http\Controllers\TreinoAlunoController;
use App\Http\Controllers\AulaColetivaController;
use App\Http\Controllers\ReservaAulaColetivaController;
use App\Http\Controllers\PlanoAlunoController;
use App\Http\Controllers\PagamentoPlanoAlunoController;

// ── PÁGINAS PÚBLICAS ────────────────────────────────────────
Route::view('/', 'welcome')->name('home');
Route::view('/planos', 'planos')->name('planos');
Route::any('/contato', fn () => view('contato'))->name('contato');

Route::any('/contato', function () {
    return view('contato');
})->name('contato');

// ── LOGIN ───────────────────────────────────────────────────
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $dadosFormulario = implode(' ', $request->all());

    if (str_contains(strtolower($dadosFormulario), 'instrutor')) {
        return redirect()->route('dashboard.instrutor');
    }

    return redirect()->route('dashboard.aluno');
})->name('login.post');

Route::post('/cadastro', function () {
    return redirect()->route('dashboard.aluno');
})->name('register.post');

// ── DASHBOARDS ──────────────────────────────────────────────
Route::get('/dashboard-aluno', function () {
    return view('aluno.dashboard');
})->name('dashboard.aluno');

Route::get('/dashboard-instrutor', InstrutorDashboardController::class)
    ->name('dashboard.instrutor');

// ── RECURSOS (CRUD completo de cada módulo) ─────────────────
Route::resource('usuarios',               UserController::class);
Route::resource('instrutores',            InstrutorController::class);
Route::resource('treinos',                TreinoController::class);
Route::resource('treino-alunos',          TreinoAlunoController::class);
Route::resource('aulas-coletivas',        AulaColetivaController::class);
Route::resource('reserva-aulas-coletivas', ReservaAulaColetivaController::class);
Route::resource('plano-alunos',           PlanoAlunoController::class);
Route::resource('pagamento-plano-alunos', PagamentoPlanoAlunoController::class);

require __DIR__.'/settings.php';
