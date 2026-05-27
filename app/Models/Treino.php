<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['instrutor_id', 'nome', 'obs', 'exercicios'])]
class Treino extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'exercicios' => 'array',
        ];
    }

    /**
     * Relacionamento 1:N inverso com Instrutor (criador do treino)
     */
    public function instrutor(): BelongsTo
    {
        return $this->belongsTo(Instrutor::class, 'instrutor_id');
    }

    /**
     * Relacionamento 1:N com as vinculações de treinos a alunos
     */
    public function treinoAlunos(): HasMany
    {
        return $this->hasMany(TreinoAluno::class, 'treino_id');
    }
}
