<?php

namespace App\Actions;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateNewUser
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password'         => $this->passwordRules(),
            'rg'               => 'required|string|max:20|unique:users',
            'data_nascimento'  => 'required|date',
            'rua'              => 'required|string|max:255',
            'numero_rua'       => 'required|integer',
            'cep'              => 'required|string|size:9',
            'numero_telefone'  => 'required|string|max:20',
            'status'           => ['nullable', Rule::in(['ativo', 'inativo'])],
            'tipo'             => ['nullable', Rule::in(['aluno', 'instrutor', 'admin'])],
        ])->validate();

        return User::create([
            'name'            => $input['name'],
            'email'           => $input['email'],
            'password'        => $input['password'],
            'rg'              => $input['rg'],
            'data_nascimento' => $input['data_nascimento'],
            'rua'             => $input['rua'],
            'numero_rua'      => $input['numero_rua'],
            'cep'             => $input['cep'],
            'numero_telefone' => $input['numero_telefone'],
            'status'          => $input['status'] ?? 'ativo',
            'tipo'            => $input['tipo'] ?? 'aluno',
        ]);
    }
}
