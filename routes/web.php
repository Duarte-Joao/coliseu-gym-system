<?php

use App\Actions\CreateNewUser;
use App\Http\Controllers\AlunoDashboardController;
use App\Http\Controllers\AulaColetivaController;
use App\Http\Controllers\InstrutorController;
use App\Http\Controllers\InstrutorDashboardController;
use App\Http\Controllers\PagamentoPlanoAlunoController;
use App\Http\Controllers\PlanoAlunoController;
use App\Http\Controllers\ReservaAulaColetivaController;
use App\Http\Controllers\TreinadorAlunosController;
use App\Http\Controllers\TreinadorAlunosPdfController;
use App\Http\Controllers\TreinadorDashboardController;
use App\Http\Controllers\TreinadorPerfilController;
use App\Http\Controllers\TreinoAlunoController;
use App\Http\Controllers\TreinoController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ── PÁGINAS PÚBLICAS ────────────────────────────────────────
Route::view('/', 'welcome')->name('home');
Route::get('/planos', function () {
    $planosDisponiveis = [
        (object)[
            'id' => 1,
            'tipo' => 'Mensal',
            'valor' => 119.90,
            'duracao_meses' => 1,
            'valor_mes' => 119.90,
            'featured' => false,
            'descricao' => 'Adesão padrão de 1 mês',
            'beneficios' => [
                'Acesso total à musculação',
                'Livre escolha de horários',
                'Sem fidelidade ou contrato',
                'Renovação mensal opcional'
            ]
        ],
        (object)[
            'id' => 2,
            'tipo' => 'Trimestral',
            'valor' => 299.90,
            'duracao_meses' => 3,
            'valor_mes' => 99.97,
            'featured' => false,
            'descricao' => 'Equivale a R$ 99,97/mês',
            'beneficios' => [
                'Acesso total à musculação',
                'Válido por 3 meses corridos',
                'Avaliação física inclusa',
                'Economia garantida'
            ]
        ],
        (object)[
            'id' => 3,
            'tipo' => 'Semestral',
            'valor' => 539.90,
            'duracao_meses' => 6,
            'valor_mes' => 89.98,
            'featured' => true,
            'descricao' => 'Equivale a R$ 89,98/mês',
            'beneficios' => [
                'Acesso a todas as áreas (Geral)',
                'Válido por 6 meses corridos',
                '2 avaliações físicas completas',
                'Suporte com instrutor de elite',
                'Brinde: Coqueteleira Coliseu'
            ]
        ],
        (object)[
            'id' => 4,
            'tipo' => 'Anual',
            'valor' => 959.90,
            'duracao_meses' => 12,
            'valor_mes' => 79.99,
            'featured' => false,
            'descricao' => 'Equivale a R$ 79,99/mês',
            'beneficios' => [
                'Acesso total 365 dias no ano',
                'Válido por 12 meses corridos',
                'Avaliações físicas bimestrais',
                'Acesso prioritário a eventos',
                'Maior desconto da casa'
            ]
        ]
    ];
    return view('planos', compact('planosDisponiveis'));
})->name('planos');
Route::any('/contato', fn () => view('contato'))->name('contato');

// ── LOGIN / LOGOUT / CADASTRO ───────────────────────────────
Route::get('/login', fn () => view('login'))->name('login');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        $tipo = Auth::user()->tipo;

        if ($tipo === 'admin') {
            return redirect()->route('dashboard.admin');
        }
        if ($tipo === 'instrutor') {
            return redirect()->route('dashboard.treinador');
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

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');

// ── ROTAS AUTENTICADAS ───────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboards
    Route::get('/dashboard-aluno',     AlunoDashboardController::class)->name('dashboard.aluno');
    Route::get('/dashboard-admin',     InstrutorDashboardController::class)->middleware('role:admin')->name('dashboard.admin');
    Route::get('/dashboard-treinador', TreinadorDashboardController::class)->middleware('role:instrutor')->name('dashboard.treinador');
    Route::get('/treinador/alunos',     TreinadorAlunosController::class)->middleware('role:instrutor')->name('treinador.alunos');
    Route::get('/treinador/alunos/pdf', TreinadorAlunosPdfController::class)->middleware('role:instrutor')->name('treinador.alunos.pdf');
    Route::get('/treinador/perfil',    TreinadorPerfilController::class)->middleware('role:instrutor')->name('treinador.perfil');

    // PDF exports
    Route::get('treinos/{treino}/pdf',             [TreinoController::class, 'pdf'])->name('treinos.pdf');
    Route::get('plano-alunos/{plano}/pdf',         [PlanoAlunoController::class, 'pdf'])->name('plano-alunos.pdf');
    Route::get('pagamento-plano-alunos/pdf',       [PagamentoPlanoAlunoController::class, 'pdf'])->name('pagamento-plano-alunos.pdf');
    Route::get('treino-alunos/{treinoAluno}/pdf',  [TreinoAlunoController::class, 'pdf'])->name('treino-alunos.pdf');

    // CRUD de cada módulo
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
    Route::patch('pagamento-plano-alunos/{pagamento}/pagar', [PagamentoPlanoAlunoController::class, 'pagar'])
        ->name('pagamento-plano-alunos.pagar');
    Route::resource('pagamento-plano-alunos', PagamentoPlanoAlunoController::class)
        ->parameters(['pagamento-plano-alunos' => 'pagamento']);
});

