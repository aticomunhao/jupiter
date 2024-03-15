<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models;
use iluminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\CollectionorderBy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;

class GerenciarEfetivoController extends Controller
{
    public function index(Request $request)
    {


        $base = DB::table('base_salarial AS bs')
            ->leftJoin('funcionarios AS f', 'f.id', 'bs.id_funcionario')
            ->leftJoin('pessoas as p', 'p.id', 'f.id_pessoa')
            ->leftJoin('cargos AS cr', 'cr.id', 'bs.cargo')
            ->leftJoin('cargos as fg', 'fg.id', 'bs.funcao_gratificada')
            ->select(
                'bs.id_funcionario',
                'bs.cargo',
                'bs.funcao_gratificada',
                'bs.dt_inicio as dt_inicio_funcionario',
                'p.nome_completo',
                'cr.nome as nome_cargo_regular',
                'fg.nome as nome_funcao_gratificada'
            )
            ->get();

        $setor = DB::table('setor')
            ->leftJoin('setor AS substituto', 'setor.substituto', '=', 'substituto.id')
            ->select('setor.id AS id_setor', 'setor.nome', 'setor.sigla', 'setor.dt_inicio', 'substituto.sigla AS nome_substituto')
            ->get();

        return view('efetivo.gerenciar-efetivo', compact('base', 'setor'));
    }

    public function show(Request $request)
    {
        // Lógica para exibir detalhes de um funcionário específico
    }

    public function atualizarefetivo(Request $request)
    {
        // Lógica para atualizar os dados do efetivo
        // Redirecionamento com uma mensagem de sucesso
        return redirect('/gerenciar-efetivo')->with('status', 'Dados do efetivo atualizados com sucesso!');
    }
}
