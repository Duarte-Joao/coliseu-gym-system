<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['usuario_id', 'treino_id', 'data_inicio', 'data_fim', 'descricao'])]
class TreinoAluno extends Model
{
    use HasFactory;

    /**
     * O nome da tabela associada ao model (caso o plural seja diferente do padrão Eloquent)
     */
    protected $table = 'treino_alunos';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'data_inicio' => 'date',
            'data_fim' => 'date',
        ];
    }

    /**
     * Relacionamento 1:N inverso com User (representando o aluno)
     */
    public function aluno(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relacionamento 1:N inverso com Treino
     */
    public function treino(): BelongsTo
    {
        return $this->belongsTo(Treino::class, 'treino_id');
    }
}
