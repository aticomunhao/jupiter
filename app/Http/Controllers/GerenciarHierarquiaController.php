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

        $nivel = DB::table('tp_nivel_setor')->select('tp_nivel_setor.id AS id_nivel', 'tp_nivel_setor.nome as nome_nivel')->get();


        $setor = DB::table('setor')
            ->leftJoin('setor AS substituto', 'setor.substituto', '=', 'substituto.id')
            ->select('setor.id AS id_setor', 'setor.nome AS nome_setor', 'setor.sigla', 'setor.dt_inicio', 'setor.status', 'substituto.sigla AS nome_substituto')->get();

        $lista = DB::table('setor AS st')
            ->leftJoin('tp_nivel_setor AS tns', 'st.id_nivel', 'tns.id')
            ->select('st.nome AS nome_setor', 'st.sigla', 'st.dt_inicio', 'st.status', 'st.substituto AS nome_substituto')
            ->where('status', true);

        $nm_nivel = $request->nivel;
        $nome_setor = $request->nome_setor;
        //dd($nm_nivel);

        if ($request->nivel) {
            $lista->where('st.id_nivel', '=', $request->nivel);
        }


        if ($request->nome_setor) {
            $lista->where('st.id', '=', $request->nome_setor);
        }

        $lista = $lista->orderby('st.status', 'ASC')->get();




        return view('/setores/Gerenciar-hierarquia', compact('nome_setor', 'nivel', 'lista'));
    }



    public function obterSetoresPorNivel($id_nivel)
    {
        $set = DB::table('setor as s')
            ->where('id_nivel', $id_nivel)
            ->select('s.nome', 's.id')
            ->get();

        if ($set->isNotEmpty()) {
            return response()
                ->json($set);
        }

        return response()->json(['message' => 'Nenhum setor encontrado para o ID de nível fornecido']);
    }

    public function show(Request $request)
    {

        $nivel = $request->input('nivel');
        $nome_set = $request->input('nome_setor');


        $setor = DB::table('setor')->get();

        $id_nivel_setor = DB::table('setor')
            ->where('id', $nome_set)
            ->value('id_nivel');



        foreach ($setor as $setores) {
            if ($nome_set == $setores->id or $nome_set == $setores->setor_pai) {
                $lista1 = DB::table('tp_nivel_setor AS tns')
                    ->leftJoin('setor AS s', 'tns.id', '=', 's.id_nivel')
                    ->leftJoin('setor AS substituto', 's.substituto', '=', 'substituto.id')
                    ->leftJoin('setor AS setor_pai', 's.setor_pai', '=', 'setor_pai.id')
                    ->where('s.id',  $nome_set)
                    ->select(
                        's.id AS ids',
                        's.nome',
                        's.sigla',
                        's.dt_inicio',
                        's.dt_fim',
                        's.status',
                        's.setor_pai',
                        'substituto.sigla AS nome_substituto'
                    )->get();


                $lista2 = DB::table('setor AS s')->where('s.setor_pai', $nome_set)->get();


                $lista3 = DB::table('setor AS s')
                    ->join('tp_nivel_setor AS n', 's.id_nivel', '=', 'n.id')
                    ->where('n.id', '>', $id_nivel_setor)
                    ->whereNull('s.setor_pai')
                    ->select('s.*')->get();


                $lista = [
                    $lista1,
                    $lista2,
                    $lista3,
                ];


                dd($lista);

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

                $nivel = $nivel->orderBy('id_nivel', 'asc')->orderBy('nome_nivel');
                $lista = $setor->orderBy('status', 'asc')->orderBy('nome_setor');


                return view('/setores/Gerenciar-hierarquia', compact('nome_nivel', 'nivel', 'lista', 'nome_setor', 'id_nivel', 'id_setor', 'sigla', 'dt_inicio', 'status', 'nome_substituto'));
            }
        }
    }
}
