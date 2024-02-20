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



      // dd($cidadeDadosResidenciais);

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
         ->leftJoin('tp_ddd', 'tp_ddd.id', '=', 'p.ddd')
         ->leftjoin('tp_cidade AS tc', 'endp.id_cidade', '=', 'tc.id_cidade')
         ->where('ass.id', $id)
         ->select(
            'ass.id AS ida',
            'ass.nr_associado',
            'p.id AS idp',
            'endp.id AS ide',
            'ass.dt_inicio',
            'ass.dt_fim',
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
   public function update(Request $request, $ida, $idp, $ide)
   {

      DB::table('pessoas')
         ->where('id', $idp)
         ->update([
            'nome_completo' => $request->input('nome_completo'),
            'cpf' => $request->input('cpf'),
            'ddd' => $request->input('ddd'),
            'celular' => $request->input('telefone'),
            'email' => $request->input('email')
         ]);

      DB::table('associado')
         ->where('id', $ida)
         ->update([
            'dt_inicio' => $request->input('dt_inicio'),
            'dt_fim' => $request->input('dt_fim'),
         ]);

      DB::table('endereco_pessoas')
         ->where('id', $ide)
         ->update([
            'cep' => $request->input('cep'),
            'id_uf_end' => $request->input('uf_end'),
            'id_cidade' => $request->input('cidade'),
            'logradouro' => $request->input('logradouro'),
            'numero' => $request->input('numero'),
            'bairro' => $request->input('bairro'),
            'complemento' => $request->input('complemento'),
         ]);



      app('flasher')->addSuccess('Edição do cadastro do Associado foi realizado com sucesso.');

      return redirect('/gerenciar-associado');
   }
   public function visualizardadosbancarios(Request $request, $id)
   {

      $associado = DB::table('associado AS as')
         ->leftJoin('contribuicao_associado AS cont', 'as.id', '=', 'cont.id_associado')
         ->leftJoin('forma_contribuicao_autorizacao AS contaut', 'cont.id_contribuicao_autorizacao', '=', 'contaut.id')
         ->leftJoin('forma_contribuicao_boleto AS contbolt', 'cont.id_contribuicao_boleto', '=', 'contbolt.id')
         ->leftJoin('forma_contribuicao_tesouraria AS contteso', 'cont.id_contribuicao_autorizacao', '=', 'contteso.id')
         ->leftJoin('pessoas AS p', 'as.id_pessoa', '=', 'p.id') // Corrigido o operador de comparação aqui
         ->where('as.id', $id)
         ->select(
            'p.nome_completo',
            'cont.valor',
            'cont.dt_vencimento',
            'cont.ultima_contribuicao',
            'contaut.banco_do_brasil',
            'contaut.brb',
            'contbolt.mensal',
            'contbolt.trimestral',
            'contbolt.semestral',
            'contbolt.anual',
            'contteso.dinheiro',
            'contteso.cheque',
            'contteso.ct_de_debito',
            'contteso.ct_de_credito'
         )
         ->get();

      dd($associado);

      $nm_completo = $request->nome_completo;


      return view('associado/gerenciar-dados-bancarios-associado', compact('associado'));
   }
   public function incluirdadosbancarios(Request $request, $ida)
   {

      DB::table('forma_contribuicao_tesouraria')->insert([
         'dinheiro' => $request->has('dinheiro'),
         'cheque' => $request->has('cheque'),
         'ct_de_debito' => $request->has('cartao_de_debito'),
         'ct_de_credito' => $request->has('cartao_de_credito'),
      ]);

      DB::table('forma_contribuicao_boleto')->insert([
         'mensal' => $request->has('mensal'),
         'trimestral' => $request->has('trimestral'),
         'semestral' => $request->has('semestral'),
         'anual' => $request->has('anual'),
      ]);

      DB::table('forma_contribuicao_autorizacao')->insert([
         'banco_do_brasil' => $request->has('banco_do_brasil'),
         'brb' => $request->has('brb'),
      ]);

      $id_cont_tesouraria = DB::table('forma_contribuicao_tesouraria')
         ->select(DB::raw('MAX(id) as max_id'))
         ->value('max_id');

      $id_cont_boleto = DB::table('forma_contribuicao_boleto')
         ->select(DB::raw('MAX(id) as max_id'))
         ->value('max_id');

      $id_cont_boleto = DB::table('forma_contribuicao_autorizacao')
         ->select(DB::raw('MAX(id) as max_id'))
         ->value('max_id');

      $id_contribuicao = DB::table('contribuicao_associado')
         ->select(DB::raw('MAX(id) as max_id'))
         ->value('max_id');

      $id_associado = DB::table('associado')
         ->select(DB::raw('MAX(id) as max_id'))
         ->value('max_id');
      // dd($id_contribuicao);

      DB::table('contribuicao_associado')
         ->insert([
            'id_associado' => $id_associado,
            'id_contribuicao_tesouraria' => $id_cont_tesouraria,
            'id_contribuicao_boleto' => $id_cont_boleto,
            'id_contribuicao_autorizacao' => $id_cont_boleto,
            'valor' => $request->input('valor'),
            'dt_vencimento' => $request->input('dt_vencimento'),
         ]);

      $associado_dados_bancarios = DB::table('contribuicao_associado AS ca')
         ->leftJoin('associado AS as', 'ca.id_associado', '=', 'as.id')
         ->leftJoin('pessoas', 'as.id_pessoa', '=', 'pessoas.id')
         ->where('ca.id', $id_contribuicao)
         ->get();

      dd($associado_dados_bancarios);

      //        DB::table('associado AS as')
      // ->where('as.id', $ida)
      //  ->update(['as.id_contribuicao_associado' => $id_contribuicao]);
      //  dd($oi);

      app('flasher')->addSuccess('Cadastro Dados Bancários do Associado foi realizado com sucesso.');

      return redirect('/gerenciar-associado');
   }
}
