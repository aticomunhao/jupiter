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



        $idFunc = strval($funcionario[0]->id);

        $contasBancarias = DB::select("SELECT rel_dados_bancarios.id,
        rel_dados_bancarios.id_funcionario,
        rel_dados_bancarios.nmr_conta,
        rel_dados_bancarios.dt_inicio,
        rel_dados_bancarios.dt_fim,
        tp_banco_ag.desc_agen,
        desc_ban.nome,
        tp_banco_ag.agencia,
        tp_conta.nome_tipo_conta,
        tp_sub_tp_conta.descricao
        FROM public.rel_dados_bancarios
        join tp_banco_ag on rel_dados_bancarios.id_banco_ag =tp_banco_ag.id
        join desc_ban on rel_dados_bancarios.id_desc_banco=desc_ban.id
        join tp_conta on rel_dados_bancarios.id_tp_conta = tp_conta.id
        join tp_sub_tp_conta on rel_dados_bancarios.id_subtp_conta = tp_sub_tp_conta.id
        where rel_dados_bancarios.id_funcionario = $idFunc;");

        dd($contasBancarias);


        return view('dadosBancarios.gerenciar-dados-bancarios', compact('funcionario', 'contasBancarias'));
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
        $codigosDosBancos = DB::select("select * from tp_bancos");

        return view('dadosBancarios.incluir-dados-bancarios', compact('funcionario'));
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
