<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['aula_coletiva_id', 'usuario_id', 'status'])]
class ReservaAulaColetiva extends Model
{
    use HasFactory;
    
    protected $table = 'reserva_aula_coletivas';
    public function aula(): BelongsTo
    {
        return $this->belongsTo(AulaColetiva::class, 'aula_coletiva_id');
    }

    public function aluno(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
