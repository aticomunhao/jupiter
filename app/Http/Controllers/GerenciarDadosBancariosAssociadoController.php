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


class GerenciarDadosBancariosAssociadoController extends Controller
{
    public function index(Request $request, $id)
    {
        $associado = DB::table('associado AS as')
            ->leftJoin('contribuicao_associado AS cont', 'as.id', '=', 'cont.id_associado')
            ->leftJoin('forma_contribuicao_autorizacao AS contaut', 'cont.id_contribuicao_autorizacao', '=', 'contaut.id')
            ->leftJoin('forma_contribuicao_boleto AS contbolt', 'cont.id_contribuicao_boleto', '=', 'contbolt.id')
            ->leftJoin('forma_contribuicao_tesouraria AS contteso', 'cont.id_contribuicao_tesouraria', '=', 'contteso.id')
            ->leftJoin('pessoas AS p', 'as.id_pessoa', '=', 'p.id') // Corrigido o operador de comparação aqui
            ->where('as.id', $id)
            ->select(
                'as.id AS ida',
                'as.nr_associado',
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
            ->first();

       //  dd($associado);
        $ida = $request->ida;
        $nome_completo = $request->nome_completo;
        $valor = $request->valor;
        $dt_vencimento = $request->dt_vencimento;
        $dataformatada = \Carbon\Carbon::parse($associado->dt_vencimento)->format('d/m/y');
        $ultima_contribuicao = $request->ultima_contribuicao;

        $banco_do_brasil = $request->banco_do_brasil;
        $brb = $request->brb;

        $mensal = $request->mensal;
        $trimestral = $request->trimestral;
        $semestral = $request->semestral;
        $anual = $request->anual;

        $dinheiro = $request->dinheiro;
        $cheque = $request->cheque;
        $ct_de_debito = $request->ct_de_debito;
        $ct_de_credito = $request->ct_de_credito;

        $mes = "Mensal";


        if ($associado->trimestral == TRUE) {
            $mes = "Trimestral";
        } else if ($associado->semestral == TRUE) {
            $mes = "Semestral";
        } else if ($associado->anual == TRUE) {
            $mes = "Anual";
        }



        $banco = "BRB";

        if ($associado->banco_do_brasil == TRUE) {
            $banco = "Banco do Brasil";
            // dd($bb);
        }

        $tesouraria = "dinheiro";

        if ($associado->cheque == TRUE) {
            $tesouraria = "Cheque";
        } else if ($associado->ct_de_debito == TRUE) {
            $tesouraria = "Cartão de Débito";
        } else if ($associado->ct_de_credito == TRUE) {
            $tesouraria = "Cartão de Crédito";
        }




        // dd($associado);
        return view('associado/gerenciar-dados-bancarios-associado', compact('associado',  'banco', 'mes', 'tesouraria', 'dataformatada', 'ida'));
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
 
   ///    dd($associado);
 
 //$nm_completo = $request->nome_completo;
 
 
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
 
   //    dd($associado_dados_bancarios);
 
       //        DB::table('associado AS as')
       // ->where('as.id', $ida)
       //  ->update(['as.id_contribuicao_associado' => $id_contribuicao]);
       //  dd($oi);
 
       app('flasher')->addSuccess('Cadastro Dados Bancários do Associado foi realizado com sucesso.');
 
       return redirect('/gerenciar-dados-bancarios-associado');
    }
}
