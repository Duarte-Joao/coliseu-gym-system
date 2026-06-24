<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PagamentoPlanoAluno;
use App\Models\PlanoAluno;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PagamentoPlanoAlunoController extends Controller
{
    public function index(Request $request): View
    {
        $query = PagamentoPlanoAluno::query()->with('plano.aluno');

        if ($request->filled('busca')) {
            $query->whereHas('plano.aluno', fn($q) => $q->where('name', 'like', "%{$request->busca}%"));
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pagamentos = $query->paginate(15)->withQueryString();

        // Chart: últimos 6 meses
        $meses_ptbr   = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
        $chartLabels   = [];
        $chartReceita  = [];
        $chartPendente = [];

        $todosPagamentos = PagamentoPlanoAluno::with('plano')
            ->where('data', '>=', now()->subMonths(5)->startOfMonth())
            ->get();

        for ($i = 5; $i >= 0; $i--) {
            $d       = now()->subMonths($i);
            $chartLabels[] = $meses_ptbr[(int) $d->format('n') - 1] . '/' . $d->format('y');
            $doMes   = $todosPagamentos->filter(
                fn($p) => $p->data && $p->data->year === (int) $d->year && $p->data->month === (int) $d->month
            );
            $chartReceita[]  = round((float) $doMes->where('status', 'pago')->sum(fn($p) => (float) ($p->plano->valor ?? 0)), 2);
            $chartPendente[] = round((float) $doMes->where('status', 'pendente')->sum(fn($p) => (float) ($p->plano->valor ?? 0)), 2);
        }

        return view('pagamento-plano-alunos.index', compact('pagamentos', 'chartLabels', 'chartReceita', 'chartPendente'));
    }

    public function pdf(Request $request): Response
    {
        $query = PagamentoPlanoAluno::query()->with('plano.aluno');

        if ($request->filled('busca')) {
            $query->whereHas('plano.aluno', fn($q) => $q->where('name', 'like', "%{$request->busca}%"));
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pagamentos = $query->orderBy('data', 'desc')->get();
        $busca  = $request->busca;
        $tipo   = $request->tipo;
        $status = $request->status;

        $pdf = Pdf::loadView('pdf.pagamentos', compact('pagamentos', 'busca', 'tipo', 'status'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('relatorio-pagamentos-' . now()->format('Y-m-d') . '.pdf');
    }

    public function create(Request $request): View
    {
        $planos = PlanoAluno::with('aluno')->get();
        $planoSelecionado = $request->filled('plano_aluno_id')
            ? PlanoAluno::find($request->plano_aluno_id)
            : null;

        return view('pagamento-plano-alunos.create', compact('planos', 'planoSelecionado'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'plano_aluno_id'   => 'required|exists:plano_alunos,id',
            'tipo' => ['required', Rule::in(['Pix', 'Cartão de Crédito', 'Cartão de Débito', 'Dinheiro', 'Boleto'])],
            'data'             => 'required|date',
            'status'           => ['nullable', Rule::in(['pago', 'pendente', 'cancelado'])],
        ]);

        PagamentoPlanoAluno::create($validated);

        return redirect()->route('pagamento-plano-alunos.index')->with('success', 'Pagamento registrado com sucesso!');
    }

    public function show(PagamentoPlanoAluno $pagamento): View
    {
        return view('pagamento-plano-alunos.show', ['pagamento' => $pagamento->load('plano.aluno')]);
    }

    public function edit(PagamentoPlanoAluno $pagamento): View
    {
        return view('pagamento-plano-alunos.edit', ['pagamento' => $pagamento->load('plano.aluno')]);
    }

    public function update(Request $request, PagamentoPlanoAluno $pagamento): RedirectResponse
    {
        $validated = $request->validate([
            'tipo' => ['required', Rule::in(['Pix', 'Cartão de Crédito', 'Cartão de Débito', 'Dinheiro', 'Boleto'])],
            'data'             => 'required|date',
            'status'           => ['required', Rule::in(['pago', 'pendente', 'cancelado'])],
        ]);

        $pagamento->update($validated);

        return redirect()->route('pagamento-plano-alunos.index')->with('success', 'Pagamento atualizado com sucesso!');
    }

    public function pagar(PagamentoPlanoAluno $pagamento): JsonResponse
    {
        if ($pagamento->plano->usuario_id !== Auth::id() || $pagamento->status !== 'pendente') {
            abort(403);
        }

        $pagamento->update(['status' => 'pago']);

        return response()->json(['ok' => true]);
    }

    public function destroy(PagamentoPlanoAluno $pagamento): RedirectResponse
    {
        $pagamento->delete();
        return redirect()->route('pagamento-plano-alunos.index')->with('success', 'Pagamento excluído com sucesso!');
    }
}
