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

        $nivel = DB::table('tp_nivel_setor')->select('tp_nivel_setor.id AS id_nivel', 'tp_nivel_setor.nome as nome_nivel');

        $setor = DB::table('setor')
            ->leftJoin('setor AS substituto', 'setor.substituto', '=', 'substituto.id')
            ->select('setor.id AS id_setor', 'setor.nome AS nome_setor', 'setor.sigla', 'setor.dt_inicio', 'setor.status', 'substituto.sigla AS nome_substituto');


        //dd($setor);
        $id_nivel = $request->id_nivel;
        $id_setor = $request->id_setor;
        $sigla = $request->sigla;
        $status = $request->status;
        $dt_inicio = $request->dt_inicio;
        $nome_substituto = $request->nome_substituto;
        $nome_nivel = $request->nome_nivel;
        $nome_setor = $request->nome_setor;

        if ($request->id_setor) {
            $setor->where('id_setor', $request->id_setor);
        }

        if ($request->id_nivel) {
            $nivel->where('id_nivel', $request->id_nivel);
        }

        if ($request->status) {
            $status->where('status', $request->status);
        }

        if ($request->sigla) {
            $sigla->where('sigla', $request->sigla);
        }

        if ($request->nome_nivel) {
            $nivel->where('nome_nivel',  'LIKE', '%' . $request->nome_nivel . '%');
        }

        if ($request->nome_setor) {
            $setor->where('nome_setor',  'LIKE', '%' . $request->nome_nivel . '%');
        }

        $nivel = $nivel->orderBy('id_nivel', 'asc')->orderBy('nome_nivel', 'asc')->paginate(10);

        $setor = $setor->orderBy('status', 'asc')->orderBy('nome_setor', 'asc')->paginate(10);


        return view('/setores/Gerenciar-hierarquia', compact('nome_nivel', 'nivel', 'setor', 'nome_setor', 'id_nivel', 'id_setor', 'sigla', 'dt_inicio', 'status', 'nome_substituto'));
    }



    public function obterSetoresPorNivel($id_nivel)
    {
        $set = DB::table('setor as s')->where('id_nivel', $id_nivel)->select('s.nome')->get();

        if ($set->isNotEmpty()) {
            return response()->json($set);
        }

        return response()->json(['message' => 'Nenhum setor encontrado para o ID de nível fornecido']);
    }
}
