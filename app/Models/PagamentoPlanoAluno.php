<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['plano_aluno_id', 'tipo', 'data', 'status'])]
class PagamentoPlanoAluno extends Model
{
    use HasFactory;

    /**
     * O nome da tabela associada ao model (caso o plural seja diferente do padrão Eloquent)
     */
    protected $table = 'pagamento_plano_alunos';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'data' => 'date',
        ];
    }

    /**
     * Relacionamento 1:N inverso com PlanoAluno
     */
    public function plano(): BelongsTo
    {
        return $this->belongsTo(PlanoAluno::class, 'plano_aluno_id');
    }
}
