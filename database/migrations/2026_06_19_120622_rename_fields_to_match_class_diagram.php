<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('cpf', 'rg');
        });
        Schema::table('treinos', function (Blueprint $table) {
            $table->renameColumn('obs', 'descricao');
        });
        Schema::table('treino_alunos', function (Blueprint $table) {
            $table->renameColumn('data_inicio', 'validade');
        });
        Schema::table('pagamento_plano_alunos', function (Blueprint $table) {
            $table->renameColumn('metodo_pagamento', 'tipo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('rg', 'cpf');
        });
        Schema::table('treinos', function (Blueprint $table) {
            $table->renameColumn('descricao', 'obs');
        });
        Schema::table('treino_alunos', function (Blueprint $table) {
            $table->renameColumn('validade', 'data_inicio');
        });
        Schema::table('pagamento_plano_alunos', function (Blueprint $table) {
            $table->renameColumn('tipo', 'metodo_pagamento');
        });
    }
};
