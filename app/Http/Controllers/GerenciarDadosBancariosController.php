<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GerenciarDadosBancariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idf)
    {

        $funcionario = DB::select("select
                            f.id, f.id_pessoa,
                            p.nome_completo
                            from funcionarios f
                            left join pessoas p on f.id_pessoa = p.id
                            where f.id = $idf");


        $idPessoa = strval($funcionario[0]->id_pessoa);

        $contasBancarias = DB::select("select * from dados_bancarios where id_pessoa = $idPessoa");

        return view('dadosBancarios.gerenciar-dados-bancarios', compact('funcionario','contasBancarias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($idf)
    {
        $funcionario = DB::select("select
                            f.id, f.id_pessoa,
                            p.nome_completo
                            from funcionarios f
                            left join pessoas p on f.id_pessoa = p.id
                            where f.id = $idf");


        $idPessoa = strval($funcionario[0]->id_pessoa);
        return view('dadosBancarios.incluir-dados-bancarios',compact('funcionario'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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
    public function destroy(string $id)
    {
        //
    }
}
