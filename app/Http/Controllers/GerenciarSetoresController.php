<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use iluminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\CollectionorderBy;
use Carbon\Carbon;


class GerenciarSetoresController extends Controller
{
    public function index(Request $request)
    {

        $lista = DB::table('tp_nivel_setor AS tns')
        ->whereIn('tns.id', ['1', '2'])
        ->leftJoin('setor AS s', 'tns.id', '=', 's.id_nivel')
        ->leftJoin('setor AS substituto', 's.substituto', '=', 'substituto.id')
        ->leftJoin('setor AS setor_pai', 's.setor_pai', '=', 'setor_pai.id')
        ->select(
            's.id AS ids', 
            's.nome', 
            's.sigla', 
            's.dt_inicio', 
            's.dt_fim', 
            's.status', 
            'setor_pai.nome AS setor_pai', 
            'substituto.sigla AS nome_substituto');
                
      
            //dd($lista);

        $ids = $request->ids;

        $nome = $request->nome;

        $sigla = $request->sigla;

        $dt_inicio = $request->dt_inicio;

        $dt_fim = $request->dt_fim;

        $setor_pai = $request->setor_pai;

        $nome_substituto = $request->nome_substituto;

        $status = $request->status;
 
        if ($request->nome) {
            $lista->where('s.nome', 'LIKE', '%' . $request->nome . '%');
        }

        if ($request->sigla) {
            $lista->where('s.sigla', '=', $request->sigla);
        }

        if ($request->nome_substituto){
            $lista->where('s.substituto', '=', $request->nome_substituto);
        }
        $lista = $lista->orderBy('s.sigla', 'asc')->orderBy('s.nome', 'asc')->orderBy('nome_substituto', 'asc')->paginate(10);


        return view('/setores/gerenciar-setor', compact('lista','nome', 'dt_inicio', 'dt_fim', 'sigla', 'ids', 'nome_substituto', 'setor_pai', 'status'));
    }


    public function create()
    {



        return view('/setores/incluir-setor');
    }



    public function insert(Request $request)
    {

        DB::table('setor')
            ->insert([
                'nome' => $request->input('nome'),
                'sigla' => $request->input('sigla'),
                'dt_inicio' => $request->input('dt_inicio'),
                'dt_fim' => $request->input('dt_fim'),
                'usuario' => $request->input('usuario')
            ]);


        DB::table('subsetor')
            ->insert([
                'nome_subsetor' => $request->input('nome_subsetor'),
                'sigla' => $request->input('sigla')
            ]);

        $id_subsetor = DB::table('subsetor')
            ->select(DB::raw('MAX(id) as max_id'))
            ->value('max_id');

        $id_setor = DB::table('setor')
            ->select(DB::raw('MAX(id) as max_id'))
            ->value('max_id');

        app('flasher')->addSuccess('Edição feita com Sucesso!');

        return redirect('/gerenciar-setor');


    }



    public function edit($idsb)
    {

        $editar = DB::table('subsetor AS sub')
            ->leftJoin('setor AS s', 'sub.id_setor', '=', 's.id')
            ->select('sub.id AS idsb', 's.id AS ids', 'sub.sigla', 'sub.nome_subsetor', 's.nome', 's.dt_inicio', 's.dt_fim', 's.usuario')->where('sub.id', $idsb)->get();
        //dd($editar);


        return view('/setores/editar-setor', compact('editar'));

    }


    public function update(Request $request, $idsb, $ids)
    {



        DB::table('setor')
            ->where('id', $ids)
            ->update([
                'nome' => $request->input('nome'),
                'sigla' => $request->input('sigla'),
                'dt_inicio' => $request->input('dt_inicio'),
                'dt_fim' => $request->input('dt_fim'),
                'usuario' => $request->input('usuario')
            ]);


        DB::table('subsetor')
            ->where('id', $idsb)
            ->update([
                'nome_subsetor' => $request->input('nome_subsetor'),
                'sigla' => $request->input('sigla')
            ]);



        app('flasher')->addSuccess('Edição feita com Sucesso!');

        return redirect()->action([GerenciarSetoresController::class, 'index']);

    }





    public function delete($ids, $idsb)
    {

        $del = DB::table('subsetor AS sub')
            ->leftJoin('setor AS s', 'sub.id_setor', '=', 's.id')
            ->select('sub.id AS idsb', 's.id AS ids', 'sub.sigla', 'sub.nome_subsetor')->where('sub.id', $ids);

        $del1 = DB::table('setor as s')->select('s.id AS ids', 's.nome', 's.sigla', 's.dt_inicio', 's.dt_fim', 's.usuario')->where('s.id', $idsb);

        app('flasher')->addSuccess('O cadastro do Setor foi Removido com Sucesso.');
        return redirect()->action([GerenciarSetoresController::class, 'index']);
    }
}
