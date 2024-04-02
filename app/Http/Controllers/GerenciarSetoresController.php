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


class GerenciarSetoresController extends Controller
{
    public function index(Request $request)
    {

        $lista = DB::table('tp_nivel_setor AS tns')
            ->whereIn('tns.id', ['1', '2', '3'])
            ->leftJoin('setor AS s', 'tns.id', '=', 's.id_nivel')
            ->leftJoin('setor AS substituto', 's.substituto', '=', 'substituto.id')
            ->leftJoin('setor AS setor_pai', 's.setor_pai', '=', 'setor_pai.id')
            ->select(
                DB::raw('CASE WHEN s.dt_fim IS NULL THEN \'Ativo\' ELSE \'Inativo\' END AS status'),
                's.id AS ids',
                's.nome',
                's.sigla',
                's.dt_inicio',
                's.dt_fim',
                'setor_pai.nome AS setor_pai',
                'substituto.sigla AS nome_substituto'
            );


        //dd($lista);

        $ids = $request->ids;

        $nome = $request->nome;

        $sigla = $request->sigla;

        $dt_inicio = $request->dt_inicio;

        $dt_fim = $request->dt_fim;

        $setor_pai = $request->setor_pai;

        $nome_substituto = $request->nome_substituto;


        if ($request->nome) {
            $lista->where('s.nome', 'LIKE', '%' . $request->nome . '%');
        }

        if ($request->sigla) {
            $lista->where('s.sigla', '=', $request->sigla);
        }

        if ($request->nome_substituto) {
            $lista->where('s.substituto', '=', $request->nome_substituto);
        }

        $lista = $lista->orderBy('s.sigla', 'asc')->orderBy('s.nome', 'asc')->orderBy('nome_substituto', 'asc')->paginate(10);


        return view('/setores/gerenciar-setor', compact('lista', 'nome', 'dt_inicio', 'dt_fim', 'sigla', 'ids', 'nome_substituto', 'setor_pai'));
    }


    public function create(Request $request)
    {
        $nivel = DB::select('select id AS idset, nome from tp_nivel_setor');


        // dd($nivel);

        return view('/setores/incluir-setor', compact('nivel'));
    }


    public function store(Request $request)
    {

        DB::table('setor')
            ->insert([
                'nome' => $request->input('nome_setor'),
                'sigla' => $request->input('sigla'),
                'dt_inicio' => $request->input('dt_inicio'),
                'id_nivel' => $request->input('nivel'),


            ]);




        app('flasher')->addSuccess('Setor cadastrado com Sucesso!');

        return redirect('/gerenciar-setor');
    }


    public function edit($ids)
    {

        $editar = DB::table('setor AS s')
            ->leftJoin('tp_nivel_setor AS tns',  's.id_nivel', '=', 'tns.id')
            ->select('s.id AS ids', 's.sigla',  's.nome', 's.dt_inicio', 's.dt_fim', 's.id_nivel', 'tns.nome AS nome_nivel')
            ->where('s.id', $ids)->get();

        $nivel = DB::select('select id AS idset, nome from tp_nivel_setor');


        return view('/setores/editar-setor', compact('editar', 'nivel'));
    }


    public function update(Request $request, $ids)
    {


        DB::table('setor')
            ->where('id', $ids)
            ->update([
                'nome' => $request->input('nome'),
                'sigla' => $request->input('sigla'),
                'dt_inicio' => $request->input('dt_inicio'),
                'dt_fim' => $request->input('dt_fim'),
                'id_nivel' => $request->input('nivel')
            ]);


        app('flasher')->addSuccess('Edição feita com Sucesso!');

        return redirect()->action([GerenciarSetoresController::class, 'index']);
    }


    public function carregar_dados($ids)
    {


        $setor = DB::table('setor')->get();

        Session::flash('ids', $ids);


        return view('/setores/substituir-setor', compact('setor'));
    }

    public function subst(Request $request, string $ids)
    {

        $ids = session('ids');
        $up = $request->input('setor_substituto');

        $alterar_setor_pai = DB::table('setor')
            ->where('setor_pai', $ids)
            ->update([
                'setor_pai' => $up,
            ]);


        $alterar_setor_substituto = DB::table('setor')
            ->where('id', $ids)
            ->update([
                'substituto' => $up,
            ]);

        $dataFim = DB::table('setor')->where('id', $up)->get();

        DB::table('setor')->where('id', $ids)->update(['dt_fim' => $dataFim[0]->dt_inicio]);


        app('flasher')->addSuccess('Setor foi substituído com sucesso.');
        return redirect()->action([GerenciarSetoresController::class, 'index']);
    }

    public function delete($ids)
    {

        $deletar = DB::table('setor AS s')->where('s.id', $ids)->delete();



        app('flasher')->addSuccess('O cadastro do Setor foi Removido com Sucesso.');
        return redirect()->action([GerenciarSetoresController::class, 'index']);
    }
}
