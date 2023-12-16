<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GerenciarFuncaoGratificada extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $search = request('search');
        if (request('search')) {
            $funcoesgratificadas = DB::table('funcao_gratificada')
                ->where('nomeFG', 'ilike', '%' . $search . '%')
                ->get();
        } else {
            $funcoesgratificadas = DB::table('funcao_gratificada')->get();
        }


        return view('funcaogratificada.gerenciar-funcao-gratificada', compact('funcoesgratificadas', 'search'));
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
        $dataDeHoje = Carbon::today()->toDateString();

        $idfuncaoGratificada = DB::table('funcao_gratificada')
            ->insertGetId([
                'nomeFG' => $request->input('nomefuncao'),
                'salarioFG' => $request->input('salario'),
                'dt_inicioFG' => $request->input('data_inicial'),
                'dt_fimFG' => null,
                'status' => true
            ]);
        DB::table('hist_funcao_gratificada')
            ->insert([
                'idFG' => $idfuncaoGratificada,
                'salario' => $request->input('salario'),
                'motivo' => 'Abertura da Conta',
                'datamod' => $dataDeHoje
            ]);

        app('flasher')->addSuccess('Função Gratificada adicionada com Sucesso!');
        return redirect()->route('IndexGerenciarFuncaoGratificada');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $funcaogratificada = DB::table('funcao_gratificada')
            ->where('id', $id)
            ->first();

        return view('funcaogratificada.editar-funcao-gratificada', compact('funcaogratificada'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::table('funcao_gratificada')
            ->where('id', $id)
            ->update([
                'nomeFG' => $request->input('nomecargo'),
                'dt_inicioFG' => $request->input('data_inicial'),
                'dt_fimFG' => $request->input('data_final'),
                'salarioFG' => $request->input('salario'),

            ]);
        return redirect()->route('IndexGerenciarFuncaoGratificada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function close(string $id, Request $request)
    {
        $funcaogratificada = DB::table('funcao_gratificada')
            ->where('id', $id)
            ->first();

        $dataDeHoje = Carbon::today()->toDateString();
        DB::table('funcao_gratificada')
            ->where('id', $id)
            ->update([
                'status' => false
            ]);
        DB::table('hist_funcao_gratificada')
            ->insert([
                'idFG' => $id,
                'salario' => $funcaogratificada->salarioFG,
                'motivo' => 'Encerramento de Conta',
                'datamod' => $dataDeHoje
            ]);
        return redirect()->route('IndexGerenciarFuncaoGratificada');
    }
}
