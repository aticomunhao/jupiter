<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Echo_;

class GerenciarAfastamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idf)
    {
        $funcionario = DB::table('funcionarios')
        ->leftjoin('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
        ->where ('funcionarios.id', '=', $idf)
        ->select('funcionarios.id as funcionario_id','pessoas.nome_completo','pessoas.id as pessoas_id')
        ->first();


        return view('afastamentos.gerenciar-afastamentos', compact('funcionario'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($idf)
    {


        $funcionario = DB::table('funcionarios')
        ->leftjoin('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
        ->where ('funcionarios.id', '=', $idf)
        ->select('funcionarios.id as funcionario_id','pessoas.nome_completo','pessoas.id as pessoas_id')
        ->first();

        return view('afastamentos.incluir-afastamento', compact('funcionario'));
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
