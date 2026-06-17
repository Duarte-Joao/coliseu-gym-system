<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// ROTAS PÚBLICAS
Route::view('/', 'welcome')->name('home');
Route::view('/planos', 'planos')->name('planos');

Route::any('/contato', function () {
    return view('contato');
})->name('contato');

Route::get('/login', function () {
    return view('login');
})->name('login');


// 🔀 REDIRECIONAMENTO INTELIGENTE (Separa Aluno e Instrutor pelos dados digitados)
Route::post('/login', function (Request $request) { 
    // Junta todos os valores preenchidos no formulário para varredura
    $dadosFormulario = implode(' ', $request->all());

    // Se o usuário digitou a palavra 'instrutor' no e-mail ou login, vai para o Instrutor
    if (str_contains(strtolower($dadosFormulario), 'instrutor')) {
        return redirect()->route('dashboard.instrutor');
    }

    // Caso contrário, vai para o painel do aluno padrão
    return redirect()->route('dashboard.aluno');
})->name('login.post');

Route::post('/cadastro', function () { 
    return redirect()->route('dashboard.aluno');
})->name('register.post');


// 🏠 PAINEL DO ALUNO (Visualização Livre para Testes)
Route::get('/dashboard-aluno', function () {
    return view('aluno.dashboard');
})->name('dashboard.aluno');


// 🏋️‍♂️ PAINEL DO INSTRUTOR (Visualização Livre para Testes)
Route::get('/dashboard-instrutor', function () {
    return view('instrutor.dashboard');
})->name('dashboard.instrutor');


// ROTAS PROTEGIDAS (Middleware do Laravel)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';