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

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
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

    /**
     * Relacionamento 1:N com Treinos criados por este instrutor
     */
    public function treinos(): HasMany
    {
        return $this->hasMany(Treino::class, 'instrutor_id');
    }

    /**
     * Relacionamento 1:N com Aulas Coletivas ministradas por este instrutor
     */
    public function aulasColetivas(): HasMany
    {
        return $this->hasMany(AulaColetiva::class, 'instrutor_id');
    }
}
