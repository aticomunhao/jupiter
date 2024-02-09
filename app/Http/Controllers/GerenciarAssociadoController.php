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

      $ddd = DB::select('select id, descricao, uf_ddd from tp_ddd');



      return view('/associado/incluir-associado', compact('cidade', 'tp_uf', 'ddd'));
   }
   public function retornaCidadeDadosResidenciais($id)
   {
      $cidadeDadosResidenciais = DB::table('tp_cidade')
         ->where('id_uf', $id)
         ->get();

      return response()->json($cidadeDadosResidenciais);
   }

   public function store(Request $request)
   {
      DB::table('pessoas')
         ->insert([
            'nome_completo' => $request->input('nome_completo'),
            'cpf' => $request->input('cpf'),
            'ddd' => $request->input('ddd'),
            'celular' => $request->input('telefone'),
            'email' => $request->input('email')
         ]);

      $id_pessoa = DB::table('pessoas')
         ->select(DB::raw('MAX(id) as max_id'))
         ->value('max_id');

      DB::table('associado')
         ->insert([
            'id_pessoa' => $id_pessoa,
            'dt_inicio' => $request->input('dt_inicio'),

         ]);

      DB::table('endereco_pessoas')->insert([
         'id_pessoa' => $id_pessoa,
         'cep' => str_replace('-', '', $request->input('cep')),
         'id_uf_end' => $request->input('uf_end'),
         'id_cidade' => $request->input('cidade'),
         'logradouro' => $request->input('logradouro'),
         'numero' => $request->input('numero'),
         'bairro' => $request->input('bairro'),
         'complemento' => $request->input('complemento'),
      ]);


      app('flasher')->addSuccess('O cadastro do Associado foi realizado com sucesso.');

      return redirect('/gerenciar-associado');
   }

   public function edit($id)
   {
      $edit_associado = DB::table('associado AS ass')
         ->leftJoin('pessoas AS p', 'ass.id_pessoa', '=', 'p.id')
         ->leftJoin('endereco_pessoas AS endp', 'p.id', '=', 'endp.id_pessoa')
         ->leftJoin('tp_uf', 'endp.id_uf_end', '=', 'tp_uf.id')
         ->leftJoin('tp_ddd', 'tp_ddd.id', '=','p.ddd')
         ->leftjoin('tp_cidade AS tc', 'endp.id_cidade', '=', 'tc.id_cidade')
         ->where('ass.id', $id)
         ->select(
            'ass.nr_associado',
            'ass.dt_inicio',                                                                                            
            'p.nome_completo',
            'p.cpf',
            'p.celular',
            'p.email',
            'tp_ddd.id AS tpd',
            'tp_ddd.descricao AS dddesc',
            'tp_uf.id AS tuf',
            'tp_uf.sigla AS ufsgl',
            'endp.cep',
            'tc.descricao',
            'endp.logradouro',
            'endp.numero',
            'endp.bairro',
            'endp.complemento',
            'tc.id_cidade',
            'tc.descricao AS nat'
         )->get();

         $tpddd = DB::table('tp_ddd')->select('id', 'descricao')->get();
         $tpcidade = DB::table('tp_cidade')->select('id_cidade', 'descricao')->get();
         $tpufidt = DB::table('tp_uf')->select('id', 'sigla')->get();
         
      $tp_uf = DB::select('select id, sigla from tp_uf');


      //dd($tpcidade);

     // dd($edit_associado);

      return view('associado/editar-associado', compact('edit_associado', 'tpddd', 'tpcidade', 'tpufidt', 'tp_uf'));
   }
}
