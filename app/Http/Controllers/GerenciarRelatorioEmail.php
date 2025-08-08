<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GerenciarRelatorioEmail extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $funcionarios = DB::table('funcionarios')
            ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
            ->join('contrato', 'contrato.id_funcionario', '=', 'funcionarios.id')
            ->select(
                'funcionarios.*',
                'pessoas.nome_completo as nome_completo',
                'pessoas.email as email'
            )
            ->where('contrato.dt_fim', null)
            ->orderBy('pessoas.nome_completo')
            ->get();

        return view('relatorios-email.index', compact('funcionarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
