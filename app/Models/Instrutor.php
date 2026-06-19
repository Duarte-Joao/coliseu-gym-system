<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['usuario_id', 'especialidade', 'salario', 'carga_hora', 'turno'])]
class Instrutor extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * O nome da tabela associada ao model (caso o plural seja diferente do padrão Eloquent)
     */
    protected $table = 'instrutores';

    protected function casts(): array
    {
        return [
            'salario' => 'decimal:2',
        ];
    }

    /**
     * Relacionamento 1:1 inverso com User
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }


    public function treinos(): HasMany
    {
        return $this->hasMany(Treino::class, 'instrutor_id');
    }

    public function aulasColetivas(): HasMany
    {
        return $this->hasMany(AulaColetiva::class, 'instrutor_id');
    }
}
