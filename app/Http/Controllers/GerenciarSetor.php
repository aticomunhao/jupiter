<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GerenciarSetor extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $setores = DB::table('setor AS s')
                    ->leftJoin('tp_rotas_setor as rs', 's.id', 'rs.id_setor')
                    ->select('s.id AS sid', 's.nome', 's.sigla');

        $pesquisa = $request->nome_pesquisa;
        if ($request->nome_pesquisa) {
            $setores = $setores->where(function ($query) use ($pesquisa) {
                $query->where('nome', 'ilike', "%$pesquisa%");
                $query->orWhere('sigla', 'ilike', "%$pesquisa%");
            });
        }

        $setores = $setores->groupBy('s.id')->orderBy('s.nome')->get();
        return view('setor.gerenciar-setor', compact('setores'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $setores = DB::table('setor')->whereNull('dt_fim')->orderBy('nome')->get();
        $rotas = DB::table('tp_rotas_jupiter')->orderBy('tp_rotas_jupiter.nome', 'ASC')->get();
        return view('setor.criar-setor', compact('rotas', 'setores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        foreach ($request->rotas as $rota) {
            DB::table('tp_rotas_setor')->insert([
                'id_setor' => $request->setor,
                'id_rotas' => $rota
            ]);
        }

        return redirect('/gerenciar-setor-usuario');

    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $setor = DB::table('setor')->where('id', $id)->first();
            $rotas = DB::table('tp_rotas_setor')->leftJoin('tp_rotas_jupiter', 'tp_rotas_setor.id_rotas', 'tp_rotas_jupiter.id')->where('id_setor', $id)->orderBy('tp_rotas_jupiter.nome', 'ASC')->get();

            return view('setor.visualizar-setor', compact('setor', 'rotas'));
        } catch (\Exception $e) {

            $code = $e->getCode();
            return view('administrativo-erro.erro-inesperado', compact('code'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $setor = DB::table('setor')->where('id', $id)->first();
        $setores = DB::table('setor')->whereNull('dt_fim')->orderBy('nome')->get();
        $rotas = DB::table('tp_rotas_jupiter')->get();
        $rotasSelecionadas = DB::table('tp_rotas_setor')->leftJoin('tp_rotas_jupiter', 'tp_rotas_setor.id_rotas', 'tp_rotas_jupiter.id')->where('id_setor', $id)->orderBy('tp_rotas_jupiter.nome', 'ASC')->pluck('id_rotas');

        return view('setor.editar-setor', compact('setor', 'setores', 'rotas', 'rotasSelecionadas'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        DB::table('tp_rotas_setor')->where('id_setor', $id)->delete();

        foreach ($request->rotas as $rota) {
            DB::table('tp_rotas_setor')->insert([
                'id_setor' => $id,
                'id_rotas' => $rota
            ]);
        }
            
        app('flasher')->addSuccess('As rotas foram redefinidas!');
        
        return redirect('/gerenciar-setor-usuario');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('tp_rotas_setor')->where('id_setor', $id)->delete();

        app('flasher')->addSuccess('As rotas foram excluidas!');

        return redirect('/gerenciar-setor-usuario');
    }
}
