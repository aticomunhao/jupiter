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
        $setorId = $request->input('setor');

        $quantidadeFuncionariosPorSetor = DB::table('funcionarios')
            ->select('id_setor', DB::raw('count(*) as total_funcionarios'))
            ->groupBy('id_setor')
            ->get();

        $baseQuery = DB::table('base_salarial AS bs')
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
                'fg.nome as nome_funcao_gratificada',
                'p.celular'
            );

        if ($setorId) {
            $baseQuery->where('f.id_setor', $setorId);
            // Obtendo a quantidade de vagas autorizadas filtrada por setor
            $totalVagasAutorizadas = DB::table('setor')->where('id', $setorId)->value('vagas_autorizadas');
        } else {
            // Obtendo o total geral de vagas autorizadas
            $totalVagasAutorizadas = DB::table('setor')->sum('vagas_autorizadas');
        }

        $base = $baseQuery->get();

        $totalFuncionariosSetor = 0;
        foreach ($quantidadeFuncionariosPorSetor as $quantidade) {
            if ($quantidade->id_setor == $setorId) {
                $totalFuncionariosSetor = $quantidade->total_funcionarios;
                break;
            }
        }

        $totalFuncionariosTotal = DB::table('funcionarios')->count();

        $setor = DB::table('setor')
            ->leftJoin('setor AS substituto', 'setor.substituto', '=', 'substituto.id')
            ->select('setor.id AS id_setor', 'setor.nome', 'setor.sigla', 'setor.dt_inicio', 'substituto.sigla AS nome_substituto')
            ->get();

        return view('efetivo.gerenciar-efetivo', compact('base', 'setor', 'totalFuncionariosSetor', 'totalFuncionariosTotal', 'totalVagasAutorizadas', 'setorId'));
    }
}
