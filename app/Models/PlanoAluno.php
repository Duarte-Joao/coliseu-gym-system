<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['usuario_id', 'tipo', 'valor', 'duracao_meses', 'data_inicio', 'data_fim'])]
class PlanoAluno extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * O nome da tabela associada ao model (caso o plural seja diferente do padrão Eloquent)
     */
    protected $table = 'plano_alunos';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'valor' => 'decimal:2',
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
     * Relacionamento 1:N com pagamentos vinculados a este plano
     */
    public function pagamentos(): HasMany
    {
        return $this->hasMany(PagamentoPlanoAluno::class, 'plano_aluno_id');
    }
}
