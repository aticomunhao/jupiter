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
   public function index(Request $request)
   {


      $lista_associado = DB::table('associado AS ass')
         ->leftJoin('pessoas AS p', 'ass.id_pessoa', '=', 'p.id')
         ->select(
            DB::raw('CASE WHEN ass.dt_fim IS NULL THEN \'Ativo\' ELSE \'Inativo\' END AS status'),
            'ass.nr_associado',
            'ass.id',
            'p.nome_completo',
            'ass.dt_inicio',
            'ass.dt_fim'
         );

      $id = $request->id;
      $nr_associado = $request->nr_associado;
      $nome_completo = $request->nome_completo;
      $voluntario = $request->voluntario;
      $votante = $request->votante;
      $dt_inicio = $request->dt_inicio;
      $dt_fim = $request->dt_fim;
      $status = $request->status;



      //dd($lista_associado);
      if ($request->nr_associado) {
         $lista_associado->where('ass.nr_associado', $request->nr_associado);
      }


      if ($request->nome_completo) {
         $lista_associado->where('p.nome_completo', 'LIKE', '%' . $request->nome_completo . '%');
      }

      if ($request->dt_inicio) {
         $lista_associado->where('ass.dt_inicio', '=', $request->dt_inicio);
      }


      if ($request->dt_fim) {
         $lista_associado->where('ass.dt_fim', '=', $request->dt_fim);
      }



      if ($request->status == 1) {
         $lista_associado->where('ass.dt_fim', null);
      } elseif ($request->status == 2) {
         $lista_associado->whereNotNull('ass.dt_fim');
      }


      $lista_associado = $lista_associado->orderBy('status', 'asc')->orderBy('p.nome_completo', 'asc')->paginate(10);



      return view('/associado/gerenciar-associado', compact('lista_associado', 'id', 'nr_associado', 'nome_completo', 'voluntario', 'votante', 'dt_inicio', 'dt_fim', 'status'));
   }

   public function create(Request $request)
   {

      $cidade = DB::select('select id_cidade, descricao from tp_cidade');

      $tp_uf = DB::select('select id, sigla from tp_uf');

      $nm_sigla = $request->sigla;
      $nm_cidade = $request->descricao;

      $cep = DB::select('select id, cep, descricao, descricao_bairro from tp_logradouro');

      $logra = DB::select('select distinct(id), descricao from tp_logradouro');

      $ddd = DB::select('select id, descricao, uf_ddd from tp_ddd');



      return view('/associado/incluir-associado', compact('cidade', 'tp_uf', 'cep', 'logra', 'ddd', 'nm_sigla', 'nm_cidade'));
   }
   public function retornaCidadeDadosResidenciais($id)
   {
      $cidadeDadosResidenciais = DB::table('tp_cidade')
         ->where('id_uf', $id)
         ->get();

      return response()->json($cidadeDadosResidenciais);
   }
}
