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

        $base = DB::table('funcionarios AS f')
            ->distinct('p.nome_completo')
            ->leftJoin('base_salarial AS bs', 'f.id', 'bs.id_funcionario')
            ->leftJoin('pessoas AS p', 'p.id', 'f.id_pessoa')
            ->leftJoin('cargos AS cr', 'cr.id', 'bs.cargo')
            ->leftJoin('cargos AS fg', 'fg.id', 'bs.funcao_gratificada')
            ->leftJoin('setor AS s', 's.id', 'f.id_setor')
            ->select(
                'bs.id_funcionario',
                'bs.cargo',
                'bs.funcao_gratificada',
                'f.dt_inicio as dt_inicio_funcionario',
                'p.nome_completo AS nome_completo',
                'cr.nome AS nome_cargo_regular',
                'fg.nome AS nome_funcao_gratificada',
                'p.celular',
                'f.id_setor',
            );


        if ($setorId) {
            $base->where('s.id', $setorId);
            $totalVagasAutorizadas = DB::table('tp_vagas_autorizadas')->where('id_setor', $setorId)->sum('vagas_autorizadas');
        } else {
            $totalVagasAutorizadas = DB::table('tp_vagas_autorizadas')->sum('vagas_autorizadas');
        }

        $base = $base->orderBy('nome_completo')->paginate(10);



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



        return view('efetivo.gerenciar-efetivo', compact('base', 'setor', 'totalFuncionariosSetor', 'totalFuncionariosTotal', 'totalVagasAutorizadas', 'setorId'));
    }
}
