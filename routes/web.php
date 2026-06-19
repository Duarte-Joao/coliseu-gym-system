<?php

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\AlunoDashboardController;
use App\Http\Controllers\AulaColetivaController;
use App\Http\Controllers\InstrutorController;
use App\Http\Controllers\InstrutorDashboardController;
use App\Http\Controllers\PagamentoPlanoAlunoController;
use App\Http\Controllers\PlanoAlunoController;
use App\Http\Controllers\ReservaAulaColetivaController;
use App\Http\Controllers\TreinoAlunoController;
use App\Http\Controllers\TreinoController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ── PÁGINAS PÚBLICAS ────────────────────────────────────────
Route::view('/', 'welcome')->name('home');
Route::view('/planos', 'planos')->name('planos');
Route::any('/contato', fn () => view('contato'))->name('contato');

// ── LOGIN / CADASTRO ────────────────────────────────────────
Route::get('/login', fn () => view('login'))->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        $tipo = Auth::user()->tipo;

        if ($tipo === 'instrutor' || $tipo === 'admin') {
            return redirect()->route('dashboard.instrutor');
        }
        return redirect()->route('dashboard.aluno');
    }

    return back()
        ->withErrors(['email' => 'E-mail ou senha incorretos.'])
        ->withInput($request->only('email'));
})->name('login.post');

Route::post('/cadastro', function (Request $request) {
    (new CreateNewUser())->create($request->all());
    return redirect()->route('login')->with('success', 'Conta criada com sucesso! Faça login.');
})->name('register.post');

// ── DASHBOARDS ──────────────────────────────────────────────
Route::get('/dashboard-aluno',    AlunoDashboardController::class)->name('dashboard.aluno');
Route::get('/dashboard-instrutor', InstrutorDashboardController::class)->name('dashboard.instrutor');

// ── RECURSOS (CRUD completo de cada módulo) ─────────────────
Route::resource('usuarios',               UserController::class);
Route::resource('instrutores',            InstrutorController::class)
    ->parameters(['instrutores' => 'instrutor']);
Route::resource('treinos',                TreinoController::class);
Route::resource('treino-alunos',          TreinoAlunoController::class)
    ->parameters(['treino-alunos' => 'treinoAluno']);
Route::resource('aulas-coletivas',        AulaColetivaController::class)
    ->parameters(['aulas-coletivas' => 'aula']);
Route::resource('reserva-aulas-coletivas', ReservaAulaColetivaController::class)
    ->parameters(['reserva-aulas-coletivas' => 'reserva']);
Route::resource('plano-alunos',           PlanoAlunoController::class)
    ->parameters(['plano-alunos' => 'plano']);
Route::resource('pagamento-plano-alunos', PagamentoPlanoAlunoController::class)
    ->parameters(['pagamento-plano-alunos' => 'pagamento']);

require __DIR__.'/settings.php';
