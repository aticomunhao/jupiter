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
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

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


      $lista_associado = $lista_associado->orderBy('status', 'asc')->orderBy('p.nome_completo', 'asc')->paginate(100);



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
      $comparar_cpf = DB::table('pessoas')->pluck('cpf')->toArray();
      $validacaocpf = $request->input('cpf');

      //dd($comparar_cpf);

      foreach ($comparar_cpf as $cpf) {
         if ($validacaocpf == $cpf) {
            app('flasher')->adderror('Associado tem o mesmo CPF de uma pessoa');
            return redirect('/gerenciar-associado');
         }
      }

      DB::table('pessoas')
         ->insert([
            'nome_completo' => $request->input('nome_completo'),
            'cpf' => $request->input('cpf'),
            'ddd' => $request->input('ddd'),
            'celular' => $request->input('telefone'),
            'email' => $request->input('email'),
            'idt' => $request->input('idt')
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
            'ass.dt_inicio',
            'ass.dt_fim',
            'p.id AS idp',
            'endp.id AS ide',
            'ass.dt_inicio',
            'ass.dt_fim',
            'p.nome_completo',
            'p.cpf',
            'p.celular',
            'p.email',
            'p.idt',
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

      //dd($edit_associado);

      return view('associado/editar-associado', compact('edit_associado', 'tpddd', 'tpcidade', 'tpufidt', 'tp_uf'));
   }
   public function update(Request $request, $ida, $idp, $ide)
   {

      $comparar_cpf = DB::table('pessoas')->pluck('cpf')->toArray();
      $validacaocpf = $request->input('cpf');

      //dd($comparar_cpf);

      DB::table('pessoas')
         ->where('id', $idp)
         ->update([
            'nome_completo' => $request->input('nome_completo'),
            'cpf' => $request->input('cpf'),
            'ddd' => $request->input('ddd'),
            'celular' => $request->input('telefone'),
            'email' => $request->input('email'),
            'idt' => $request->input('idt')
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
   public function documentobancariopdf($id)
   {



      $associado = DB::table('associado AS as')
         ->leftJoin('contribuicao_associado AS cont', 'as.id', '=', 'cont.id_associado')
         ->leftJoin('forma_contribuicao_autorizacao AS contaut', 'cont.id_contribuicao_autorizacao', '=', 'contaut.id')
         ->leftJoin('forma_contribuicao_boleto AS contbol', 'cont.id_contribuicao_boleto', '=', 'contbol.id')
         ->leftJoin('forma_contribuicao_tesouraria AS conttes', 'cont.id_contribuicao_tesouraria', '=', 'conttes.id')
         ->leftJoin('pessoas AS p', 'as.id_pessoa', '=', 'p.id')
         ->leftJoin('endereco_pessoas AS endp', 'p.id', '=', 'endp.id_pessoa')
         ->leftJoin('tp_uf AS tuf', 'endp.id_uf_end', '=', 'tuf.id')
         ->leftjoin('tp_cidade AS tc', 'endp.id_cidade', '=', 'tc.id_cidade')
         ->where('as.id', $id)
         ->select(
            'as.nr_associado',
            'p.nome_completo',
            'p.cpf',
            'p.idt',
            'p.celular',
            'p.email',
            'endp.cep',
            'endp.logradouro',
            'endp.numero',
            'endp.bairro',
            'endp.complemento',
            'tc.descricao',
            'cont.valor',
            'contaut.banco_do_brasil',
            'contaut.brb',
            'cont.dt_vencimento',
            'cont.id_agencia',
            'cont.id_banco',
            'contbol.mensal',
            'contbol.trimestral',
            'contbol.semestral',
            'contbol.anual',
            'conttes.dinheiro',
            'conttes.cheque',
            'conttes.ct_de_debito',
            'conttes.ct_de_credito',
            'tuf.sigla',

         )
         ->first();



      //dd($associado);

      $html = View::make('associado/documento-associado', compact('associado'))->render();

      // Cria uma instância do Dompdf
      $dompdf = new Dompdf();

      // Carrega o HTML no Dompdf
      $dompdf->loadHtml($html);

      // Renderiza o PDF
      $dompdf->render();

      // Saída do PDF no navegador
      return $dompdf->stream();
   }
   public function salvardocumentobancario(Request $request, $ida)
   {
      if ($request->hasFile('arquivo')) {

         $arquivo = $request->file('arquivo');

         $nomeArquivo = Hash::make($arquivo->getClientOriginalName());

         // dd($arquivo);

         $caminhoArquivo = $arquivo->storeAs('public/documentos-associado', $nomeArquivo);

         DB::table('contribuicao_associado')
            ->where('id_associado', $ida)
            ->update(['caminho_documento_bancario' => $caminhoArquivo]);

         app('flasher')->addSuccess('Documento Armazenado!');
         return redirect()->route('gerenciar-dados-bancario-associado', ['id' => $ida]);
      }
   }

   public function visualizardocumentobancario($ida)
   {
      $caminhodocumento = DB::table('contribuicao_associado AS ca')
         ->where('id_associado', $ida)
         ->select(['ca.caminho_documento_bancario'])
         ->first();
      if ($caminhodocumento) {
         $caminho = $caminhodocumento->caminho_documento_bancario;


         if (Storage::exists($caminho)) {
            return response()->file(storage_path('app/' . $caminho));
         } else {
            return abort(404);
         }
      } else {

         return abort(404);
      }
   }

   function delete($id)
   {
      $delete_associado = DB::table('associado')->where('associado.id', $id)->delete();

      app('flasher')->addSuccess('O cadastro do Associado foi excluido com sucesso.');

      return redirect('/gerenciar-associado');
   }
}
