<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\ViewExterna;

class GerenciarViewsController extends Controller
{
    public function index()
    {

        $grupos =  DB::table('grupo')
            ->leftJoin('setor', 'grupo.id_setor', '=', 'setor.id')
            ->select(
                'grupo.id',
                'grupo.nome',
                // 'grupo.descricao',
                'setor.sigla as nome_setor',
                'setor.id as id_setor'
            )
            ->orderBy('nome')->get();

        // dd($grupos);

        return view('dados_externos.index', compact('grupos'));
    }


    public function show($id)
    {
        $grupo = DB::table('grupo')
            ->join('cronograma', 'grupo.id', '=', 'cronograma.id_grupo')
            ->join('membro', 'membro.id_cronograma', '=', 'cronograma.id')
            ->join('associado', 'associado.id', '=', 'membro.id_associado')
            ->select('associado.id as id_associado')
            ->where('grupo.id', $id)
            ->get();

        // Extrair os IDs em um array simples
        $ids = $grupo->pluck('id_associado')->toArray();
        dd($ids);

        // dd($grupo);

        DB::connection('sqlsr')
    }
}
