<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Cria todas as tabelas do domínio do sistema de academia.
     * Ordem de criação respeita as dependências de FK.
     */
    public function up(): void
    {
        // ---------------------------------------------------------------
        // Instrutores
        // Extensão do usuário com dados específicos do instrutor.
        // ---------------------------------------------------------------
        Schema::create('instrutores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->string('especialidade');
            $table->decimal('salario', 10, 2);
            $table->time('carga_hora');
            $table->string('turno');

            $table->timestamps();
            $table->softDeletes();
        });

        // ---------------------------------------------------------------
        // Treinos
        // Template de treino criado por um instrutor.
        // ---------------------------------------------------------------
        Schema::create('treinos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrutor_id')
                  ->constrained('instrutores')
                  ->cascadeOnDelete();
            $table->string('nome');
            $table->text('obs')->nullable();
            $table->json('exercicios');

            $table->timestamps();
            $table->softDeletes();
        });

        // ---------------------------------------------------------------
        // Treino × Aluno (atribuição de treino ao aluno)
        // Relacionamento N:N resolvido com tabela associativa.
        // ---------------------------------------------------------------
        Schema::create('treino_alunos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->foreignId('treino_id')
                  ->constrained('treinos')
                  ->cascadeOnDelete();
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->string('descricao')->nullable();

            $table->timestamps();
        });

        // ---------------------------------------------------------------
        // Planos de Aluno
        // Cada aluno pode ter múltiplos planos ao longo do tempo (1:N).
        // ---------------------------------------------------------------
        Schema::create('plano_alunos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->string('tipo');
            $table->decimal('valor', 10, 2);
            $table->integer('duracao_meses');
            $table->date('data_inicio');
            $table->date('data_fim');

            $table->timestamps();
            $table->softDeletes();
        });

        // ---------------------------------------------------------------
        // Pagamentos de Plano
        // Cada plano gera múltiplos pagamentos (parcelas mensais) (1:N).
        // usuario_id removido — acessível via plano_aluno.usuario_id.
        // ---------------------------------------------------------------
        Schema::create('pagamento_plano_alunos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plano_aluno_id')
                  ->constrained('plano_alunos')
                  ->cascadeOnDelete();
            $table->string('metodo_pagamento');
            $table->date('data');
            $table->string('status')->default('pendente');

            $table->timestamps();
        });

        // ---------------------------------------------------------------
        // Aulas Coletivas
        // Aula ministrada por um instrutor com vagas limitadas.
        // ---------------------------------------------------------------
        Schema::create('aulas_coletivas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrutor_id')
                  ->constrained('instrutores')
                  ->cascadeOnDelete();
            $table->dateTime('datahora');
            $table->integer('vagas');
            $table->text('obs')->nullable();
            $table->string('status')->default('agendada');
            $table->string('modalidade');

            $table->timestamps();
            $table->softDeletes();
        });

        // ---------------------------------------------------------------
        // Reservas de Aula Coletiva
        // Aluno reserva vaga em uma aula coletiva.
        // ---------------------------------------------------------------
        Schema::create('reserva_aula_coletivas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aula_coletiva_id')
                  ->constrained('aulas_coletivas')
                  ->cascadeOnDelete();
            $table->foreignId('usuario_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->string('status')->default('confirmada');

            $table->timestamps();

            // Impede reserva duplicada do mesmo aluno na mesma aula
            $table->unique(['aula_coletiva_id', 'usuario_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * Drop na ordem inversa para respeitar dependências de FK.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva_aula_coletivas');
        Schema::dropIfExists('aulas_coletivas');
        Schema::dropIfExists('pagamento_plano_alunos');
        Schema::dropIfExists('plano_alunos');
        Schema::dropIfExists('treino_alunos');
        Schema::dropIfExists('treinos');
        Schema::dropIfExists('instrutores');
    }
};
