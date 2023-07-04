<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
