<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Instrutor;
use Illuminate\Contracts\View\View;

class TreinadorPerfilController extends Controller
{
    public function __invoke(): View
    {
        $instrutor = Instrutor::where('usuario_id', auth()->id())
            ->with('usuario')
            ->first();

        return view('treinador.perfil', [
            'instrutor' => $instrutor,
            'usuario'   => auth()->user(),
        ]);
    }
}
