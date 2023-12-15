<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GerenciarFuncaoGratificada extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $funcoesgratificadas = DB::table('funcao_gratificada')->get();

        return view('funcaogratificada.gerenciar-funcao-gratificada', compact('funcoesgratificadas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('funcaogratificada.criar-funcao-gratificada');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->input('data_inicial') == null){
            DB::table('funcao_gratificada')
                ->insert([
                    'nomeFG' => $request->input('nomefuncao'),
                    'salarioFG' => $request->input('salario'),
                    'dt_inicioFG' => $request->input('data_inicial'),
                    'dt_fimFG' => null
                ]);
        }else{
        DB::table('funcao_gratificada')
            ->insert([
                'nomeFG' => $request->input('nomefuncao'),
                'salarioFG' => $request->input('salario'),
                'dt_inicioFG' => $request->input('data_inicial'),
                'dt_fimFG' => $request->input('data_final')
            ]);
        }
        return redirect()->route('IndexGerenciarFuncaoGratificada');
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
