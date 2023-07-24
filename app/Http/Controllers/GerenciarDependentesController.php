<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\GerenciarDependentesController;

class GerenciarDependentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $funcionario = DB::select("select f.id, p.nome_completo from funcionario f left join pessoa p on f.id_pessoa = p.id where f.id = $id");
        //dd($funcionario);
        $dependentes = DB::select("select * from dependente where id_pessoa= $id");
        //dd($dependentes);
        return view('/dependentes/gerenciar-dependentes', compact('funcionario', 'dependentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {

        $funcionario_atual = DB::select("select f.id, p.nome_completo from funcionario f left join pessoa p on f.id_pessoa = p.id where f.id = $id");

        $tp_relacao = DB::select("select * from tp_parentesco");



        return view('/dependentes/incluir-dependente', compact('funcionario_atual','tp_relacao'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $funcionario = DB::select("select f.id, p.nome_completo from funcionario f left join pessoa p on f.id_pessoa = p.id where f.id = $id");

        //dd($id);
        DB::table('dependente')->insert([

            'nome_dependente'=> $request->input('nomecomp_dep'),
            'dt_nascimento'=> $request->input('dtnasc_dep'),
            'cpf'=>$request->input('cpf_dep'),
            'id_pessoa'=>$id,
            'id_parentesco'=>$request->input('relacao_dep')

        ]);
        return redirect()->route('Batata', ['id' => $id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('dependente')->where('id', $id)->delete();
        return redirect()->back();
    }
}
