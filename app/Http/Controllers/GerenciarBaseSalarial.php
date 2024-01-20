<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GerenciarBaseSalarial extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idf)
    {


        $rel_base_salarial = DB::table('rel_base_salarial')
            ->where('id_bs', $idf)
            ->get();

        if ($rel_base_salarial->isEmpty()) {
            return redirect()->route('IncluirBaseSalarial', ['idf' => $idf]);
        } else {
            // Add your logic here if needed
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($idf)
    {

        $cargosregulares = DB::table('cargo_regular')->get();
        $funcaogratificada = DB::table('funcao_gratificada')->get();

        return view('basesalarial.cadastrar-base-salarial', compact('cargosregulares', 'funcaogratificada', 'idf'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $idf)
    {
        $funcionario = DB::table('funcionarios')
            ->join('pessoas as p','id_pessoa', '=','p.id')
            ->where('funcionarios.id', $idf)
            ->first();

        dd($funcionario);
        $cargoregular = $request->input('cargoregular');
        $funcaograrificada = $request->input('funcaogratificada');
        $idfuncionario = $idf;


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