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
  public function index(Request $request, $id){
    $associado = DB::table('associado AS as')
    ->leftJoin('contribuicao_associado AS cont', 'as.id', '=', 'cont.id_associado')
    ->leftJoin('forma_contribuicao_autorizacao AS contaut', 'cont.id_contribuicao_autorizacao', '=', 'contaut.id')
    ->leftJoin('forma_contribuicao_boleto AS contbolt', 'cont.id_contribuicao_boleto', '=', 'contbolt.id')
    ->leftJoin('forma_contribuicao_tesouraria AS contteso', 'cont.id_contribuicao_tesouraria', '=', 'contteso.id')
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

  //  dd($associado);
    $nome_completo = $request->nome_completo;
    $valor = $request->valor;
    $dt_vencimento = $request->dt_vencimento;
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



   if ($banco_do_brasil == FALSE){
       $bb = "Banco do Brasil";
       
   }
   else{ $bb = "BRB";}


   // dd($associado);
    return view('associado/gerenciar-dados-bancarios-associado', compact('associado', 'bb'));
}
}