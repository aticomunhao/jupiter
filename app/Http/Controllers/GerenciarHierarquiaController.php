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

      $nivel = DB::table('tp_nivel_setor')->select('id AS id_nivel', 'nome as nome_nivel');

      $setor = DB::table('setor')->select('id AS id_setor','nome AS nome_setor');


      $nome_nivel = $request->nome_nivel;

      $nome_setor = $request->nome_setor;

      if ($request->nome_nivel){
         $nivel->where('nome_nivel', '=', $request->nome_nivel);
      }

      if ($request->nome_setor){
         $setor->where('nome_setor', '=', $request->nome_setor);
      }

       

    return view('/setores/Gerenciar-hierarquia', compact('nome_nivel','nome_setor', 'nivel', 'setor'));
    }


}