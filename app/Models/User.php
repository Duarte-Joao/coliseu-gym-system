<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable([
    'name', 
    'email', 
    'password', 
    'cpf', 
    'data_nascimento', 
    'rua', 
    'numero_rua', 
    'cep', 
    'numero_telefone', 
    'status', 
    'tipo'
])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'data_nascimento' => 'date',
        ];
    }

    /**
     * Relacionamento 1:1 com Instrutor (se o usuário for um instrutor)
     */
    public function instrutor(): HasOne
    {
        return $this->hasOne(Instrutor::class, 'usuario_id');
    }

    /**
     * Relacionamento 1:N com as atribuições de treinos (como aluno)
     */
    public function treinoAlunos(): HasMany
    {
        return $this->hasMany(TreinoAluno::class, 'usuario_id');
    }

    /**
     * Relacionamento 1:N com planos ativos/históricos
     */
    public function planoAlunos(): HasMany
    {
        return $this->hasMany(PlanoAluno::class, 'usuario_id');
    }

    /**
     * Relacionamento 1:N com reservas em aulas coletivas
     */
    public function reservaAulas(): HasMany
    {
        return $this->hasMany(ReservaAulaColetiva::class, 'usuario_id');
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}

