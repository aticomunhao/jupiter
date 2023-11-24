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
    ->get();







        //dd($lista);

        $usuario = $request->usuario;

        $nome = $request->nome;

        $nome_subsetor = $request->nome_subsetor;

        $sigla = $request->sigla;

        $dt_inicio = $request->dt_inicio;

        $dt_fim = $request->dt_fim;

        if ($request->usuario) {
            $lista->where('s.usuario', 'LIKE', '%' . $request->usuario . '%');
        }

        if ($request->nome) {
            $lista->where('s.nome', 'LIKE', '%' . $request->nome . '%');
        }

        if ($request->nome_subsetor) {
            $lista->where('sub.nome_subsetor', 'LIKE', '%' . $request->nome_subsetor . '%');
        }


        if ($request->sigla) {
            $lista->where('sub.sigla', '=', $request->sigla);
        }

        $lista = $lista->orderBy('sub.sigla', 'asc')->orderBy('s.nome', 'asc')->paginate(10);


        return view('/setores/gerenciar-setor', compact('lista', 'usuario', 'nome', 'dt_inicio', 'dt_fim', 'nome_subsetor', 'sigla'));
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
