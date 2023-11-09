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
        desc_ban.nome,
        tp_banco_ag.desc_agen,
        tp_banco_ag.agencia,
        tp_conta.nome_tipo_conta,
        tp_sub_tp_conta.descricao
        FROM public.rel_dados_bancarios
        JOIN tp_banco_ag ON rel_dados_bancarios.id_banco_ag = tp_banco_ag.id
        JOIN desc_ban ON rel_dados_bancarios.id_desc_banco = desc_ban.id
        JOIN tp_conta ON rel_dados_bancarios.id_tp_conta = tp_conta.id
        JOIN tp_sub_tp_conta ON rel_dados_bancarios.id_subtp_conta = tp_sub_tp_conta.id
        WHERE rel_dados_bancarios.id_funcionario = $idFunc;");


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
        $desc_bancos = DB::select('select * from desc_ban order by id');
        $tp_banco_ags =  DB::select("SELECT * FROM public.tp_banco_ag order by agencia");
        $tp_contas = DB::select('select * from tp_conta');
        $tp_sub_tp_contas = DB::select('select * from tp_sub_tp_conta');


        return view('dadosBancarios.incluir-dados-bancarios', compact('funcionario', 'tp_banco_ags', 'desc_bancos', 'tp_contas', 'tp_sub_tp_contas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $idf)
    {
        DB::table('rel_dados_bancarios')->insert([
            'id_funcionario' => $idf,
            'id_banco_ag' => $request->input('tp_banco_ag'),
            'dt_inicio' => $request->input('dt_inicio'),
            'dt_fim' => $request->input('dt_fim'),
            'nmr_conta' => $request->input('nmr_conta'),
            'id_desc_banco' => $request->input('desc_banco'),
            'id_tp_conta' => $request->input('tp_conta'),
            'id_subtp_conta' => $request->input('tp_sub_tp_conta')
        ]);

        return redirect()->route('DadoBanc', ['id' => $idf]);
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
    public function destroy(string $idf)
    {
        DB::table('rel_dados_bancarios')->where('id',$idf)->delete();
        return redirect()->back();
    }
}
