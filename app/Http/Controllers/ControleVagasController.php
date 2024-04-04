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

class ControleVagasController extends Controller
{
    public function index(Request $request)
    {
        $setorId = $request->input('setor');

        $quantidadeFuncionariosPorSetor = DB::table('funcionarios')
            ->select('id_setor', DB::raw('count(*) as total_funcionarios'))
            ->groupBy('id_setor')
            ->get();

        $baseQuery = DB::table('funcionarios AS f')
            ->leftJoin('base_salarial AS bs', 'f.id', 'bs.id_funcionario')
            ->leftJoin('pessoas AS p', 'p.id', 'f.id_pessoa')
            ->leftJoin('cargos AS cr', 'cr.id', 'bs.cargo')
            ->leftJoin('cargos AS fg', 'fg.id', 'bs.funcao_gratificada')
            ->leftJoin('setor AS s', 's.id', 'f.id_setor')
            ->leftJoin('tp_vagas_autorizadas AS va', 'va.id_setor', 's.id')
            ->select(
                'cr.nome AS nome_cargo_regular',
                'fg.nome AS nome_funcao_gratificada',
                'va.vagas_autorizadas',
            );



        if ($setorId) {
            $baseQuery->where('s.id', $setorId);
            $totalVagasAutorizadas = DB::table('tp_vagas_autorizadas')->where('id', $setorId)->value('vagas_autorizadas');
        } else {
            $totalVagasAutorizadas = DB::table('tp_vagas_autorizadas')->sum('vagas_autorizadas');
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
            ->select('setor.id AS id_setor', 'setor.nome')
            ->get();

        $cargo = DB::table('cargos')
        ->select('cargos.nome', 'cargos.id')
        ->get();


        return view('efetivo.controle-vagas', compact('base', 'setor', 'totalFuncionariosSetor', 'totalFuncionariosTotal', 'totalVagasAutorizadas', 'setorId', 'cargo'));
    }
}
