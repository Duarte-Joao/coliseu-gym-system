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
use Illuminate\Support\Facades\Route;

// ROTAS PÚBLICAS
Route::view('/', 'welcome')->name('home');
Route::view('/planos', 'planos')->name('planos');
Route::any('/contato', fn () => view('contato'))->name('contato');

Route::get('/login', fn () => view('login'))->name('login');

Route::post('/login', function (Request $request) {
    $dados = implode(' ', $request->all());
    if (str_contains(strtolower($dados), 'instrutor')) {
        return redirect()->route('dashboard.instrutor');
    }
    return redirect()->route('dashboard.aluno');
})->name('login.post');

Route::post('/cadastro', function (Request $request) {
    (new CreateNewUser())->create($request->all());
    return redirect()->route('dashboard.aluno');
})->name('register.post');

// DASHBOARDS
Route::get('/dashboard-aluno', fn () => view('aluno.dashboard'))->name('dashboard.aluno');
Route::get('/dashboard-instrutor', fn () => view('instrutor.dashboard'))->name('dashboard.instrutor');

// CRUD RESOURCES
Route::resource('treinos', TreinoController::class);
Route::resource('instrutores', InstrutorController::class);
Route::resource('usuarios', UserController::class);
Route::resource('plano-alunos', PlanoAlunoController::class)
    ->parameters(['plano-alunos' => 'plano']);
Route::resource('pagamento-plano-alunos', PagamentoPlanoAlunoController::class)
    ->parameters(['pagamento-plano-alunos' => 'pagamento']);
Route::resource('aulas-coletivas', AulaColetivaController::class)
    ->parameters(['aulas-coletivas' => 'aula']);
Route::resource('reserva-aulas-coletivas', ReservaAulaColetivaController::class)
    ->parameters(['reserva-aulas-coletivas' => 'reserva']);
Route::resource('treino-alunos', TreinoAlunoController::class)
    ->parameters(['treino-alunos' => 'treinoAluno']);

// ROTA PROTEGIDA (Fortify)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
