<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use iluminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\CollectionorderBy;
use Carbon\Carbon;


class GerenciarHierarquiaController extends Controller
{ 
    public function index(Request $request)
    {

      $nivel = DB::table('tp_nivel_setor')->select('tp_nivel_setor.id AS id_nivel', 'nome as nome_nivel')->get();

      $setor = DB::table('setor')
      ->leftJoin('setor AS substituto', 'setor.substituto', '=', 'substituto.id')
      ->select('setor.id AS id_setor', 'setor.nome AS nome_setor', 'setor.sigla', 'setor.dt_inicio', 'setor.status', 'substituto.sigla AS nome_substituto')
      ->get();
  
      //dd($setor);
      $id_nivel = $request->id_nivel;
      $id_setor = $request->id_setor;
      $sigla = $request->input('sigla');
      $status = $request->input('status');
      $dt_inicio = $request->input('dt_inicio');
      $nome_substituto = $request->nome_substituto;

      $nome_nivel = $request->input('nome_nivel');
      $nome_setor = $request->input('nome_setor');

      if ($nome_nivel) {
         $nivel->where('nome', $nome_nivel);
     }

     if ($nome_setor) {
         $setor->where('nome', $nome_setor);
     }

     if ($id_setor) {
      $setor->where('nome', $id_setor);
     }

     if ($id_nivel) {
      $nivel->where('nome', $id_nivel);
     }      
     
     if ($sigla) {
      $sigla->where('nome', $sigla);
     }     

    return view('/setores/Gerenciar-hierarquia', compact('nome_nivel','nivel','setor', 'nome_setor', 'id_nivel', 'id_setor', 'sigla', 'dt_inicio', 'status', 'nome_substituto'));
    }
   public function create(Request $request){

      $nome_nivel = $request->input('nome_nivel');
      $nome_setor = $request->input('nome_setor');

      $niveis = DB::table('tp_nivel_setor')->select('id AS id_nivel', 'nome AS nome_nivel');
      $setor = DB::table('setor')->select('id AS id_setor', 'nome AS nome_setor');


      if ($nome_nivel) {
          $niveis->where('nome', $nome_nivel);
      }

      if ($nome_setor) {
          $setor->where('nome', $nome_setor);
      }

      $niveis = $niveis->get();
      $setores = $setor->get();

      return view('/setores/Gerenciar-hierarquia', compact('nome_nivel', 'nome_setor', 'niveis', 'setor'));
  }
}

