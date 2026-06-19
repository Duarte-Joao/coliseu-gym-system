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
        Schema::table('pagamento_plano_alunos', function (Blueprint $table) {
            $table->enum('metodo_pagamento', ['Pix', 'Cartão de Crédito', 'Cartão de Débito', 'Dinheiro', 'Boleto'])
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('pagamento_plano_alunos', function (Blueprint $table) {
            $table->string('metodo_pagamento')->change();
        });
    }
};
