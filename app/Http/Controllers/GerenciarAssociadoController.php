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


class GerenciarAssociadoController extends Controller
{
   public function index(Request $request){


    $lista_associado = DB::table('associado AS ass')
    ->leftJoin('pessoas AS p', 'ass.id_pessoa', '=', 'p.id')
    ->select('ass.nr_associado', 'ass.id', 'p.nome_completo', 'ass.isento', 'ass.voluntario', 'ass.votante', 'ass.dt_inicio', 'ass.dt_fim')
    ->get();

    $id = $request->input('ass.id');
    $nr_associado = $request->input('ass.nr_associado');
    $nome = $request->input('p.nome_completo');
    $isento = $request->input('ass.isento');
    $voluntario = $request->input('ass.voluntario');
    $votante = $request->input('ass.votante');
    $dt_inicio = $request->input('ass.dt_inicio');
    $dt_fim = $request->input('ass.dt_fim');

    //dd($lista_associado);



    return view('/associado/gerenciar-associado', compact('lista_associado', 'id', 'nr_associado', 'nome', 'isento', 'voluntario', 'votante', 'dt_inicio', 'dt_fim'));
   }
}