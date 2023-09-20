<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GerenciarCertificadosController extends Controller
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

        $certificados = DB::select("select cert.id, cert.nome,cert.dt_conclusao,ga.nome_grauacad,tpne.nome_tpne,tpee.nome_tpee,tp_ent_e.nome_tpentensino from certificados as cert
        join grau_academico as ga on ga.id= cert.id_grau_acad
        join tp_nivel_ensino as tpne on tpne.id = cert.id_nivel_ensino
        join tp_etapas_ensino as tpee on tpee.id = cert.id_etapa
        join tp_entidades_ensino as tp_ent_e on tp_ent_e.id=cert.id_entidade_ensino
        where cert.id_funcionario =$idf;");

        return view(
            'certificados.gerenciar-certificados ',
            compact('certificados', 'funcionario')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($idf)
    {
        $funcionario = DB::select("select
                            f.id,
                            p.nome_completo
                            from funcionarios f
                            left join pessoas p on f.id_pessoa = p.id
                            where f.id = $idf");

        $grau_academico = DB::select("select * from grau_academico");

        $tp_nivel_ensino = DB::select("select * from tp_nivel_ensino");

        $tp_etapas_ensino = DB::select("select * from tp_etapas_ensino");
        $tp_entidades_ensino = DB::select("select * from tp_entidades_ensino");

        return view('certificados.incluir-certificados', 'funcionario', 'grau_academico', 'tp_nivel_ensino', 'tp_etapas_ensino','tp_entidades_ensino');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
