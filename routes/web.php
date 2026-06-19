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
use App\Models\PlanoAluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ROTAS PÚBLICAS
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

Route::get('/login', fn () => view('login'))->name('login');
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);
    
    if (Auth::attempt($credentials, $request->has('remember'))) {
        $request->session()->regenerate();
        $user = Auth::user();
        return $user->tipo === 'instrutor' 
            ? redirect()->route('dashboard.instrutor')
            : redirect()->route('dashboard.aluno');
    }
    
    return back()->withErrors([
        'email' => 'E-mail ou senha incorretos.'
    ])->onlyInput('email');
})->name('login.post');

Route::post('/cadastro', function (Request $request) {
    $user = (new CreateNewUser())->create($request->all());
    Auth::login($user);
    $request->session()->regenerate();
    return redirect()->route('dashboard.aluno');
})->name('register.post');

// DASHBOARDS (PROTEGIDOS)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard-aluno', function () {
        $user = Auth::user();
        $treinos = $user->treinoAlunos()->with('treino.instrutor.usuario')->get();
        return view('aluno.dashboard', compact('treinos'));
    })->name('dashboard.aluno');
    
    Route::get('/dashboard-instrutor', function () {
        $user = Auth::user();
        $instrutorData = $user->instrutor;
        $treinos = $instrutorData ? $instrutorData->treinos()->latest()->get() : collect();
        return view('instrutor.dashboard', compact('instrutorData', 'treinos'));
    })->name('dashboard.instrutor');
});

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
Route::get('treino-alunos/{treinoAluno}/pdf', [TreinoAlunoController::class, 'pdf'])
    ->name('treino-alunos.pdf');
Route::resource('treino-alunos', TreinoAlunoController::class)
    ->parameters(['treino-alunos' => 'treinoAluno']);

// ROTA PROTEGIDA (Fortify)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
