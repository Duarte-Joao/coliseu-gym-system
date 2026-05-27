<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['instrutor_id', 'datahora', 'vagas', 'obs', 'status', 'modalidade'])]
class AulaColetiva extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * O nome da tabela associada ao model (caso o plural seja diferente do padrão Eloquent)
     */
    protected $table = 'aulas_coletivas';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'datahora' => 'datetime',
        ];
    }

    /**
     * Relacionamento 1:N inverso com Instrutor (ministrante da aula coletiva)
     */
    public function instrutor(): BelongsTo
    {
        return $this->belongsTo(Instrutor::class, 'instrutor_id');
    }

    /**
     * Relacionamento 1:N com reservas feitas para esta aula
     */
    public function reservas(): HasMany
    {
        return $this->hasMany(ReservaAulaColetiva::class, 'aula_coletiva_id');
    }
}
