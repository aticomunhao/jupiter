<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GerenciarDependentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idf)
    {
        $funcionario = DB::select("select
                            f.id,
                            p.nome_completo
                            from funcionarios f
                            left join pessoas p on f.id_pessoa = p.id
                            where f.id = $idf");
        //dd($funcionario);


        $dependentes = DB::select("select
                            d.id,
                            d.id_funcionario,
                            d.id_parentesco,
                            d.nome_dependente,
                            d.dt_nascimento,
                            d.cpf,
                            tpp.nome
                            from dependentes d
                            left join tp_parentesco tpp on d.id_parentesco = tpp.id
                            where d.id_funcionario = $idf");

        //dd($dependentes);
        return view('/dependentes/gerenciar-dependentes', compact('funcionario', 'dependentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {

        $funcionario_atual = DB::select("select f.id, p.nome_completo from funcionarios f left join pessoas p on f.id_pessoa = p.id where f.id = $id");

        $tp_relacao = DB::select("select * from tp_parentesco");



        return view('/dependentes/incluir-dependente', compact('funcionario_atual','tp_relacao'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $funcionario = DB::select("select f.id, p.nome_completo from funcionarios f left join pessoas p on f.id_pessoa = p.id where f.id = $id");

        $vercpf = DB::table('dependentes')
                    ->get('cpf');

                    $cpf = $request->cpf;

                    if ( $request->$cpf == $vercpf){


                        app('flasher')->addError('Existe outro cadastro usando este número de CPF');

                        return redirect()->route('Batata', ['id' => $id]);


                    }else{
                        DB::table('dependentes')->insert([

                            'nome_dependente'=> $request->input('nomecomp_dep'),
                            'dt_nascimento'=> $request->input('dtnasc_dep'),
                            'cpf'=>$request->input('cpf_dep'),
                            'id_funcionario'=>$id,
                            'id_parentesco'=>$request->input('relacao_dep')

                        ]);
                    }



        app('flasher')->addSuccess('O cadastro do dependente foi realizado com sucesso.');
        return redirect()->route('Batata', ['id' => $id]);
        }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dependente = DB::table('dependentes')->where('id',$id)->first();
        $funcionario = DB::select("select f.id, p.nome_completo from funcionarios f left join pessoas p on f.id_pessoa = p.id where f.id = $id");
        $tp_relacao = DB::select("select * from tp_parentesco");



        return view('/dependentes/editar-dependentes',compact('dependente','tp_relacao','funcionario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //$idf = DB::select("select id_funcionario from dependentes d where d.id = $id");
        $idf = DB::table('dependentes AS d') -> where('id', $id)->select('id_funcionario')->value('id_funcionario');


        DB::table('dependentes')
        ->where('id', $id)
        ->update([
        'nome_dependente' => $request->input('nomecomp_dep'),
        'cpf'=> $request->input('cpf_dep'),
        'dt_nascimento' => $request->input('dtnasc_dep'),
        'id_parentesco'=> $request->input('relacao_dep')
        ]);

        return redirect()->route('Potato',['id'=>$idf]);
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
