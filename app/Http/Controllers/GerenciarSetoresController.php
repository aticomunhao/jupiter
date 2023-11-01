<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use iluminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\CollectionorderBy;
use Carbon\Carbon;


class GerenciarSetoresController extends Controller
{
    public function index(Request $request){

    $lista = DB::table('setores AS s')
    ->select('s.id AS ids', 's.nome', 's.usuario', 's.sigla', 's.dt_inicio', 's.dt_fim')
    ->get();

      //dd($lista);

      $usuario = $request->usuario;

      $nome = $request->nome;

     // $sigla = $request->sigla;

      $dt_inicio = $request->dt_inicio;

      $dt_fim = $request->dt_fim;

    if ($request->usuario) {
        $lista->where('s.usuario', 'LIKE', '%' . $request->usuario . '%');
    }

    if ($request->nome) {
        $lista->where('s.nome', 'LIKE', '%' . $request->nome . '%');
    }

    //if ($request->sigla) {
        //$lista->where('setores.sigla', '=', $request->sigla);
    //}




       return view('/setores/gerenciar-setor', compact ('lista','usuario', 'nome',  'dt_inicio', 'dt_fim'));
    }
}
