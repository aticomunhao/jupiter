<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RelatoriosFuncionariosController extends Controller
{
    public function index(Request $request)
    {

        $motafastamento = DB::table('funcionarios AS f')
        ->leftJoin('pessoas AS p', 'f.id_pessoa', 'p.id')
        ->leftJoin('contrato AS c', 'f.id', 'c.id_funcionario')
        ->leftJoin('afastamento AS a', 'f.id', 'a.id_funcionario')
        ->leftJoin('tp_afastamento AS ta', 'a.id_tp_afastamento', 'ta.id')
        ->leftJoin('complemento_afastamento AS ca', 'a.id_complemento', 'ca.id')
        ->leftJoin('hist_setor AS hs', 'f.id', 'hs.id_func')
        ->leftJoin('setor AS s', 'hs.id_setor', 's.id')
        ->select('p.nome_completo',
                's.sigla',
                'ta.nome AS motafas',
                'a.dt_inicio AS afinicio',
                'a.dt_fim AS afim',
                'c.matricula',
                'c.dt_inicio AS minicio',
                'ca.complemento AS compnome'
        )
        ->whereNull('hs.dt_fim')
        ->whereNotNull('id_afastamento')
        ->whereNull('c.dt_fim');

        $dt_inicio = $request->dt_inicio;
        $dt_fim = $request->dt_fim;
        $setor = $request->setor;
        $func = $request->func;
        $motivo = $request->motivo;

        if($dt_inicio){
            $motafastamento->whereDate('a.dt_inicio', '>=', $dt_inicio);
        }
        if($dt_fim){
            $motafastamento->whereDate('a.dt_fim', '<=', $dt_fim);
        }
        if($setor){
            $motafastamento->where('s.id', $setor);
        }
        if($func){
            $motafastamento->where('f.id', $func);
        }
        if($motivo){
            $motafastamento->where('ta.id', $motivo);
        }


        $motafastamento = $motafastamento->orderBy('p.nome_completo', 'ASC')->orderBy( 'a.dt_inicio', 'Desc')->paginate(20);

        foreach ($motafastamento as $mot) {
            $inicio = Carbon::parse($mot->afinicio);
            $fim = $mot->afim ? Carbon::parse($mot->afim) : Carbon::now();

            $diff = $inicio->diff($fim);

            $mot->anos = $diff->y;
            $mot->meses = $diff->m;
            $mot->dias = $diff->d;

            // Opcional: string legível
            $mot->tempo_afastado = "{$diff->y} ano(s), {$diff->m} mês(es) e {$diff->d} dia(s)";
        }


        $tpafasta = DB::table('tp_afastamento')->get();

        $func = DB::table('funcionarios AS f')
        ->leftJoin('pessoas AS p', 'f.id_pessoa', 'p.id')->select('f.id','p.nome_completo')->orderBy('p.nome_completo')->get();

        $setores = DB::table('setor AS s')->select('id', 'sigla')->get();

        $motivo = DB::table('tp_afastamento AS ta')->select('id', 'nome')->get();

        return view ('relatoriosfuncionarios.motivos-afastamentos', compact('motafastamento', 'tpafasta', 'func', 'setores', 'dt_inicio', 'dt_fim', 'motivo'));



    }
}
