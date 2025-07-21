<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatoriosFuncionariosController extends Controller
{
    public function index(Request $request)
    {


        $motafastamento = DB::table('funcionarios AS f')
        ->leftJoin('pessoas AS p', 'f.id_pessoa', 'p.id')
        ->leftJoin('contrato AS c', 'f.id', 'c.id_funcionario')
        ->leftJoin('afastamento AS a', 'f.id', 'a.id_funcionario')
        ->leftJoin('tp_afastamento AS ta', 'a.id_tp_afastamento', 'ta.id')
        //->leftJoin('setor AS s', )
        ->whereNull('c.dt_fim')
        ->get();

        $tpafasta = DB::table('tp_afastamento')->get();

        $func = DB::table('funcionarios AS f')->get();

        return view ('relatoriosfuncionarios.motivos-afastamentos', compact('motafastamento', 'tpafasta', 'func'));



    }
}
