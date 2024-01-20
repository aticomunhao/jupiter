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


        $rel_base_salarial = DB::table('base_salarial')
            ->where('id_funcionario', $idf)
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
        $tp_cargo = DB::table('tp_cargo')->get();

        $cargos = DB::table('cargos')->get();
        $cargosRegulares = DB::table('cargos')->where('tp_cargo','=','1')->get();
        $funcaoGratificada =  DB::table('cargos')->where('tp_cargo','=','2')->get();
        $cargoDeConfianca =  DB::table('cargos')->where('tp_cargo','=','3')->get();
        $jovemAprediz =  DB::table('cargos')->where('tp_cargo','=','4')->get();

        return view('basesalarial.cadastrar-base-salarial', compact('cargosRegulares', 'funcaoGratificada',
            'idf','cargoDeConfianca','jovemAprediz','tp_cargo','cargos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $idf)
    {
      echo 'okay';

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
