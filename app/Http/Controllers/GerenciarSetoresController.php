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
    ->select('s.id AS ids', 's.nome', 's.usuario', 's.sigla', 's.dt_inicio', 's.dt_fim');

      //dd($lista);

      $usuario = $request->usuario;

      $nome = $request->nome;

     // $sigla = $request->sigla;

      $dt_inicio = $request->dt_inicio;

      $dt_fim = $request->dt_fim;

    if ($request->usuario) {
        $lista->where('s.usuario', 'LIKE', '%' . $request->usuario . '%1');
    }

    if ($request->nome) {
        $lista->where('s.nome', 'LIKE', '%' . $request->nome . '%');
    }

    //if ($request->sigla) {
        //$lista->where('setores.sigla', '=', $request->sigla);
    //}

    $lista = $lista->orderBy( 's.usuario','asc')->orderBy('s.nome', 'asc')->paginate(10);
         //dd($lista);

       return view('/setores/gerenciar-setor', compact ('lista','usuario', 'nome',  'dt_inicio', 'dt_fim'));
    }
    public function edit($id){
          $editar = DB::table('setores AS s')
          ->select('s.id AS ids', 's.nome', 's.usuario', 's.sigla', 's.dt_inicio', 's.dt_fim')
          ->where($id, 'id');

          return view('/setores/editar-setor', compact('editar'));

    }





    public function delete($ids){

        $del = DB::table('setores')->where('id', $ids)->delete();

        app('flasher')->addSuccess('O cadastro do Setor foi Removido com Sucesso.');
    return redirect()->action([GerenciarSetoresController::class, 'index']);
    }
}
