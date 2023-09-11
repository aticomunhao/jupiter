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
  
        $certificados = DB::select("SELECT id, dt_conclusao, id_nivel_ensino, id_grau_acad, id_etapa, id_entidade_ensino, id_funcionario, nome
        FROM certificados
        where id_funcionario  = $idf");

        return view('certificados.gerenciar-certificados',
        compact('certificados', 'funcionario'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($idf)
    {

        return view('certificados.incluir-certificados');
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
